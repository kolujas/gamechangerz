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
         * * Get the Lesson that owns the Assignment.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function lesson () {
            return $this->belongsTo(Lesson::class, 'id_lesson', 'id_lesson');
        }

        /**
         * * Get the Presentation that owns the Assignment.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function presentation () {
            return $this->belongsTo(Presentation::class, 'id_assignment', 'id_assignment');
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