<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Game extends Model {
        use HasFactory;

        /** @var array Game options */
        static $options = [[
            'id_game' => 1,
            'name' => 'Counter Strike: GO',
            'alias' => 'CSGO',
            'folder' => 'games/counter-strike-go',
            'slug' => 'counter-strike-go',
            'abilities' => [['id_ability' => 5],['id_ability' => 6]],
            'colors' => ['#ED6744', '#FBF19C'],
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
         * * Check if a Game exists.
         * @param int $id_game Game primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_game) {
            $found = false;
            foreach (Game::$options as $game) {
                $game = (object) $game;
                if ($game->id_game === $id_game) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Game.
         * @param int $id_game Game primary key. 
         * @return object
         */
        static public function findOptions ($id_game) {
            foreach (Game::$options as $game) {
                $game = (object) $game;
                if ($game->id_game === $id_game) {
                    $gameFound = $game;
                }
            }
            return $gameFound;
        }

        /**
         * * Parse a Games array.
         * @param array $gamesToParse Example: "[{\"id_game\":1,\"abilities\":[{\"id_ability\":1,\"stars\":3.5}]}]"
         * @return array
         */
        static public function parse ($gamesToParse) {
            $games = collect([]);
            foreach ($gamesToParse as $game) {
                $game = (object) $game;
                if (Game::hasOptions($game->id_game)) {
                    $gameFound = Game::findOptions($game->id_game);
                    $gameFound->abilities = Ability::parse(Game::parseAbilities($game->id_game, $game->abilities));
                    $files = Folder::getFiles($gameFound->folder);
                    $gameFound->files = collect([]);
                    foreach ($files as $file) {
                        dd($file);
                    }
                    $games->push($gameFound);
                }
            }
            return $games;
        }

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
         * * Parse a Game Abilities array.
         * @param int $id_game
         * @param array $abilitiesToParse Example: "[{\"id_ability\":1,\"stars\":3.5}]"
         * @return array
         */
        static public function parseAbilities ($id_game, $abilitiesToParse) {
            $abilities = collect([]);
            $game = (object) Game::findOptions($id_game);
            foreach ($game->abilities as $ability) {
                $ability = (object) $ability;
                $found = false;
                foreach ($abilitiesToParse as $abilityToParse) {
                    $abilityToParse = (object) $abilityToParse;
                    if ($ability->id_ability === $abilityToParse->id_ability) {
                        $abilities->push($abilityToParse);
                        $found = true;
                    }
                }
                if (!$found) {
                    $ability->stars = 0;
                    $abilities->push($ability);
                }
                
            }
            return $abilities;
        }

        static public function getByAbility ($abilitiesToFor) {
            foreach (Game::$options as $game) {
                $game = (object) $game;
                foreach ($game->abilities as $game_ability) {
                    $game_ability = (object) $game_ability;
                    foreach ($abilitiesToFor as $ability) {
                        $ability = (object) $ability;
                        if ($ability->id_ability === $game_ability->id_ability) {
                            return $game;
                        }
                    }
                }
            }
        }
    }