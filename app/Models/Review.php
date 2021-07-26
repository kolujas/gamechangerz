<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Game;
    use App\Models\Lesson;
    use App\Models\User;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Review extends Model {
        use Sluggable, SluggableScopeHelpers;

        /**
         * * Table name.
         * @var string
         */
        protected $table = 'reviews';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_review';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_game', 'id_lesson', "id_user_from", "id_user_to", 'title', 'description', 'abilities', 'slug', "stars"
        ];

        /**
         * * Set the Review info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
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
                    continue;
                }
                switch ($column[0]) {
                    default:
                        break;
                }
            }
        }

        /**
         * * Set the Review Abilities.
         */
        public function abilities () {
            $this->users();

            if ($this->users->to->id_role === 0) {
                $this->abilities = Ability::parse($this->abilities);
            }
            if ($this->users->to->id_role === 1) {
                $abilities = collect();

                foreach (json_decode($this->abilities) as $ability) {
                    $ability = new Ability((array) $ability);
                    $abilities->push($ability);
                }

                $this->abilities = Ability::options($abilities->toArray());
            }
        }

        /**
         * * Set the Review Game.
         */
        public function game () {
            $this->game = Game::find($this->id_game);
            $this->game->and(['colors', 'files']);
        }

        /**
         * * Set the Review Lesson.
         */
        public function lesson () {
            $this->lesson = Lesson::find($this->id_lesson);
            $this->lesson->and(['type']);
        }
        
        /**
         * * The Sluggable configuration for the Model.
         * @return array
         */
        public function sluggable (): array {
            return [
                'slug' => [
                    'source'	=> 'title',
                    'onUpdate'	=> true,
                ]
            ];
        }

        /**
         * * Set the Review Users.
         */
        public function users () {
            $this->users = (object) [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];

            $this->users->from->and(['files']);
            $this->users->to->and(['files']);

            if ($this->users->from->id_role === 1) {
                $this->users->from->and(['teampro']);
            }
            if ($this->users->to->id_role === 1) {
                $this->users->to->and(['teampro']);
            }
        }

        /**
         * * Get all the Reviews from a Lesson.
         * @param int $id_lesson
         * @return Review[]
         */
        static public function allFromLesson (int $id_lesson) {
            $reviews = Review::where("id_lesson", "=", $id_lesson)->get();

            return $reviews;
        }

        /**
         * * Get all the Reviews done to an User.
         * @param int $id_user
         * @return Review[]
         */
        static public function allToUser (int $id_user) {
            $reviews = Review::where("id_user_to", "=", $id_user)->get();

            return $reviews;
        }
        
        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            'create' => [
                'rules' => [
                    'title' => 'required|max:100',
                    'description' => 'required|max:150',
                ], 'messages' => [
                    'es' => [
                        'title.required' => 'El título es obligatorio.',
                        'title.max' => 'El título no puede tener más de :max caracteres.',
                        'description.required' => 'La descripción es obligatoria.',
                        'description.max' => 'La descripción no puede tener más de :max caracteres.',
        ]]]];
    }