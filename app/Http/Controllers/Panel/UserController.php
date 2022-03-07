<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\Mail;
    use App\Models\Method;
    use App\Models\Price;
    use App\Models\Review;
    use App\Models\Teampro;
    use App\Models\User;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use Intervention\Image\ImageManagerStatic as Image;
    use Storage;

    class UserController extends Controller {
        /**
         * * Call the correct function.
         * @param  \Illuminate\Http\Request  $request
         * @param string $section
         * @param string $action
         * @return \Illuminate\Http\Response
         */
        static public function call (Request $request, string $section, string $action) {
            switch ($section) {
                case "coaches":
                    switch ($action) {
                        case "create":
                            return UserController::doCreateCoach($request);
                        case "delete":
                            return UserController::doDeleteCoach($request);
                        case "update":
                            return UserController::doUpdateCoach($request);
                        default:
                            dd("Call to an undefined action \"$action\"");
                    }
                case "users":
                    switch ($action) {
                        case "create":
                            return UserController::doCreateUser($request);
                        case "delete":
                            return UserController::doDeleteUser($request);
                        case "update":
                            return UserController::doUpdateUser($request);
                        default:
                            dd("Call to an undefined action \"$action\"");
                    }
                default:
                    dd("Call to an undefined section \"$section\"");
            }
        }

        /**
         * * Creates an User with id_role = 1.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doCreateCoach (Request $request) {
            $input = (object) $request->all();

            if (!isset($input->id_status)) {
                $input->id_status = "1";
            }

            $validator = Validator::make((array) $input, User::$validation["coach"]["panel"]["create"]["rules"], User::$validation["coach"]["panel"]["create"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->days = Day::stringify($input->days);

            $games = collect();
            foreach ($input->abilities as $ability => $on) {
                $ability = Ability::bySlug($ability)->first();
                if (count($games)) {
                    foreach ($games as $game) {
                        if ($game["id_game"] === $ability->id_game) {
                            $game["abilities"]->push([
                                "id_ability" => $ability->id_ability,
                            ]);
                            continue 2;
                        }
                    }
                }
                $games->push([
                    "id_game" => $ability->id_game,
                    "abilities" => collect(),
                ]);
                $games[count($games) - 1]["abilities"]->push([
                    "id_ability" => $ability->id_ability,
                ]);
            }

            $input->games = Game::stringify($games->toArray());

            $input->id_role = 1;

            $input->id_status = intval($input->id_status);

            if (isset($input->important)) {
                $input->important = 1;
            }

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            $input->languages = Language::stringify($languages->toArray());
            
            $input->password = Hash::make($input->password);
            
            $input->prices = Price::stringify($input->prices);

            $input->slug = SlugService::createSlug(User::class, "slug", $input->username);

            if (isset($input->teampro_name)) {
                $input->teampro = Teampro::stringify($input->teampro_name);
            }

            $user = User::create((array) $input);
            
            $user->update([
                "folder" => "users/$user->id_user",
            ]);

            $filepath = "users/$user->id_user/01-profile." . $request->profile->extension();
            
            $file = Image::make($request->file("profile"))
                    ->resize(350, 400, function($constrait){
                        $constrait->aspectRatio();
                        $constrait->upsize();
                    });

            Storage::put($filepath, (string) $file->encode());

            if ($request->hasFile("teampro_logo")) {
                $filepath = "users/$user->id_user/02-teampro." . $request->teampro_logo->extension();
                
                $file = Image::make($request->file("teampro_logo"))
                        ->resize(40, 56, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });

                Storage::put($filepath, (string) $file->encode());
            }

            new Mail([ "id_mail" => 9, ], [
                "email_to" => $input->email,
                "link" => "https://auth.mercadopago.com.ar/authorization?client_id=" . config("services.mercadopago.app_id") . "&response_type=code&platform_id=mp&state=$user->id_user&redirect_uri=https://gamechangerz.gg/mercadopago/authorization",
            ]);

            return redirect("/panel/coaches/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Profesor creado exitosamente.",
            ]);
        }

        /**
         * * Deletes an User with id_role = 1.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doDeleteCoach (Request $request) {
            $input = (object) $request->all();

            $user = User::bySlug($request->route()->parameter("slug"))->first();
            $user->files = $user->files;
            $user->and(["posts"]);

            $validator = Validator::make($request->all(), User::$validation["coach"]["panel"]["delete"]["rules"], User::$validation["coach"]["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            foreach ($user->posts as $post) {
                Storage::delete($post->image);

                $post->delete();
            }

            $requilify = collect();

            $lessons = Lesson::byUser($user->id_user)->get();
            foreach ($lessons as $lesson) {
                $lesson->and(["reviews", "assignments"]);
                if (count($lesson->reviews)) {
                    foreach ($lesson->reviews as $review) {
                        $review->and(["users"]);
                        foreach ($review->users as $reviewUser) {
                            if ($reviewUser->id_user != $user->id_user) {
                                $requilify->push($reviewUser);
                            }
                        }
                        $review->delete();
                    }
                }
                if (count($lesson->assignments)) {
                    foreach ($lesson->assignments as $assignment) {
                        if ($assignment->presentation) {
                            $assignment->presentation->delete();
                        }
                        $assignment->delete();
                    }
                }
                if ($lesson->chat) {
                    $lesson->chat->delete();
                }
                $lesson->delete();
            }

            foreach ($requilify as $requilifyUser) {
                User::requilify($requilifyUser->id_user);
            }

            if (isset($user->files["profile"])) {
                Storage::delete($user->files["profile"]);
            }

            if (isset($user->files["teampro"])) {
                Storage::delete($user->files["teampro"]);
            }

            $user->delete();

            return redirect("/panel/coaches")->with("status", [
                "code" => 200,
                "message" => "Profesor eliminado exitosamente.",
            ]);
        }

        /**
         * * Updates an User with id_role = 1.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doUpdateCoach (Request $request) {
            $input = (object) $request->all();

            $user = User::bySlug($request->route()->parameter("slug"))->first();
            $user->files = $user->files;

            $validator = Validator::make($request->all(), Controller::replaceUnique(User::$validation["coach"]["panel"]["update"]["rules"], $user->id_user), User::$validation["coach"]["panel"]["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->days = Day::stringify($input->days);

            $games = collect();
            foreach ($input->abilities as $ability => $on) {
                $ability = Ability::bySlug($ability)->first();
                if (count($games)) {
                    foreach ($games as $game) {
                        if ($game["id_game"] === $ability->id_game) {
                            $game["abilities"]->push([
                                "id_ability" => $ability->id_ability,
                            ]);
                            continue 2;
                        }
                    }
                }
                $games->push([
                    "id_game" => $ability->id_game,
                    "abilities" => collect(),
                ]);
                $games[count($games) - 1]["abilities"]->push([
                    "id_ability" => $ability->id_ability,
                ]);
            }

            $input->games = Game::stringify($games->toArray());

            if (isset($input->important)) {
                $input->important = 1;
            }

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            $input->languages = Language::stringify($languages->toArray());
            
            if (isset($input->password)) {
                $input->password = Hash::make($input->password);
            }
            
            if (!isset($input->password)) {
                $input->password = $user->password;
            }
            
            $input->prices = Price::stringify($input->prices);

            if ($input->username !== $user->username) {
                $input->slug = SlugService::createSlug(User::class, "slug", $input->username);
            }

            if (isset($input->teampro_name)) {
                $input->teampro = Teampro::stringify($input->teampro_name);
            }
            
            $input->id_status = intval($input->id_status);

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

            unset($user->files);
            
            $user->update((array) $input);
            User::requilify($user->id_user);

            return redirect("/panel/coaches/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Profesor actualizado exitosamente.",
            ]);
        }

        /**
         * * Creates an User with id_role = 0.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doCreateUser (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), User::$validation["user"]["panel"]["create"]["rules"], User::$validation["user"]["panel"]["create"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $games = collect();
            foreach ($input->games as $game => $on) {
                $game = Game::bySlug($game)->first();
                $games->push([
                    "id_game" => $game->id_game,
                    "abilities" => collect(),
                ]);
                foreach (Ability::byGame($game->id_game)->get() as $ability) {
                    $games[count($games) - 1]["abilities"]->push([
                        "id_ability" => $ability->id_ability,
                    ]);
                }
            }

            $input->games = Game::stringify($games->toArray());

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            $input->id_role = 0;
            
            $input->id_status = intval($input->id_status);

            $input->languages = Language::stringify($languages->toArray());
            
            $input->password = Hash::make($input->password);

            $input->slug = SlugService::createSlug(User::class, "slug", $input->username);

            $user = User::create((array) $input);
            
            $user->update([
                "folder" => "users/$user->id_user",
            ]);

            if ($request->hasFile("profile")) {
                $filepath = "users/$user->id_user/01-profile." . $request->profile->extension();
                
                $file = Image::make($request->file("profile"))
                        ->resize(350, 400, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });
    
                Storage::put($filepath, (string) $file->encode());
            }

            if ($request->hasFile("banner")) {
                $filepath = "users/$user->id_user/02-banner." . $request->banner->extension();
                
                $file = Image::make($request->file("banner"))
                        ->resize(1349, 395, function($constrait){
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });

                Storage::put($filepath, (string) $file->encode());
            }

            return redirect("/panel/users/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Usuario creado exitosamente.",
            ]);
        }

        /**
         * * Deletes an User with id_role = 0.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doDeleteUser (Request $request) {
            $input = (object) $request->all();

            $user = User::bySlug($request->route()->parameter("slug"))->first();
            $user->files = $user->files;

            $validator = Validator::make($request->all(), User::$validation["user"]["panel"]["delete"]["rules"], User::$validation["user"]["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            foreach ($user->friends as $friend) {
                $friend->delete();
            }

            $requilify = collect();

            $lessons = Lesson::byUser($user->id_user)->get();
            foreach ($lessons as $lesson) {
                $lesson->and(["reviews", "assignments"]);
                if (count($lesson->reviews)) {
                    foreach ($lesson->reviews as $review) {
                        $review->and(["users"]);
                        foreach ($review->users as $reviewUser) {
                            if ($reviewUser->id_user != $user->id_user) {
                                $requilify->push($reviewUser);
                            }
                        }
                        $review->delete();
                    }
                }
                if (count($lesson->assignments)) {
                    foreach ($lesson->assignments as $assignment) {
                        if ($assignment->presentation) {
                            $assignment->presentation->delete();
                        }
                        $assignment->delete();
                    }
                }
                if ($lesson->chat) {
                    $lesson->chat->delete();
                }
                $lesson->delete();
            }

            foreach ($requilify as $requilifyUser) {
                User::requilify($requilifyUser->id_user);
            }

            if (isset($user->files["profile"])) {
                Storage::delete($user->files["profile"]);
            }

            if (isset($user->files["banner"])) {
                Storage::delete($user->files["banner"]);
            }

            $user->delete();

            return redirect("/panel/users")->with("status", [
                "code" => 200,
                "message" => "Usuario eliminado exitosamente.",
            ]);
        }

        /**
         * * Updates an User with id_role = 0.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doUpdateUser (Request $request) {
            $input = (object) $request->all();

            $user = User::bySlug($request->route()->parameter("slug"))->first();
            $user->files = $user->files;

            $validator = Validator::make($request->all(), Controller::replaceUnique(User::$validation["user"]["panel"]["update"]["rules"], $user->id_user), User::$validation["user"]["panel"]["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $games = collect();
            foreach ($input->games as $game => $on) {
                $game = Game::bySlug($game)->first();
                $games->push([
                    "id_game" => $game->id_game,
                    "abilities" => collect(),
                ]);
                foreach (Ability::byGame($game->id_game)->get() as $ability) {
                    $games[count($games) - 1]["abilities"]->push([
                        "id_ability" => $ability->id_ability,
                    ]);
                }
            }

            $input->games = Game::stringify($games->toArray());

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            $input->languages = Language::stringify($languages->toArray());
            
            $input->id_status = intval($input->id_status);
            
            if (isset($input->password)) {
                $input->password = Hash::make($input->password);
            }
            
            if (!isset($input->password)) {
                $input->password = $user->password;
            }

            if ($input->username !== $user->username) {
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

            unset($user->files);
            
            $user->update((array) $input);
            User::requilify($user->id_user);

            return redirect("/panel/users/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Usuario actualizado exitosamente.",
            ]);
        }
    }