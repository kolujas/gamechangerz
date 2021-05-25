<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Ability extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_ability';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_ability', 'name', 'description', 'slug', 'stars', 'image', 'background', 'icon', 'difficulty', 'id_game',
        ];

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
            'icon' => 'PunteriaSVG',
            'difficulty' => 3,
            'slug' => 'precision',
            'stars' => null,
            'id_game' => 1,
        ], [
            'id_ability' => 6,
            'name' => 'Punteria',
            'description' => '<span class="color-four">Elimina</span> al equipo contrario controlando el recoil del rifle.',
            'image' => 'games/counter-strike-go/abilities/2/01-punteria.png',
            'background' => 'games/counter-strike-go/abilities/2/02-background.png',
            'icon' => 'PunteriaSVG',
            'difficulty' => 1,
            'slug' => 'punteria',
            'stars' => null,
            'id_game' => 1,
        ]];

        /**
         * * Returns a Ability.
         * @param string $id_ability
         * @return Ability
         */
        static public function one ($id_ability = '') {
            foreach (Ability::$options as $ability) {
                $ability = new Ability($ability);
                if ($ability->id_ability === $id_ability) {
                    return $ability;
                }
            }
        }

        /**
         * * Check if a Ability exists.
         * @param string $id_ability 
         * @return boolean
         */
        static public function has ($id_ability) {
            $found = false;
            foreach (Ability::$options as $game) {
                $game = new Ability($game);
                if ($game->id_ability === $id_ability) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find & returns a Ability.
         * @param string $id_ability
         * @return Ability
         * @throws
         */
        static public function find ($id_ability = '') {
            if (!Ability::has($id_ability)) {
                throw (object)[
                    'code' => 404,
                    'message' => "Ability with id = \"$id_ability\" does not exist",
                ];
            }
            return Ability::one($id_ability);
        }

        /**
         * * Parse an Abilities array.
         * @param array $abilitiesToParse Example: "[{\"id_ability\":1,\"stars\":3.5}]"
         * @return Ability[]
         * @throws
         */
        static public function parse ($abilitiesToParse = []) {
            $abilities = collect([]);
            foreach ($abilitiesToParse as $data) {
                if (!Ability::has($data->id_ability)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Ability with id = \"$data->id_ability\" does not exist",
                    ];
                }
                $ability = Ability::one($data->id_ability);
                $ability->stars = (isset($data->stars) ? $data->stars : $ability->stars);
                $abilities->push($ability);
            }
            return $abilities;
        }

        static public function stringify ($abilitiesToParse = []) {
            $abilities = [];
            foreach ($abilitiesToParse as $id_ability) {
                $abilities[] = [
                    "id_ability" => $id_ability,
                ];
            }
            return json_encode($abilities);
        }
    }