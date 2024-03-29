<?php
    namespace App\Http\Controllers;

    use App\Models\Assignment;
    use App\Models\Auth as AuthModel;
    use App\Models\Day;
    use App\Models\Discord;
    use App\Models\Game;
    use App\Models\Hour;
    use App\Models\Language;
    use App\Models\Mail;
    use App\Models\MercadoPago;
    use App\Models\Method;
    use App\Models\Platform;
    use App\Models\Presentation;
    use App\Models\Price;
    use App\Models\Review;
    use App\Models\Teampro;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Intervention\Image\ImageManagerStatic as Image;
    use Storage;

    class UserController extends Controller {
        /**
         * * Control the User profile page.
         * @param string $slug User slug.
         * @return \Illuminate\Http\Response
         */
        public function profile (Request $request, $slug) {
            $lessons = [];
            if ($request->session()->has("lessons")) {
                $lessons = (object) $request->session()->pull("lessons");
                foreach ($lessons as $lesson) {
                    $lesson->and(["abilities"]);
                }
            }

            $user = User::bySlug($slug)->first();
            $user->and(["achievements", "games", "role", "languages", "posts"]);
            
            if ($user->id_role == 2) {
                if (!Auth::check() || Auth::user()->id_user != $user->id_user) {
                    return redirect()->back()->with('status', [
                        'code' => 404,
                        'message' => "User \"$slug\" does not exist",
                    ]);
                }
                return redirect("/panel");
            }

            if ($user->id_role === 0) {
                $user->and(["hours", "reviews"]);
                $days = [];
                $user->friends_length = 0;

                foreach ($user->friends as $friend) {
                    if ($friend->accepted) {
                        $user->friends_length++;
                    }
                }
            }
            if ($user->id_role === 1) {
                $user->and(["abilities", "prices", "teampro", "days"]);
                $days = Day::options();

                foreach ($days as $day) {
                    foreach ($user->days as $userDay) {
                        if ($day->id_day === $userDay->id_day) {
                            $day->hours = Hour::options($userDay->hours->toArray());
                            continue 2;
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
                $game->and(["colors", "files", "abilities"]);
            }

            $languages = Language::options();

            // ddd("storage/". $user->friends[0]->not($user->id_user)->files['profile']);

            return view("user.profile", [
                "days" => $days,
                "dolar" => Platform::dolar(),
                "games" => $games,
                "languages" => $languages,
                "lessons" => $lessons,
                "user" => $user,
                // "notifications" => $notifications,
            ]);
        }

        /**
         * * Control the User search page.
         * @return \Illuminate\Http\Response
         */
        public function search (Request $request) {
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            $games = Game::all();
            foreach ($games as $game) {
                $game->and(["abilities"]);
            }

            return view("user.search", [
                "games" => $games,
                // "notifications" => $notifications,
                "search" => (object)[
                    "username" => $request->username,
                ],
            ]);
        }

        /**
         * * Update an User.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug User slug
         * @return \Illuminate\Http\Response
         */
        public function update (Request $request, $slug) {
            $user = User::bySlug($slug)->first();
            
            $input = (object) $request->all();
            
            $validator = Validator::make((array) $input, Controller::replaceUnique(User::$validation[($user->id_role === 0 ? "user" : "coach")]["update"]["rules"], $user->id_user), User::$validation[($user->id_role === 0 ? "user" : "coach")]["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($user->username !== $input->username) {
                $input->slug = SlugService::createSlug(User::class, "slug", $input->username);
            }
            
            if ($request->hasFile("profile")) {
                $filepath = "users/$user->id_user/01-profile." . $request->profile->extension();
                if (isset($user->files["profile"])) {
                    Storage::delete($user->files["profile"]);
                }
                
                $file = Image::make($request->file("profile"))
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
            
                if ($request->hasFile("banner")) {
                    $filepath = "users/$user->id_user/02-banner." . $request->banner->extension();
                    if (isset($user->files["banner"])) {
                        Storage::delete($user->files["banner"]);
                    }
                    
                    $file = Image::make($request->file("banner"))
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

                $input->prices = Price::stringify($input->prices);
                if (isset($input->teampro_name)) {
                    $input->teampro = Teampro::stringify($input->teampro_name);
                }
            
                if ($request->hasFile("teampro_logo")) {
                    $filepath = "users/$user->id_user/02-teampro." . $request->teampro_logo->extension();
                    if (isset($user->files["teampro"])) {
                        Storage::delete($user->files["teampro"]);
                    }
                    
                    $file = Image::make($request->file("teampro_logo"))
                            ->resize(40, 56, function($constrait){
                                $constrait->aspectRatio();
                                $constrait->upsize();
                            });
    
                    Storage::put($filepath, (string) $file->encode());
                }
            }

            unset($user->files);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with("status", [
                "code" => 200,
                "message" => "Perfil actualizado correctamente.",
            ]);
        }

        /**
         * * Update an User Hours.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug User slug
         * @return \Illuminate\Http\Response
         */
        public function hours (Request $request, $slug) {
            $user = User::bySlug($slug)->first();

            $input = (object) $request->all();

            $user->and(["days"]);

            $input->days = Day::stringify($input->days);

            unset($user->files);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with("status", [
                "code" => 200,
                "message" => "Horario actualizado correctamente.",
            ]);
        }

        /**
         * * Send the Coach request form.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function apply (Request $request) {
            $input = (object) $request->all();
            
            $validator = Validator::make((array) $input, User::$validation["apply"]["rules"], User::$validation["apply"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            new Mail([ "id_mail" => 7, ], [
                'email_to' => config("mail.from.address"),
                'email_from' => $input->email,
                'details' => $input->details,
                'name' => $input->name,
            ]);
            
            return redirect("/")->with("status", [
                "code" => 200,
                "message" => "Solicitud enviada exitosamente.",
            ]);
        }

        /**
         * * Updates the User credentials.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function credentials (Request $request) {
            $input = (object) $request->all();

            $user = Auth::user();

            $input->disable_califications = isset($input->disable_califications) ? 1 : 0;

            if ($user->id_role == 1) {
                $user->and(["credentials"]);
                
                $methods = collect();
    
                $methods->push([
                    "id_method" => 1,
                    "access_token" => $user->credentials->mercadopago->access_token,
                ]);
    
                if (isset($input->pp_access_token)) {
                    $methods->push([
                        "id_method" => 2,
                        "access_token" => $input->pp_access_token,
                    ]);
                }
    
                $input->credentials = Method::stringify($methods->toArray());
    
                unset($user->credentials);
            }

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with("status", [
                "code" => 200,
                "message" => "Datos actualizados exitosamente.",
            ]);
        }
    }