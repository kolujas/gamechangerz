<?php
    namespace App\Models;

    use App\Models\Assignment;
    use Illuminate\Database\Eloquent\Model;

    class Presentation extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'presentations';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_presentation';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'id_assignment', 'url',
        ];

        /**
         * * Get the Assignment that owns the Presentation.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function assignment () {
            return $this->belongsTo(Assignment::class, 'id_assignment', 'id_assignment');
        }

        /**
         * * Scope a query to only include Posts where their id_assignment matches.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_assignment
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByAssignment ($query, int $id_assignment) {
            return $query->where('id_assignment', $id_assignment);
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