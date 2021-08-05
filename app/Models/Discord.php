<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Discord extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "username", "link",
        ];

        /**
         * * Parse a Discords array.
         * @param string [$data] Example: "[{\"username\":"someone#0000",\"link\":\"https://discord.gg/aaaaa\"}]"
         * @return Game[]
         */
        static public function parse ($data = "") {
            if ($data !== "" && $data) {
                $data = json_decode($data);
    
                if (isset($data->link)) {
                    return new Discord([
                        "username" => $data->username,
                        "link" => $data->link,
                    ]);
                }
                if (isset($data->username)) {
                    return new Discord([
                        "username" => $data->username,
                    ]);
                }
            }
            
            return new Discord();
        }

        /**
         * * Stringify a Discords array.
         * @param array [$data] Example: [["username"=>"someone#0000","link"=>"https://discord.gg/aaaaa"]]
         * @return string
         */
        static public function stringify (array $data = []) {
            if (isset($data["link"])) {
                return json_encode([
                    "username" => $data["username"],
                    "link" => $data["link"],
                ]);
            }
            return json_encode([
                "username" => $data["username"],
            ]);
        }
    }