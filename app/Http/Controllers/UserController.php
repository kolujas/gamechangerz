<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Assigment;
    use App\Models\Auth as AuthModel;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\MercadoPago;
    use App\Models\Post;
    use App\Models\Price;
    use App\Models\Teampro;
    use App\Models\User;
    use Auth;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use DB;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Intervention\Image\ImageManagerStatic as Image;
    use MercadoPago\Item;
    use MercadoPago\Preference;
    use MercadoPago\SDK;
    use Storage;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return [type]
         */
        public function profile (Request $request, $slug) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            $user = User::where('slug', '=', $slug)->with('reviews', 'posts')->get()[0];
            $user->and(['achievements', 'games', 'role']);
            foreach ($user->games as $game) {
                $game->and(['files']);
            }
            if ($user->id_role === 2) {
                if (!Auth::check()) {
                    $request->session()->put('error', [
                        'code' => 404,
                        'message' => "User \"$slug\" does not exist",
                    ]);
                    return redirect()->back();
                }
                return redirect('/panel');
            }
            if ($user->id_role === 1) {
                $user->and(['abilities', 'files', 'languages', 'prices', 'teampro', 'days']);
                $days = Day::allDates($user->days);
            }
            if ($user->id_role === 0) {
                $user->and(['friends', 'lessons', 'hours', 'files']);
                $days = [];
            }
            foreach ($user->reviews as $review) {
                $review->and(['abilities', 'lesson', 'users']);
                $review->users['from']->and(['files']);
                $review->users['to']->and(['files']);
                if ($review->users['from']->id_role === 1) {
                    $review->users['from']->and(['teampro']);
                }
                if ($review->users['to']->id_role === 1) {
                    $review->users['to']->and(['teampro']);
                }
                if ($user->id_role === 0) {
                    $review->and(['game']);
                    $review->game->and(['files']);
                }
                foreach ($review->abilities as $review_ability) {
                    $review->stars = (isset($review->stars) ? $review->stars : 0) + $review_ability->stars;
                    if ($user->id_role === 1) {
                        foreach ($user->abilities as $user_ability) {
                            if ($user_ability->id_ability === $review_ability->id_ability) {
                                $user_ability->stars = $user_ability->stars + $review_ability->stars;
                            }
                        }
                    }
                    if ($user->id_role === 0) {
                        foreach ($user->games as $game) {
                            foreach ($game->abilities as $ability) {
                                if ($ability->id_ability === $review_ability->id_ability) {
                                    $ability->stars = $ability->stars + $review_ability->stars;
                                }
                            }
                        }
                    }
                }
                if (count($review->abilities)) {
                    $review->stars = $review->stars / count($review->abilities);
                }
            }
            if ($user->id_role === 1) {
                if (count($user->reviews)) {
                    foreach ($user->abilities as $ability) {
                        $ability->stars = $ability->stars / count($user->reviews);
                    }
                }
            }
            if ($user->id_role === 0) {
                $user->friends_length = 0;
                foreach ($user->friends as $friend) {
                    $friend->and(['users']);
                    if ($friend->accepted) {
                        $user->friends_length++;
                    }
                }
                if (count($user->reviews)) {
                    foreach ($user->games as $game) {
                        foreach ($game->abilities as $ability) {
                            $ability->stars = $ability->stars / count($user->reviews);
                        }
                    }
                }
            }
            if (Auth::check()) {
                if (Auth::user()->slug !== $user->slug && $user->id_role === 0) {
                    $user->isFriend = 0;
                    foreach ($user->friends as $friend) {
                        if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                            if ($friend->accepted) {
                                $user->isFriend = 2;
                            }
                            if (!$friend->accepted) {
                                $user->isFriend = 1;
                                $user->id_user_request = $friend->id_user_from;
                            }
                        }
                    }
                }
            }
            foreach ($user->posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
            }
            $games = Game::all();
            foreach ($games as $game) {
                $game->and(['files']);
            }
            $languages = Language::all();
            return view('user.profile', [
                'user' => $user,
                'games' => $games,
                'languages' => $languages,
                'days' => $days,
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'languages' => (object)[
                        'rules' => Language::$validation['user']['rules'],
                        'messages' => Language::$validation['user']['messages']['es'],
                ], 'assigment' => (object)[
                        'rules' => Assigment::$validation['make']['rules'],
                        'messages' => Assigment::$validation['make']['messages']['es'],
                ], 'update' => (object)[
                        'rules' => User::$validation[($user->id_role === 0 ? 'user' : 'teacher')]['update']['rules'],
                        'messages' => User::$validation[($user->id_role === 0 ? 'user' : 'teacher')]['update']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the User search page.
         * @return [type]
         */
        public function search (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('user.search', [
                'games' => Game::all(),
                'error' => $error,
                'search' => (object)[
                    'username' => $request->username,
                ],
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'assigment' => (object)[
                    'rules' => Assigment::$validation['make']['rules'],
                    'messages' => Assigment::$validation['make']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the checkout page.
         * @param string $slug User slug.
         * @param string $type User type of Lesson.
         * @return [type]
         */
        public function checkout (Request $request, $slug, $type) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            $user = User::where('slug', '=', $slug)->get()[0];
            $user->and(['lessons', 'prices', 'days']);
            foreach ($user->lessons as $lesson) {
                $lesson->and(['days']);
            }
            foreach ($user->prices as $price) {
                if ($price->slug === $type) {
                    $type = $price;
                }
            }
            return view('user.checkout', [
                'user' => $user,
                'type' => $type,
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'assigment' => (object)[
                        'rules' => Assigment::$validation['make']['rules'],
                        'messages' => Assigment::$validation['make']['messages']['es'],
                ], 'checkout' => (object)[
                        'rules' => Lesson::$validation['checkout'][$type->slug]['rules'],
                        'messages' => Lesson::$validation['checkout'][$type->slug]['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Update an User.
         * @param Request $request
         * @param string $slug User slug
         * @return [type]
         */
        public function update (Request $request, $slug) {
            $user = User::where('slug', '=', $slug)->get()[0];
            $user->and(['files']);
            
            $input = (object) $request->all();
            
            $validator = Validator::make((array) $input, User::replaceUniqueIDUser(User::$validation[($user->id_role === 0 ? 'user' : 'teacher')]['update']['rules'], $user->id_user), User::$validation[($user->id_role === 0 ? 'user' : 'teacher')]['update']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($user->username !== $input->username) {
                $input->slug = SlugService::createSlug(User::class, 'slug', $input->username);
            }
            
            if ($request->hasFile('profile')) {
                $filepath = "users/$user->id_user/01-profile." . $request->profile->extension();
                if (isset($user->files['profile'])) {
                    Storage::delete($user->files['profile']);
                }
                
                $file = Image::make($request->file('profile'))
                        ->resize(350, 400, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });

                Storage::put($filepath, (string) $file->encode());
            }

            if ($user->id_role === 0) {
                if (!isset($input->teammate)) {
                    $input->teammate = 0;
                } else {
                    $input->teammate = 1;
                }
                if (!isset($input->name)) {
                    $input->name = null;
                }
            
                if ($request->hasFile('banner')) {
                    $filepath = "users/$user->id_user/02-banner." . $request->banner->extension();
                    if (isset($user->files['banner'])) {
                        Storage::delete($user->files['banner']);
                    }
                    
                    $file = Image::make($request->file('banner'))
                            ->resize(1349, 395, function($constrait){
                                $constrait->aspectRatio();
                                $constrait->upsize();
                            });
    
                    Storage::put($filepath, (string) $file->encode());
                }
            }

            if ($user->id_role === 1) {
                if (!isset($input->description)) {
                    $input->description = null;
                }
                $input->days = Day::stringify($input->days);
                $input->prices = Price::stringify($input->prices);
                $input->teampro = Teampro::stringify($input->teampro_name);
            
                if ($request->hasFile('teampro_logo')) {
                    $filepath = "users/$user->id_user/02-teampro." . $request->teampro_logo->extension();
                    if (isset($user->files['teampro'])) {
                        Storage::delete($user->files['teampro']);
                    }
                    
                    $file = Image::make($request->file('teampro_logo'))
                            ->resize(40, 56, function($constrait){
                                $constrait->aspectRatio();
                                $constrait->upsize();
                            });
    
                    Storage::put($filepath, (string) $file->encode());
                }
            }

            unset($user->files);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with('status', [
                'code' => 200,
                'message' => 'Perfil actualizado correctamente.',
            ]);
        }
    }