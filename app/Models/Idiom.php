<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Idiom extends Model {
        use HasFactory;

        /** @var array Idiom options */
        static $options = [[
            'id_idiom' => 1,
            'name' => 'Español',
            'svg' => 'components.svg.ESPSVG',
            'slug' => 'espanol',
        ], [
            'id_idiom' => 2,
            'name' => 'Inglés',
            'svg' => 'components.svg.USASVG',
            'slug' => 'ingles',
        ], [
            'id_idiom' => 3,
            'name' => 'Italiano',
            'svg' => 'components.svg.ITASVG',
            'slug' => 'italiano',
        ], [
            'id_idiom' => 4,
            'name' => 'Portugués',
            'svg' => 'components.svg.BRASVG',
            'slug' => 'portugues',
        ]];

        /**
         * * Check if a Idiom exists.
         * @param int $id_idiom Idiom primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_idiom) {
            $found = false;
            foreach (Idiom::$options as $idiom) {
                $idiom = (object) $idiom;
                if ($idiom->id_idiom === $id_idiom) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Idiom.
         * @param int $id_idiom Idiom primary key. 
         * @return object
         */
        static public function findOptions ($id_idiom) {
            foreach (Idiom::$options as $idiom) {
                $idiom = (object) $idiom;
                if ($idiom->id_idiom === $id_idiom) {
                    $idiomFound = $idiom;
                }
            }
            return $idiomFound;
        }

        /**
         * * Parse a Idioms array.
         * @param array $idiomsToParse Example: "[{\"id_idiom\":1}]"
         * @return array
         */
        static public function parse ($idiomsToParse) {
            $idioms = collect([]);
            foreach ($idiomsToParse as $idiom) {
                if (Idiom::hasOptions($idiom->id_idiom)) {
                    $idioms->push(Idiom::findOptions($idiom->id_idiom));
                }
            }
            return $idioms;
        }
    }