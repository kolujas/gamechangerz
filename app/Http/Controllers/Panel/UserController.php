<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Game;
    use App\Models\Language;
    use App\Models\Price;
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
         * @param Request $request
         * @param string $section
         * @param string $action
         * @return [type]
         */
        static public function call (Request $request, string $section, string $action) {
            switch ($section) {
                case "teachers":
                    switch ($action) {
                        case "create":
                            return UserController::doCreateTeacher($request);
                        case "delete":
                            dd("delete");
                            return UserController::doDeleteTeacher($request);
                        case "update":
                            return UserController::doUpdateTeacher($request);
                    }
                case "users":
                    switch ($action) {
                        case "create":
                            return UserController::doCreateUser($request);
                        case "delete":
                            return UserController::doDeleteUser($request);
                        case "update":
                            return UserController::doUpdateUser($request);
                    }
                default:
                    dd("Call to a user section \"$section\" not found");
            }
        }

        /**
         * * Creates an User with id_role = 1.
         * @param Request $request
         * @return [type]
         */
        static public function doCreateTeacher (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), User::$validation["teacher"]["panel"]["create"]["rules"], User::$validation["teacher"]["panel"]["create"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->days = Day::stringify($input->days);

            $games = collect();
            foreach ($input->abilities as $ability => $on) {
                $ability = Ability::findBySlug($ability);
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

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            $input->id_role = 1;

            if (isset($input->important)) {
                $input->important = 1;
            }

            $input->languages = Language::stringify($languages->toArray());
            
            $input->password = Hash::make($input->password);
            
            $input->prices = Price::stringify($input->prices);

            $input->slug = SlugService::createSlug(User::class, "slug", $input->username);

            $input->status = 2;

            $input->teampro = Teampro::stringify($input->teampro_name);

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

            $filepath = "users/$user->id_user/02-teampro." . $request->teampro_logo->extension();
            
            $file = Image::make($request->file("teampro_logo"))
                    ->resize(40, 56, function($constrait){
                        $constrait->aspectRatio();
                        $constrait->upsize();
                    });

            Storage::put($filepath, (string) $file->encode());

            return redirect("/panel/teachers/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Profesor creado exitosamente.",
            ]);
        }

        /**
         * * Deletes an User with id_role = 1.
         * @param Request $request
         * @return [type]
         */
        static public function doDeleteTeacher (Request $request) {
            $input = (object) $request->all();

            $user = User::findBySlug($request->route()->parameter("slug"));
            $user->and(["files"]);

            $validator = Validator::make($request->all(), User::$validation["teacher"]["panel"]["delete"]["rules"], User::$validation["teacher"]["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if (isset($user->files["profile"])) {
                Storage::delete($user->files["profile"]);
            }

            if (isset($user->files["teampro"])) {
                Storage::delete($user->files["teampro"]);
            }

            $user->delete();

            return redirect("/panel/teachers")->with("status", [
                "code" => 200,
                "message" => "Profesor eliminado exitosamente.",
            ]);
        }

        /**
         * * Updates an User with id_role = 1.
         * @param Request $request
         * @return [type]
         */
        static public function doUpdateTeacher (Request $request) {
            $input = (object) $request->all();

            $user = User::findBySlug($request->route()->parameter("slug"));
            $user->and(["files"]);

            $validator = Validator::make($request->all(), Controller::replaceUnique(User::$validation["teacher"]["panel"]["update"]["rules"], $user->id_user), User::$validation["teacher"]["panel"]["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->days = Day::stringify($input->days);

            $games = collect();
            foreach ($input->abilities as $ability => $on) {
                $ability = Ability::findBySlug($ability);
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

            $languages = collect();
            foreach ($input->languages as $language => $on) {
                $languages->push($language);
            }

            if (isset($input->important)) {
                $input->important = 1;
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

            $input->teampro = Teampro::stringify($input->teampro_name);

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

            return redirect("/panel/teachers/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Profesor actualizado exitosamente.",
            ]);
        }

        /**
         * * Creates an User with id_role = 0.
         * @param Request $request
         * @return [type]
         */
        static public function doCreateUser (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), User::$validation["user"]["panel"]["create"]["rules"], User::$validation["user"]["panel"]["create"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $games = collect();
            foreach ($input->games as $game => $on) {
                $game = Game::findBySlug($game);
                $games->push([
                    "id_game" => $game->id_game,
                    "abilities" => collect(),
                ]);
                foreach (Ability::allFromGame($game->id_game) as $ability) {
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

            $input->languages = Language::stringify($languages->toArray());
            
            $input->password = Hash::make($input->password);

            $input->slug = SlugService::createSlug(User::class, "slug", $input->username);

            $input->status = 2;

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
         * @param Request $request
         * @return [type]
         */
        static public function doDeleteUser (Request $request) {
            $input = (object) $request->all();

            $user = User::findBySlug($request->route()->parameter("slug"));
            $user->and(["files"]);

            $validator = Validator::make($request->all(), User::$validation["user"]["panel"]["delete"]["rules"], User::$validation["user"]["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
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
         * @param Request $request
         * @return [type]
         */
        static public function doUpdateUser (Request $request) {
            $input = (object) $request->all();

            $user = User::findBySlug($request->route()->parameter("slug"));
            $user->and(["files"]);

            $validator = Validator::make($request->all(), Controller::replaceUnique(User::$validation["user"]["panel"]["update"]["rules"], $user->id_user), User::$validation["user"]["panel"]["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $games = collect();
            foreach ($input->games as $game => $on) {
                $game = Game::findBySlug($game);
                $games->push([
                    "id_game" => $game->id_game,
                    "abilities" => collect(),
                ]);
                foreach (Ability::allFromGame($game->id_game) as $ability) {
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

            return redirect("/panel/users/$user->slug")->with("status", [
                "code" => 200,
                "message" => "Usuario actualizado exitosamente.",
            ]);
        }
    }