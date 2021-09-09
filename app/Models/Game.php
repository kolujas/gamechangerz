<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Game extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_game';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'active', 'alias', 'colors', 'folder', 'name', 'slug', 'stars',
        ];

        /**
         * * Set the Game info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'abilities':
                            $this->abilities();
                            break;
                        case 'colors':
                            $this->colors();
                            break;
                        case 'files':
                            $this->files();
                            break;
                        case 'stars':
                            $this->stars();
                            break;
                        case 'users':
                            $this->users();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case 'abilities':
                        $this->abilities($column[1]);
                        break;
                    case 'stars':
                        $this->stars($column[1]);
                        break;
                }
            }
        }

        /**
         * * Set the Game Abilities.
         * @param string|false $abilities
         */
        public function abilities ($abilities = false) {
            if ($abilities) {
                $this->abilities = Ability::parse($abilities);
            }
            if (!$abilities) {
                $this->abilities = Ability::allFromGame($this->id_game);
            }

            foreach ($this->abilities as $ability) {
                $ability->and(['files']);
            }
        }

        /**
         * * Set the Game colors.
         */
        public function colors () {
            $this->colors = json_decode($this->colors);
        }

        /**
         * * Set the Game Files.
         */
        public function files () {
            $this->files = collect();
            $files = Folder::getFiles($this->folder, false);

            foreach ($files as $file) {
                $fileExplode = explode(".", $file);
                $fileExplode = explode("/", $fileExplode[0]);
                $fileExplode = explode("\\", end($fileExplode));
                $fileExplode = explode("-", end($fileExplode));
                $this->files[end($fileExplode)] = $file;
            }
        }

        /**
         * * Set the Game stars.
         * @param int $stars
         */
        public function stars (int $stars = 0) {
            $this->stars = $stars;
        }

        /**
         * * Set the Game Users.
         */
        public function users () {
            $this->users = collect();
            $users = User::allByGame($this->id_game, 1);

            foreach ($users as $user) {
                if (count($this->users) < 6) {
                    $user->and(['games', 'languages', 'prices', 'files', 'teampro']);
                    
                    foreach ($user->games as $game) {
                        $game->and(['files']);
                    }

                    $this->users->push($user);
                }
            }
        }

        /**
         * * Parse a Games array.
         * @param string [$games] Example: "[{\"id_game\":1,\"stars\":3.5}]"
         * @return Game[]
         */
        static public function parse (string $games = '') {
            $collection = collect();

            foreach (json_decode($games) as $data) {
                $game = Game::find($data->id_game);

                if (isset($data->abilities)) {
                    $game->and([['abilities', json_encode($data->abilities)]]);
                }

                $game->stars = (isset($data->stars) ? $data->stars : 0);

                $collection->push($game);
            }

            return $collection;
        }

        /**
         * * Stringify a Games array.
         * @param array [$games] Example: [["id_game"=>1,"abilities"=>[["id_ability"=>1]],"stars"=>3.5]]
         * @return string
         */
        static public function stringify (array $games = []) {
            $collection = collect();
            
            foreach ($games as $data) {
                $collection->push([
                    "id_game" => $data['id_game'],
                    "abilities" => json_decode(Ability::stringify($data['abilities']->toArray())),
                    "stars" => (isset($data['stars']) ? $data['stars'] : 0),
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Get a Game by the slug.
         * @param string $slug
         * @return Game
         */
        static public function findBySlug (string $slug = '') {
            $game = Game::where('slug', '=', $slug)->first();

            return $game;
        }

        /**
         * * Requilify the Games by the Abilities.
         * @param int $id_user
         * @param string [$games] Example: "[{\"id_game\":1}]"
         * @return JSON
         */
        static public function requilify (int $id_user, string $games = '') {
            $user = User::find($id_user);
            $user->and(['reviews']);

            $collection = collect();

            foreach (json_decode($games) as $data) {
                $game = Game::find($data->id_game);

                if (isset($data->abilities)) {
                    $game->abilities = json_decode(Ability::requilify($id_user, $data->abilities));
                }

                $stars = 0;
                $quantity = 0;
                foreach ($game->abilities as $ability) {
                    $stars += $ability->stars;
                    $quantity++;
                }

                $game->stars = ($stars ? $stars / $quantity : 0);

                $collection->push([
                    "id_game" => $game->id_game,
                    "abilities" => $game->abilities,
                    "stars" => $game->stars,
                ]);
            }

            return $collection->toJson();
        }
    }