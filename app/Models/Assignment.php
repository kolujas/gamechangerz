<?php
    namespace App\Models;

    use App\Models\Lesson;
    use App\Models\Presentation;
    use Illuminate\Database\Eloquent\Model;

    class Assignment extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'assignments';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_assignment';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'id_lesson', 'url',
        ];

        /**
         * * Set the Assignment info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'lesson':
                            $this->lesson();
                            break;
                        case 'presentation':
                            $this->presentation();
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
         * * Set the Assignment Lesson.
         */
        public function lesson () {
            $this->lesson = Lesson::find($this->id_lesson);
            $this->lesson->and(['chat']);
        }

        /**
         * * Set the Assignment Presentation.
         */
        public function presentation () {
            $this->presentation = Presentation::byAssignment($this->id_assignment)->first();
        }
            
        /**
         * * Scope a query to only include Assignments where their id_lesson matches.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_lesson
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByLesson ($query, int $id_lesson) {
            return $query->where('id_lesson', $id_lesson);
        }
        
        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            'make' => [
                'rules' => [
                    'description' => 'required|max:1000',
                    'url' => 'nullable|url',
                ], 'messages' => [
                    'es' => [
                        'description.required' => 'La descripción es obligatoria.',
                        'description.max' => 'La descripción no puede tener más de :max caracteres.',
                        'url.url' => 'La URL debe ser valida (https://...)',
                    ],
                ],
            ],
        ];
    }