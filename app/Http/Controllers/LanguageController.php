<?php
    namespace App\Http\Controllers;

    use App\Models\Language;
    use App\Models\User;
    use Illuminate\Http\Request;

    class LanguageController extends Controller {
        /**
         * * Update the User Languages.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug
         * @return \Illuminate\Http\Response
         */
        public function update (Request $request, string $slug) {
            $user = User::findBySlug($slug);

            $input = (object) $request->all();

            $input->languages = Language::stringify($input->languages);

            $user->update((array) $input);
            
            return redirect()->back()->with('status', [
                'code' => 200,
                'message' => 'Idiomas actualizados correctamente.',
            ]);
        }
    }