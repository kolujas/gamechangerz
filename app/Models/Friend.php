<?php
    namespace App\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Friend extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = "friends";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_friend";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "accepted",
            "id_user_from",
            "id_user_to",
        ];

        /**
         * * Set the Friend info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "users":
                            $this->users();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    default:
                        break;
                }
            }
        }

        /**
         * * Set the Friend Users.
         */
        public function users () {
            $this->users = (object) [
                "from" => User::find($this->id_user_from),
                "to" => User::find($this->id_user_to),
            ];
            $this->users->from->and(["files"]);
            $this->users->to->and(["files"]);
        }

        /**
         * * Get all the Friends from an User.
         * @param int $id_user
         * @return Friend[]
         */
        static public function allFromUser (int $id_user) {
            $chats = Friend::where("id_user_from", "=", $id_user)->orwhere("id_user_to", "=", $id_user)->get();

            return $chats;
        }

        /**
         * * Check if the Friend has an action.
         * @param string $name
         * @return bool
         */
        static public function hasAction (string $name) {
            switch (strtoupper($name)) {
                case "ACCEPT":
                case "CANCEL":
                case "DELETE":
                case "REQUEST":
                    return true;
                default:
                    return false;
            }
        }
    }