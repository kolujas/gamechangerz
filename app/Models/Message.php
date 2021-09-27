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
        protected $primaryKey = "id_message";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "abilities",
            "id_assignment",
            "id_lesson",
            "id_message",
            "id_user",
            "says",
        ];

        /**
         * * Set the Message info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "abilities":
                            $this->abilities();
                            break;
                        case "assignment":
                            $this->assignment();
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
         * * Set the Message Assignment
         */
        public function abilities () {
            $this->abilities = Ability::parse(json_encode($this->abilities));
        }

        /**
         * * Set the Message Assignment
         */
        public function assignment () {
            $this->assignment = Assignment::find($this->id_assignment);
            $this->assignment->and(["presentation"]);
        }

        /**
         * * Parse a Messages array.
         * @param string [$messages] Example: "[{\"id_message\":1,\"id_user\":1,\"says\":\"Hi!\"}]"
         * @return Message[]
         */
        static public function parse (string $messages = "") {
            $collection = collect();
            
            foreach (json_decode($messages) as $data) {
                $props = [
                    "id_message" => $data->id_message,
                    "id_user" => $data->id_user,
                ];

                if (isset($data->says)) {
                    $props["says"] = $data->says;
                }

                if (isset($data->id_assignment)) {
                    $props["id_assignment"] = $data->id_assignment;
                }

                if (isset($data->id_lesson)) {
                    $props["id_lesson"] = $data->id_lesson;
                }

                if (isset($data->abilities)) {
                    $props["abilities"] = $data->abilities;
                }

                $message = new Message($props);

                if (isset($data->id_assignment)) {
                    $message->and(["assignment"]);
                }

                if (isset($data->abilities)) {
                    $message->and(["abilities"]);
                }

                $collection->push($message);
            }

            return $collection;
        }

        /**
         * * Stringify a Messages array.
         * @param array [$message] Example: [["id_message"=>1,"stars"=>3.5]]
         * @return string
         */
        static public function stringify (array $message = []) {
            $collection = collect();

            foreach ($message as $data) {
                $message = [
                    "id_message" => $data["id_message"],
                    "id_user" => $data["id_user"],
                ];

                if (isset($data["says"])) {
                    $message["says"] = $data["says"];
                }

                if (isset($data["id_assignment"])) {
                    $message["id_assignment"] = $data["id_assignment"];
                }

                if (isset($data["id_lesson"])) {
                    $message["id_lesson"] = $data["id_lesson"];
                }

                $collection->push($message);
            }

            return $collection->toJson();
        }
    }