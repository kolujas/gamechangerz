<?php
    namespace App\Models;

    use App\Models\Message;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Chat extends Model {
        use HasFactory;

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

        public function messages () {
            $this->messages = Message::parse(json_decode($this->messages));
        }

        /**
         * * Get the Chat User who is not the logged in.
         * @return array
         */
        public function user ($user) {
            $this->user = User::find(($user->id_user === $this->id_user_from ? $this->id_user_to : $this->id_user_from));
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
    }