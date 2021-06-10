<?php
    namespace App\Http\Controllers;

    use App\Models\Language;
    use App\Models\User;
    use Illuminate\Http\Request;

    class LanguageController extends Controller {
        public function user (Request $request, $slug) {
            $user = User::where('slug', '=', $slug)->get()[0];

            $input = (object) $request->all();

            $languages = [];
            if (isset($input->languages)) {
                foreach ($input->languages as $language) {
                    if (Language::has($language)) {
                        $language = Language::one($language);
                        $languages[] = (object) [
                            "id_language" => $language->id_language,
                        ];
                    }
                }
            }

            $input->languages = json_encode($languages);

            $user->update((array) $input);
            
            return redirect("/users/$user->slug/profile")->with('status', [
                'code' => 200,
                'message' => 'Idiomas actualizados correctamente.',
            ]);
        }
    }