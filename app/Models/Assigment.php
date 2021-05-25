<?php
    namespace App\Models;

    use App\Models\Ability;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Database\Eloquent\Model;

    class Assigment extends Model {
        use Sluggable, SluggableScopeHelpers;

        /** @var string Table name */
        protected $table = 'assigments';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_assigment';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'abilities', 'description', 'id_lesson', 'id_game', 'slug', 'title', 'url',
        ];

        /**
         * * Get the Assigment Abilities.
         * @return array
         */
        public function abilities () {
            $this->abilities = Ability::parse(json_decode($this->abilities));
        }

        /**
         * * Get the Assigment info. 
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
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the Assigment Game.
         * @throws
         */
        public function game () {
            try {
                $this->game = Game::one($this->id_game);
            } catch (\Throwable $th) {
                throw $th;
            }
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
        
        /** @var array Validation rules & messages. */
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