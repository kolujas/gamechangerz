<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Ability extends Model {
        use HasFactory;

        static $options = [[
            'id_ability' => 1,
            'name' => 'Paciencia',
            'description' => '',
            'slug' => 'paciencia',
            'stars' => null,
        ], [
            'id_ability' => 2,
            'name' => 'Conexión',
            'description' => '',
            'slug' => 'conexion',
            'stars' => null,
        ], [
            'id_ability' => 3,
            'name' => 'Conexión',
            'description' => '',
            'slug' => 'conexion',
            'stars' => null,
        ], [
            'id_ability' => 4,
            'name' => 'Puntualidad',
            'description' => '',
            'slug' => 'puntualidad',
            'stars' => null,
        ], [
            'id_ability' => 5,
            'name' => 'Precisión',
            'description' => '<span class="color-four">Derriba</span> a tus enemigos desde lejos practicando con el AWP.',
            'image' => 'games/counter-strike-go/abilities/1/01-precision.png',
            'background' => 'games/counter-strike-go/abilities/1/02-background.png',
            'icon' => 'components.svg.PunteriaSVG',
            'difficulty' => 3,
            'slug' => 'precision',
            'stars' => null,
        ], [
            'id_ability' => 6,
            'name' => 'Punteria',
            'description' => '<span class="color-four">Elimina</span> al equipo contrario controlando el recoll del rifle.',
            'image' => 'games/counter-strike-go/abilities/2/01-punteria.png',
            'background' => 'games/counter-strike-go/abilities/2/02-background.png',
            'icon' => 'components.svg.PunteriaSVG',
            'difficulty' => 1,
            'slug' => 'punteria',
            'stars' => null,
        ]];

        /**
         * * Check if a Ability exists.
         * @param int $id_ability Ability primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_ability) {
            $found = false;
            foreach (Ability::$options as $ability) {
                $ability = (object) $ability;
                if ($ability->id_ability === $id_ability) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Ability.
         * @param int $id_ability Ability primary key. 
         * @return object
         */
        static public function findOptions ($id_ability) {
            foreach (Ability::$options as $ability) {
                $ability = (object) $ability;
                if ($ability->id_ability === $id_ability) {
                    $abilityFound = $ability;
                }
            }
            return $abilityFound;
        }

        /**
         * * Parse an Abilities array.
         * @param array $abilitiesToParse Example: "[{\"id_ability\":1,\"stars\":3.5}]"
         * @return array
         */
        static public function parse ($abilitiesToParse) {
            $abilities = collect([]);
            foreach ($abilitiesToParse as $ability) {
                $ability = (object) $ability;
                if (Ability::hasOptions($ability->id_ability)) {
                    $abilityFound = Ability::findOptions($ability->id_ability);
                    $abilityFound->stars = (isset($ability->stars) ? $ability->stars : $abilityFound->stars);
                    $abilities->push($abilityFound);
                }
            }
            return $abilities;
        }
    }