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
                'abilities' => [],
            ], [
                'id_game' => 2,
                'name' => 'League of Legends',
                'alias' => 'LOL',
                'folder' => 'games/league-of-legends',
                'slug' => 'league-of-legends',
                'abilities' => [],
            ], [
                'id_game' => 3,
                'name' => 'Apex Legends',
                'alias' => 'APEX',
                'folder' => 'games/apex-legends',
                'slug' => 'apex-legends',
                'abilities' => [],
            ], [
                'id_game' => 4,
                'name' => 'Overwatch',
                'alias' => 'OVERWATCH',
                'folder' => 'games/overwatch',
                'slug' => 'overwatch',
                'abilities' => [],
        ]];

        /**
         * * Check if a Game exists.
         * @param int $id_game Game primary key. 
         * @return boolean
         */
        static public function has ($id_game) {
            $found = false;
            foreach ($this->options as $game) {
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
        static public function find ($id_game) {
            foreach ($this->options as $game) {
                if ($game->id_game === $id_game) {
                    $gameFound = $game;
                }
            }
            $gameFound->abilities = Ability::parse($gameFound->abilities);
            $files = Folder::getFiles($gameFound->folder);
            $gameFound->files = collect([]);
            foreach ($files as $file) {
                dd($file);
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
                if ($this->has($game->id_game)) {
                    $games->push($this->find($game->id_game));
                }
            }
            return $games;
        }
    }