<?php
    namespace App\Models;

    use App\Models\Message;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Chat extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'chats';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_chat';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'logged_at', 'messages',
        ];

        /**
         * * The attributes that should be cast to native types.
         * @var array
         */
        protected $casts = [
            'logged_at' => \App\Casts\LoggedAt::class,
            'messages' => \App\Casts\Message::class,
        ];

        /**
         * * Returns if the Chat is available.
         * @return bool
         */
        public function getAvailableAttribute () {
            switch ($this->id_type) {
                case 2:
                    return !$this->lessons->last()->ended;
                default:
                    return true;
            }
        }

        /**
         * * Returns the Chat "id_type".
         * @return int
         */
        public function getIdTypeAttribute () {
            if ($this->from->id_role == 0) {
                return 1;
            }

            return 2;
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
                        'name' => 'Friend',
                        'slug' => 'friend',
                    ];
                case 2:
                    return (object) [
                        'id_type' => 2,
                        'name' => 'Lesson',
                        'slug' => 'lesson',
                    ];
            }
        }

        /**
         * * Set the Chat for API use. 
         * @return void
         */
        public function api () {
            $this->id_type = $this->id_type;

            $this->from->and(['abilities', 'files', 'games']);

            $this->to->and(['files', 'games']);

            $this->auth->and(['files', 'games']);

            $this->available = $this->available;

            foreach ($this->lessons as $lesson) {
                $lesson->and(['assignments']);

                foreach ($lesson->assignments as $assignment) {
                    $assignment->presentation;
                }
            }

            $this->notAuth->and(['files', 'games']);

            foreach ($this->messages as $message) {
                $message->api();
            }

            if ($this->id_type == 2) {
                $this->start();
            }
        }

        /**
         * * Get the User "authenticated" that owns the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function auth () {
            return $this->belongsTo(User::class, Auth::user()->id_user == $this->attributes['id_user_from'] ? 'id_user_from' : 'id_user_to', 'id_user');
        }

        /**
         * * Get the User "from" that owns the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function from () {
            return $this->belongsTo(User::class, 'id_user_from', 'id_user');
        }

        /**
         * * Get all of the Lessons for the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function lessons () {
            return $this->hasMany(Lesson::class, 'id_user_from', 'id_user_from')->where('id_user_to', $this->attributes['id_user_to']);
        }

        /**
         * * Log an User in the Chat.
         * @return void
         */
        public function login () {
            $this->update([
                'logged_at' => Auth::user()->id_user,
            ]);
        }

        /**
         * * Get the User "not authenticated" that owns the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function notAuth () {
            return $this->belongsTo(User::class, Auth::user()->id_user == $this->attributes['id_user_from'] ? 'id_user_to' : 'id_user_from', 'id_user');
        }
       
        /**
         * * Send a new Chat Message.
         * @param array $data
         */
        public function send (array $data = []) {
            $this->update([
                'messages' => $data,
                'logged_at' => Auth::user()->id_user,
            ]);
        }

        /**
         * * Start the Chat Lesson.
         * @return void
         */
        public function start () {
            $quantity = count($this->messages);

            foreach ($this->lessons as $lesson) {
                if ($lesson->ended) {
                    foreach ($lesson->assignments as $assignment) {
                        $quantity--;
                    }
                    $quantity--;

                    continue;
                } else if ($quantity == 0) {
                    $message = new Message([
                        'abilities' => $this->to->games->last()->abilities,
                        'id_lesson' => $this->lessons->last()->id_lesson,
                        'id_message' => $this->messages->count()
                            ? $this->messages->count() + 1
                            : 1,
                        'created_at' => Carbon::now(),
                    ]);
    
                    $message->id_type = $message->id_type;
                    
                    $message->selected = false;

                    $message->disabled = Auth::user()->id_role == 1;

                    $this->messages->push($message);
                }

                break;
            }
        }

        /**
         * * Get the User "to" that owns the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function to () {
            return $this->belongsTo(User::class, 'id_user_to', 'id_user');
        }

        /**
         * * Get all of the Users for the Chat.
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function users () {
            return $this->hasMany(User::class, 'id_user_from', 'id_user_from')->orwhere('id_user_to', $this->attributes['id_user_to']);
        }

        /**
         * * Scope a query to only include Abilities where their id_user matches one of them.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUser ($query, int $id_user) {
            return $query->where('id_user_from', $id_user)->orwhere('id_user_to', $id_user);
        }

        /**
         * * Scope a query to only include Abilities where their id_user matches both.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user_1
         * @param  int $id_user_2
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUsers ($query, $id_user_1, $id_user_2) {
            return $query->where([
                ['id_user_from', $id_user_1],
                ['id_user_to', $id_user_2],
            ])->orwhere([
                ['id_user_from', $id_user_2],
                ['id_user_to', $id_user_1],
            ]);
        }

        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            'send' => [
                'abilities' => [
                    'rules' => [
                        'id_type' => 'required',
                    ], 'messages' => [
                        'es' => [
                            'id_type.required' => 'El tipo de mensaje es obligatorio.',
                        ],
                    ],
                ], 'says' => [
                    'rules' => [
                        'id_type' => 'required',
                        'message' => 'required',
                    ], 'messages' => [
                        'es' => [
                            'message.required' => 'El mensaje es obligatorio.',
                            'id_type.required' => 'El tipo de mensaje es obligatorio.',
                        ],
                    ],
                ],
            ],
        ];
    }