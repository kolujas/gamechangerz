<?php
    namespace App\Http\Controllers;

    use App\Models\Language;
    use App\Models\User;
    use Illuminate\Http\Request;

    class LanguageController extends Controller {
        /**
         * * Update the User Languages.
         * @param Request $request
         * @param string $slug
         * @return [type]
         */
        public function update (Request $request, string $slug) {
            $user = User::findBySlug($slug);

            $input = (object) $request->all();

            $input->languages = Language::stringify($input->languages);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with('status', [
                'code' => 200,
                'message' => 'Idiomas actualizados correctamente.',
            ]);
        }
    }