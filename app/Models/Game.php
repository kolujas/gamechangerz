<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Game extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_game';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_game', 'name', 'alias', 'folder', 'slug', 'abilities', 'colors', 'active',
        ];

        /** @var array Game options */
        static $options = [[
            'id_game' => 1,
            'name' => 'Counter Strike: GO',
            'alias' => 'CSGO',
            'folder' => 'games/counter-strike-go',
            'slug' => 'counter-strike-go',
            'abilities' => [['id_ability' => 5],['id_ability' => 6]],
            'colors' => ['#FBF19C', '#ED6744'],
            'active' => true,
        ], [
            'id_game' => 2,
            'name' => 'League of Legends',
            'alias' => 'LOL',
            'folder' => 'games/league-of-legends',
            'slug' => 'league-of-legends',
            'abilities' => [],
            'colors' => ['#00FFFF', '#0000FF'],
            'active' => false,
        ], [
            'id_game' => 3,
            'name' => 'Apex Legends',
            'alias' => 'APEX',
            'folder' => 'games/apex-legends',
            'slug' => 'apex-legends',
            'abilities' => [],
            'colors' => ['#FF0000', '#800000'],
            'active' => false,
        ], [
            'id_game' => 4,
            'name' => 'Overwatch',
            'alias' => 'OVERWATCH',
            'folder' => 'games/overwatch',
            'slug' => 'overwatch',
            'abilities' => [],
            'colors' => ['#FFFF00', '#FFD700'],
            'active' => false,
        ]];

        /**
         * * Get the Game options.
         * @return object[]
         */
        static public function getOptions () {
            $games = collect([]);
            foreach (Game::$options as $option) {
                $games->push((object) $option);
            }
            return $games;
        }

       /**
        * * Search a Game.
        * @param mixed $slug Game slug.
        * @return object
        */
        static public function search ($slug) {
            foreach (Game::$options as $option) {
                $option = (object) $option;
                if ($option->slug === $slug) {
                    return $option;
                }
            }
        }

        /**
         * * Get the Game info. 
         * @param array $columns
         * @throws
         */
        public function and ($columns = []) {
            try {
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'abilities':
                            $this->abilities();
                            break;
                        case 'files':
                            $this->files();
                            break;
                        case 'users':
                            $this->users();
                            break;
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the Game Abilities.
         * @throws
         */
        public function abilities () {
            try {
                $abilities = $this->abilities;
                $this->abilities = collect([]);
                foreach ($abilities as $data) {
                    $this->abilities->push(Ability::find($data['id_ability']));
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the Game Files.
         * @return array
         */
        public function files () {
            try {
                $this->files = collect([]);
                $files = Folder::getFiles($this->folder, false);
                if (!count($files)) {
                    $this->files = false;
                }
                foreach ($files as $file) {
                    $fileExplode = explode(".", $file);
                    $fileExplode = explode("\\", $fileExplode[0]);
                    $fileExplode = explode("-", $fileExplode[1]);
                    $this->files[$fileExplode[1]] = $file;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the Game Users.
         * @throws
         */
        public function users () {
            try {
                $this->users = collect();
                $users = User::findByGame($this->id_game, 1);
                foreach ($users as $user) {
                    if (count($this->users) <= 6) {
                        $this->users->push($user);
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Parse a Game Abilities array.
         * @param int $id_game
         * @param array $abilitiesToParse Example: "[{\"id_ability\":1,\"stars\":3.5}]"
         * @return array
         */
        // public function abilities ($id_game, $abilitiesToParse) {
        //     $abilities = collect([]);
        //     $game = (object) Game::findOptions($id_game);
        //     foreach ($game->abilities as $ability) {
        //         $ability = (object) $ability;
        //         $found = false;
        //         foreach ($abilitiesToParse as $abilityToParse) {
        //             $abilityToParse = (object) $abilityToParse;
        //             if ($ability->id_ability === $abilityToParse->id_ability) {
        //                 $abilities->push($abilityToParse);
        //                 $found = true;
        //             }
        //         }
        //         if (!$found) {
        //             $ability->stars = 0;
        //             $abilities->push($ability);
        //         }
                
        //     }
        //     return $abilities;
        // }

        /**
         * * Returns all the Game options.
         * @param array $columns
         * @return Game[]
         */
        static public function all ($columns = []) {
            $games = collect([]);
            foreach (Game::$options as $game) {
                $game = new Game($game);
                $games->push($game);
            }
            return $games;
        }

        /**
         * * Returns a Game.
         * @param string $field
         * @return Game
         */
        static public function one ($field = '') {
            foreach (Game::$options as $game) {
                $game = new Game($game);
                if ($game->id_game === $field || $game->slug === $field) {
                    return $game;
                }
            }
        }

        /**
         * * Check if a Game exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Game::$options as $game) {
                $game = new Game($game);
                if ($game->id_game === $field || $game->slug === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find & returns a Game.
         * @param string $slug
         * @return Game
         * @throws
         */
        static public function find ($slug = '') {
            if (!Game::has($slug)) {
                throw (object)[
                    'code' => 404,
                    'message' => "Game \"$slug\" does not exist",
                ];
            }
            return Game::one($slug);
        }

        /**
         * * Parse a Games array.
         * @param array $gamesToParse Example: "[{\"id_game\":1,\"abilities\":[{\"id_ability\":1,\"stars\":3.5}]}]"
         * @return Game[]
         * @throws
         */
        static public function parse ($gamesToParse = []) {
            $games = collect([]);
            foreach ($gamesToParse as $data) {
                if (!Game::has($data->id_game)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Game with id = \"$data->id_game\" does not exist",
                    ];
                }
                $game = Game::one($data->id_game);
                $games->push($game);
            }
            return $games;
        }

        /**
         * * Find & returns a Game.
         * @param mixed $abilitiesToFor
         * @return Game
         */
        static public function getByAbility ($abilitiesToFor) {
            foreach (Game::$options as $game) {
                $game = new Game($game);
                $game->and(['abilities']);
                foreach ($game->abilities as $gameAbility) {
                    foreach ($abilitiesToFor as $ability) {
                        if ($ability->id_ability === $gameAbility->id_ability) {
                            return $game;
                        }
                    }
                }
            }
        }
    }