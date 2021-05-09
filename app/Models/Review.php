<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Game;
    use App\Models\Lesson;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Review extends Model {
        /** @var string Table name */
        protected $table = 'reviews';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_review';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'title', 'description', 'abilities', 'slug,'
        ];

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
                        case 'game':
                            $this->game();
                            break;
                        case 'lesson':
                            $this->lesson();
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
         * * Get the User Abilities.
         * @return array
         */
        public function abilities () {
            $this->abilities = Ability::parse(json_decode($this->abilities));
        }

        /**
         * * Get the Review Lesson.
         * @return array
         * @throws
         */
        public function lesson () {
            if (!Lesson::has($this->id_lesson)) {
                throw (object)[
                    'code' => 404,
                    'message' => "Lesson with id = \"$this->id_lesson\" does not exist",
                ];
            }
            $this->lesson = Lesson::one($this->id_lesson);
        }

        /**
         * * Get the Review Users.
         * @return array
         */
        public function users () {
            $this->users = [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
        }

        /**
         * * Get the Review Game.
         * @return array
         */
        public function game () {
            $this->game = Game::getByAbility($this->abilities);
        }
    }