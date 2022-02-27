<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Assignment;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_message';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'abilities', 'id_assignment', 'id_lesson', 'id_message', 'id_user', 'says', 'created_at',
        ];

        /**
         * * The attributes that should be cast to native types.
         * @var array
         */
        protected $casts = [
            'abilities' => \App\Casts\Ability::class,
            'created_at' => \App\Casts\Carbon::class,
        ];

        /**
         * * Returns the Message "id_type".
         * @return int
         */
        public function getIdTypeAttribute () {
            if (isset($this->attributes['says'])) {
                return 1;
            }
            if (isset($this->attributes['abilities'])) {
                return 2;
            }
            if (isset($this->attributes['id_assignment'])) {
                return 3;
            }
        }

        /**
         * * Returns the Chat "type".
         * @return object
         */
        public function getTypeAttribute () {
            switch ($this->id_type) {
                case 1:
                    return (object) [
                        'id_type' => 1,
                        'name' => 'Text',
                        'slug' => 'text',
                    ];
                case 2:
                    return (object) [
                        'id_type' => 2,
                        'name' => 'Ability',
                        'slug' => 'ability',
                    ];
                case 3:
                    return (object) [
                        'id_type' => 3,
                        'name' => 'Assignment',
                        'slug' => 'assignment',
                    ];
            }
        }

        /**
         * * Set the Message for API use. 
         * @return void
         */
        public function api () {
            if ($this->assignment) {
                $this->assignment->presentation;
            }

            $this->id_type = $this->id_type;

            if ($this->id_type == 2) {
                $this->selected = true;
                $this->disabled = true;
            }
        }

        /**
         * * Get the Assignment that owns the Message.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function assignment () {
            return $this->belongsTo(Assignment::class, 'id_assignment', 'id_assignment');
        }

        /**
         * * Get the User that owns the Message.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function user () {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }
    }