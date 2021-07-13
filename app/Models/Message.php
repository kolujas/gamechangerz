<?php
    namespace App\Models;

    use App\Models\Assigment;
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
            'id_message', 'id_user', 'says', 'id_assigment',
        ];

        /**
         * * Set the Message info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'assigment':
                            $this->assigment();
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
         * * Set the Message Assigment
         */
        public function assigment () {
            $this->assigment = Assigment::find($this->id_assigment);
            $this->assigment->and(['abilities', 'game']);
            $this->assigment->game->and(['abilities']);
        }

        /**
         * * Parse a Messages array.
         * @param string [$messages] Example: "[{\"id_message\":1,\"id_user\":1,\"says\":\"Hi!\"}]"
         * @return Message[]
         */
        static public function parse (string $messages = '') {
            $collection = collect();
            
            foreach (json_decode($messages) as $data) {
                $props = [
                    'id_message' => $data->id_message,
                    'id_user' => $data->id_user,
                ];

                if (isset($data->says)) {
                    $props['says'] = $data->says;
                }

                if (isset($data->id_assigment)) {
                    $props['id_assigment'] = $data->id_assigment;
                }

                $message = new Message($props);

                if (isset($data->id_assigment)) {
                    $message->and(['assigment']);
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
                    "id_message" => $data['id_message'],
                    "id_user" => $data['id_user'],
                ];

                if (isset($data['says'])) {
                    $message['says'] = $data['says'];
                }

                if (isset($data['id_assigment'])) {
                    $message['id_assigment'] = $data['id_assigment'];
                }

                $collection->push($message);
            }

            return $collection->toJson();
        }
    }