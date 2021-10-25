<?php
    namespace App\Models;

    use App\Models\Language;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Language extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_language";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "icon",
            "id_language",
            "name",
            "slug",
        ];

        /**
         * * Check if a Language exists.
         * @param string|int $field
         * @return bool
         */
        static public function has ($field = "") {
            foreach (Language::$options as $option) {
                if ($option["id_language"] === $field || $option["slug"] === $field) {
                    return true;
                }
            }

            return false;
        }

        /**
         * * Returns a Language.
         * @param string|int $field
         * @return Language
         */
        static public function option ($field = "") {
            foreach (Language::$options as $option) {
                if ($option["id_language"] === intval($field) || $option["slug"] === $field) {
                    return new Language($option);
                }
            }

            dd("Language \"$field\" not found");
        }

        /**
         * * Returns the Language options.
         * @param array [$languages] Example: [["id_language"=>1]]
         * @param bool [$all=true]
         * @return Language[]
         */
        static public function options (array $languages = [], bool $all = true) {
            $collection = collect();

            foreach (Language::$options as $option) {
                $option = new Language($option);
                $found = false;
                
                foreach ($languages as $data) {
                    if ($option->id_language === $data["id_language"]) {
                        $found = true;
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($option);
                }
            }

            return $collection;
        }

        /**
         * * Parse a Languages array.
         * @param string [$languages] Example: "[{\"id_language\":1}]"
         * @return Language[]
         */
        static public function parse (string $languages = "") {
            $collection = collect();

            foreach (json_decode($languages) as $data) {
                $language = Language::option($data->id_language);

                $collection->push($language);
            }

            return $collection;
        }

        /**
         * * Stringify a Languages array.
         * @param array [$languages] Example: [0=>"espanol"]]
         * @return string
         */
        static public function stringify (array $languages = []) {
            $collection = collect();

            foreach ($languages as $slug) {
                if (Language::has($slug)) {
                    $language = Language::option($slug);

                    $collection->push([
                        "id_language" => $language->id_language,
                    ]);
                }
            }

            return $collection->toJson();
        }
        
        /** @var array Validation rules & messages. */
        static $validation = [
            "user" => [
                "rules" => [
                    "languages" => "required",
                ], "messages" => [
                    "es" => [
                        "languages.required" => "Al menos 1 idioma es obligatorio.",
                    ],
                ],
            ],
        ];

        /**
         * * Language options.
         * @var array
         */
        static $options = [
            [
                "id_language" => 1,
                "name" => "Español",
                "icon" => "ESPSVG",
                "slug" => "espanol",
            ], [
                "id_language" => 2,
                "name" => "Inglés",
                "icon" => "USASVG",
                "slug" => "ingles",
            ], [
                "id_language" => 3,
                "name" => "Italiano",
                "icon" => "ITASVG",
                "slug" => "italiano",
            ], [
                "id_language" => 4,
                "name" => "Portugués",
                "icon" => "BRASVG",
                "slug" => "portugues",
            ],
        ];
    }