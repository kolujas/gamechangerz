<?php
    namespace App\Models;

    use App\Models\Message;
    use App\Models\User;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Chat extends Model {
        /** @var string Table name */
        protected $table = 'chats';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_chat';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'messages',
        ];

        /**
         * * Get the User info. 
         * @param array $columns
         * @throws
         */
        public function and ($columns = []) {
            try {
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'available':
                            $this->available();
                            break;
                        case 'ends':
                            $this->ends();
                            break;
                        case 'messages':
                            $this->messages();
                            break;
                        case 'type':
                            $this->type();
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

        public function available () {
            foreach ($this->users as $user) {
                if ($user->id_user === $this->id_user_from) {
                    $id_role = $user->id_role;
                    break;
                }
            }
            
            if ($id_role === 0) {
                $this->available = true;
            }
            if ($id_role === 1) {
                $now = Carbon::now();
                
                $this->available = false;
                $user->and(['days']);
                foreach ($user->days as $date) {
                    $date = (object) $date;
                    if ($now->dayOfWeek === $date->day->id_day) {
                        $this->available = true;
                        break;
                    }
                }
    
                if ($this->available) {
                    $this->available = false;
                    foreach ($date->hours as $hour) {
                        if ($now->format("H:i") > $hour->from && $now->format("H:i") < $hour->from) {
                            $this->available = true;
                            break;
                        }
                    }
                }
            }
        }

        public function ends () {
            $lesson = Lesson::where([
                ['id_user_from', '=', $this->users['from']->id_user],
                ['id_user_to', '=', $this->users['to']->id_user]
            ])->get()[0];
            $lesson->and(['days']);
            foreach ($lesson->days as $date) {
                foreach ($date['hours'] as $hour) {
                    if (!isset($to)) {
                        $to = $hour->to;
                    }
                    if ($to < $hour->to) {
                        $to = $hour->to;
                    }
                }
                if (!isset($ends)) {
                    $ends = $date['date'] . "T" . $hour->to;
                }
                if ($ends < $date['date'] . "T" . $hour->to) {
                    $ends = $date['date'] . "T" . $hour->to;
                }
            }
            $this->ends = $ends;
        } 

        /**
         * * Parse the Chat Messages.
         */
        public function messages () {
            $this->messages = Message::parse(json_decode($this->messages));
        }

        /**
         * * Parse the Chat type
         */
        public function type () {
            $this->messages();
            $this->id_type = 1;
            foreach ($this->messages as $message) {
                if (isset($message->id_assigment)) {
                    $this->id_type = 2;
                    break;
                }
            }
        }

        /**
         * * Get the Chat Users.
         * @return array
         */
        public function users () {
            $this->users = [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
        }

        /** @var array Validation rules & messages. */
        static $validation = [
            'send' => [
                'rules' => [
                    'message' => 'required',
                ], 'messages' => [
                    'es' => [
                        'message.required' => 'El mensaje es obligatorio.',
        ]]]];

        /**
         * * Check if a Chat exist by the Users
         * @param int $id_user_1
         * @param int $id_user_2
         * @return boolean
         */
        static public function exist ($id_user_1, $id_user_2) {
            return count(Chat::where([
                ['id_user_from', '=', $id_user_1],
                ['id_user_to', '=', $id_user_2]
            ])->orwhere([
                ['id_user_from', '=', $id_user_2],
                ['id_user_to', '=', $id_user_1]
            ])->get()) > 0;
        }
    }