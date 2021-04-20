<?php
    namespace App\Models;

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
            $this->messages = json_decode($this->messages);
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
    }