<?php
    namespace App\Models;

    use App\Models\Message;
    use App\Models\User;
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
            'id_user_from', 'id_user_to', 'messages',
        ];

        /**
         * * Set the Chat info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'available':
                            $this->available();
                            break;
                        case 'lessons':
                            $this->lessons();
                            break;
                        case 'messages':
                            $this->messages();
                            break;
                        case 'users':
                            $this->users();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case 'available':
                        $this->available($column[1]);
                        break;
                }
            }
        }

        /**
         * * Set if the Chat is available.
         */
        public function available ($id_user_logged = null) {
            $user = User::find($this->id_user_from);
            
            $this->available = false;
            if ($user->id_role === 0 || $user->id_role === 2) {
                $this->available = true;
            }
            if ($user->id_role === 1) {
                $this->lessons();
                if ($id_user_logged != $user->id_user) {
                    $this->available = true;
                }
                if ($id_user_logged == $user->id_user) {
                    if (gettype($this->messages) == 'string') {
                        $this->messages();
                    }
                    if (count($this->messages) >= 1) {
                        $this->available = true;
                    }
                }
            }
        }

        /**
         * * Set the chat Lesson.
         */
        public function lessons () {
            $this->lessons = collect();
            $lessons = Lesson::byUsers($this->id_user_from, $this->id_user_to)->get();

            foreach ($lessons as $lesson) {
                if ($lesson->id_type == 2) {
                    $lesson->and(['assignments', 'days', 'ended_at', 'started_at']);
                    $this->lessons->push($lesson);
                }
            }
        }

        /**
         * * Set the Chat Messages.
         */
        public function messages () {
            if (gettype($this->messages) == 'string') {
                $this->messages = Message::parse($this->messages);
            }
        }

        /**
         * * Set the Chat Users.
         */
        public function users () {
            $this->users = (object) [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];

            $this->users->from->and(['files', 'games']);
            $this->users->to->and(['files', 'games']);
        }
       
        /**
         * * Add a new Chat Message
         * @param array $data
         */
        public function addMessage (array $data = []) {
            $messages = collect();
            $id_message = 1;

            foreach (json_decode($this->messages) as $message) {
                $id_message = intval($message->id_message) + 1;
                $messages->push($message);
            }

            $data['id_message'] = $id_message;

            $messages->push($data);

            $this->update([
                'messages' => $messages->toJson(),
            ]);
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
        static public function scopeByUsers ($query, int $id_user_1, int $id_user_2) {
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
                'rules' => [
                    'message' => 'required',
                ], 'messages' => [
                    'es' => [
                        'message.required' => 'El mensaje es obligatorio.',
                    ],
                ],
            ],
        ];
    }