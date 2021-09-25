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
        protected $table = "chats";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_chat";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_user_from", "id_user_to", "messages",
        ];

        /**
         * * Set the Chat info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "available":
                            $this->available();
                            break;
                        case "lesson":
                            $this->lesson();
                            break;
                        case "messages":
                            $this->messages();
                            break;
                        case "users":
                            $this->users();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case "available":
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
                if (!isset($this->lessons)) {
                    $this->lesson();
                }
                if ($id_user_logged != $user->id_user) {
                    $this->available = true;
                }
                if ($id_user_logged == $user->id_user) {
                    if (gettype($this->messages) == "string") {
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
        public function lesson () {
            $this->lesson = Lesson::findByUsers($this->id_user_from, $this->id_user_to);
            
            $this->lesson->and(["assignments", "days", "ended_at", "started_at"]);
        }

        /**
         * * Set the Chat Messages.
         */
        public function messages () {
            if (gettype($this->messages) == "string") {
                $this->messages = Message::parse($this->messages);
            }
        }

        /**
         * * Set the Chat Users.
         */
        public function users () {
            $this->users = (object) [
                "from" => User::find($this->id_user_from),
                "to" => User::find($this->id_user_to),
            ];

            $this->users->from->and(["files", "games"]);
            $this->users->to->and(["files", "games"]);
        }

        /**
         * * Get all the Chats from an User.
         * @param int $id_user
         * @return Chat[]
         */
        static public function allFromUser (int $id_user) {
            $chats = Chat::where("id_user_from", "=", $id_user)->orwhere("id_user_to", "=", $id_user)->orderBy("updated_at", "DESC")->get();

            return $chats;
        }

        /**
         * * Check if a Chat exist by the Users.
         * @param int $id_user_1
         * @param int $id_user_2
         * @return bool
         */
        static public function exist (int $id_user_1, int $id_user_2) {
            $chat = Chat::findByUsers($id_user_1, $id_user_2);

            if (!$chat) {
                return false;
            }

            return true;
        }

        /**
         * * Get a Chat by the Users.
         * @param int $id_user_1
         * @param int $id_user_2
         * @return Chat
         */
        static public function findByUsers (int $id_user_1, int $id_user_2) {
            $chat = Chat::where([
                ["id_user_from", "=", $id_user_1],
                ["id_user_to", "=", $id_user_2],
            ])->orwhere([
                ["id_user_from", "=", $id_user_2],
                ["id_user_to", "=", $id_user_1],
            ])->first();

            return $chat;
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

            $data["id_message"] = $id_message;

            $messages->push($data);

            $this->update([
                "messages" => $messages->toJson(),
            ]);
        }

        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            "send" => [
                "rules" => [
                    "message" => "required",
                ], "messages" => [
                    "es" => [
                        "message.required" => "El mensaje es obligatorio.",
        ]]]];
    }