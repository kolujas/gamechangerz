<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Language extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_language';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_language', 'name', 'icon', 'slug',
        ];

        /** @var array Language options */
        static $options = [[
            'id_language' => 1,
            'name' => 'Español',
            'icon' => 'ESPSVG',
            'slug' => 'espanol',
        ], [
            'id_language' => 2,
            'name' => 'Inglés',
            'icon' => 'USASVG',
            'slug' => 'ingles',
        ], [
            'id_language' => 3,
            'name' => 'Italiano',
            'icon' => 'ITASVG',
            'slug' => 'italiano',
        ], [
            'id_language' => 4,
            'name' => 'Portugués',
            'icon' => 'BRASVG',
            'slug' => 'portugues',
        ]];

        /**
         * * Check if a Language exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Language::$options as $language) {
                $language = new Language($language);
                if ($language->id_language === $field || $language->slug === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Returns a Language.
         * @param string $field
         * @return Language
         */
        static public function one ($field = '') {
            foreach (Language::$options as $language) {
                $language = new Language($language);
                if ($language->id_language === $field || $language->slug === $field) {
                    return $language;
                }
            }
        }

        /**
         * * Parse a Languages array.
         * @param array $languagesToParse Example: "[{\"id_language\":1}]"
         * @return Language[]
         * @throws
         */
        static public function parse ($languagesToParse = []) {
            $languages = collect([]);
            foreach ($languagesToParse as $data) {
                if (!Language::has($data->id_language)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Language with id = \"$data->id_language\" does not exist",
                    ];
                }
                $language = Language::one($data->id_language);
                $languages->push($language);
            }
            return $languages;
        }

        /**
         * * Returns all the Language options.
         * @param array $columns
         * @return Language[]
         */
        static public function all ($columns = []) {
            $languages = collect([]);
            foreach (Language::$options as $language) {
                $language = new Language($language);
                $languages->push($language);
            }
            return $languages;
        }
        
        /** @var array Validation rules & messages. */
        static $validation = [
            'user' => [
                'rules' => [
                    'languages' => 'required',
                ], 'messages' => [
                    'es' => [
                        'languages.required' => 'Al menos 1 idioma es obligatorio.',
        ]]]];
    }