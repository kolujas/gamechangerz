<?php
    namespace App\Models;

    use App\Models\Game;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Ability extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_ability";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "description",
            "difficulty",
            "folder",
            "icon",
            "id_ability",
            "id_game",
            "name",
            "slug",
            "stars",
        ];

        /**
         * * Set the Ability info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "game":
                            $this->game();
                            break;
                        case "files":
                            $this->files();
                            break;
                        case "stars":
                            $this->stars();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case "stars":
                        $this->stars($column[1]);
                        break;
                }
            }
        }

        /**
         * * Set the Ability Game.
         */
        public function game () {
            $this->game = Game::find($this->id_game);
        }

        /**
         * * Set the Game Files.
         */
        public function files () {
            $this->game();

            $this->files = collect();
            $files = Folder::getFiles($this->game->folder . "/abilities/$this->id_ability", false);

            foreach ($files as $file) {
                $fileExplode = explode(".", $file);
                $fileExplode = explode("/", $fileExplode[0]);
                $fileExplode = explode("\\", end($fileExplode));
                $fileExplode = explode("-", end($fileExplode));
                $this->files[end($fileExplode)] = preg_replace("~\\\\~", "/", $file);
            }
        }

        /**
         * * Set the Ability stars.
         * @param int $stars
         */
        public function stars (int $stars = 0) {
            $this->stars = $stars;
        }

        /**
         * * Get all the Abilities from a Game.
         * @param int $id_game
         * @return Ability[]
         */
        static public function allFromGame (int $id_game) {
            $abilities = Ability::where("id_game", "=", $id_game)->get();

            return $abilities;
        }

        /**
         * * Returns the Ability options.
         * @param array [$abilities] Example: [["id_ability"=>1,"stars"=>3.5]]
         * @param bool [$all=true]
         * @return Ability[]
         */
        static public function options (array $abilities = [], bool $all = true) {
            $collection = collect();

            foreach (Ability::$options as $option) {
                $option = new Ability($option);
                $found = false;
                
                foreach ($abilities as $data) {
                    if ($option->id_ability === $data["id_ability"]) {
                        $option->stars = (isset($data["stars"]) ? $data["stars"] : 0);
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
         * * Parse an Abilities array.
         * @param string [$abilities] Example: "[{\"id_ability\":1,\"stars\":3.5}]"
         * @return Ability[]
         */
        static public function parse (string $abilities = "") {
            $collection = collect();
            
            foreach (json_decode($abilities) as $data) {
                $ability = Ability::find($data->id_ability);
                
                $ability->and([["stars", (isset($data->stars) ? $data->stars : 0)]]);

                $collection->push($ability);
            }
            
            return $collection;
        }

        /**
         * * Stringify an Abilities array.
         * @param array [$abilities] Example: [["id_ability"=>1,"stars"=>3.5]]
         * @return string
         */
        static public function stringify (array $abilities = []) {
            $collection = collect();

            foreach ($abilities as $data) {
                $collection->push([
                    "id_ability" => $data["id_ability"],
                    "stars" => (isset($data["stars"]) ? $data["stars"] : 0),
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Requilify the Abilities by the User Reviews.
         * @param int $id_user
         * @param array [$abilities] Example: [["id_ability"=>1]]
         * @return JSON
         */
        static public function requilify (int $id_user, array $abilities = []) {
            $user = User::find($id_user);
            $user->and(["reviews"]);

            $collection = collect();
            
            foreach ($abilities as $data) {
                $ability = Ability::find($data->id_ability);
                
                $stars = 0;
                $quantity = 0;

                foreach ($user->reviews as $review) {
                    foreach ($review->abilities as $reviewAbility) {
                        if ($ability->id_ability !== $reviewAbility->id_ability) {
                            continue;
                        }

                        $stars += $reviewAbility->stars;
                        $quantity++;
                    }
                }

                $ability->stars = ($stars ? $stars / $quantity : 0);

                $collection->push([
                    "id_ability" => $ability->id_ability,
                    "stars" => $ability->stars,
                ]);
            }
            
            return $collection->toJson();
        }

        /**
         * * Get a Ability by the slug.
         * @param string $slug
         * @return Ability
         */
        static public function findBySlug (string $slug = "") {
            return Ability::where("slug", "=", $slug)->first();
        }

        /**
         * * Ability options.
         * @var array
         */
        static $options = [
            [
                "id_ability" => 1,
                "name" => "Comunicación",
                "description" => "",
                "slug" => "comunicacion",
                "stars" => null,
            ], [
                "id_ability" => 2,
                "name" => "Flexibilidad",
                "description" => "",
                "slug" => "flexibilidad",
                "stars" => null,
            ], [
                "id_ability" => 3,
                "name" => "Conexión",
                "description" => "",
                "slug" => "conexion",
                "stars" => null,
            ], [
                "id_ability" => 4,
                "name" => "Experiencia",
                "description" => "",
                "slug" => "experiencia",
                "stars" => null,
            ],
        ];
    }