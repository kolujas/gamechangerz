<?php
    namespace App\Models;

    use App\Models\Message;
    use App\Models\User;
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