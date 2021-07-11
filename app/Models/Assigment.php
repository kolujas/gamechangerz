<?php
    namespace App\Models;

    use App\Models\Ability;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Assigment extends Model {
        use Sluggable, SluggableScopeHelpers;

        /**
         * * Table name.
         * @var string
         */
        protected $table = 'assigments';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_assigment';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'abilities', 'description', 'id_lesson', 'id_game', 'slug', 'title', 'url',
        ];

        /**
         * * Set the Assigment info. 
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
         * * Set the Assigment Abilities.
         */
        public function abilities () {
            $this->abilities = Ability::parse($this->abilities);
        }

        /**
         * * Set the Assigment Game.
         */
        public function game () {
            $this->game = Game::find($this->id_game);

            $this->game->and(['abilities']);
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
         * * Get all the Assigments from a Lesson.
         * @param int $id_lesson
         * @return Assigment[]
         */
        static public function allFromLesson (int $id_lesson) {
            $assigments = Assigment::where("id_lesson", "=", $id_lesson)->get();

            return $assigments;
        }

        /**
         * * Get a Assigment by the slug.
         * @param string $slug
         * @return Assigment
         */
        static public function findBySlug (string $slug = '') {
            $assigment = Assigment::where('slug', '=', $slug)->first();

            return $assigment;
        }
        
        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            'make' => [
                'rules' => [
                    'title' => 'required|max:100',
                    'description' => 'max:255',
                    'url' => 'url',
                    'id_game' => 'required',
                    'abilities' => 'required',
                ], 'messages' => [
                    'es' => [
                        'title.required' => 'El título es obligatorio.',
                        'title.max' => 'El título no puede tener más de :max caracteres.',
                        'description.max' => 'La descripción no puede tener más de :max caracteres.',
                        'url.url' => 'La URL debe ser valida (https://youtube.be)',
                        'id_game.required' => 'El juego es obligatorio.',
                        'abilities.required' => 'Al menos una habilidad es obligatoria (recuerda que para eso tienes que elegir un juego primero).',
        ]]]];
    }