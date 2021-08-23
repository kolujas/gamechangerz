<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Method extends Model {
        /**
         * * Table primary key name
         * @var string
         */
        protected $primaryKey = "id_method";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_method", "name", "slug", "access_token",
        ];

        /**
         * * Check if a Method exists.
         * @param int $id_method
         * @return bool
         */
        static public function has (int $id_method) {
            foreach (Method::$options as $option) {
                if ($option["id_method"] === $id_method) {
                    return true;
                }
            }

            return false;
        }

        /**
         * * Returns a Method.
         * @param int $id_method
         * @return Method
         */
        static public function option (int $id_method) {
            foreach (Method::$options as $option) {
                if ($option["id_method"] === $id_method) {
                    return new Method($option);
                }
            }

            dd("Method \"$id_method\" not found");
        }

        /**
         * * Returns the Method options.
         * @param array [$methods] Example: [["id_method"=>1]]
         * @param bool [$all=true]
         * @return Method[]
         */
        static public function options (array $methods = [], bool $all = true) {
            $collection = collect();

            foreach (Method::$options as $method) {
                $method = new Method($method);
                $found = false;
                
                foreach ($methods as $data) {
                    if ($method->id_method === $data["id_method"]) {
                        $found = true;
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($method);
                }
            }

            return $collection;
        }

        /**
         * * Parse a Methods array.
         * @param string [$methods] Example: "[{\"id_method\":1,\"access_token\":\"something\"}]"
         * @return Game[]
         */
        static public function parse (string $methods = "") {
            $collection = collect();

            foreach (json_decode($methods) as $data) {
                $method = Method::option($data->id_method);
                $method->access_token = $data->access_token;

                $collection->push($method);
            }

            return $collection;
        }

        /**
         * * Stringify a Methods array.
         * @param array [$methods] Example: [["id_method"=>1,"access_token"=>"something"]]
         * @return string
         */
        static public function stringify (array $methods = []) {
            $collection = collect();
            
            foreach ($methods as $data) {
                $collection->push([
                    "id_method" => $data["id_method"],
                    "access_token" => $data["access_token"],
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Method options.
         * @var array
         */
        static $options = [[
            "id_method" => 1,
            "name" => "MercadoPago",
            "slug" => "mercadopago",
        ], [
            "id_method" => 2,
            "name" => "PayPal",
            "slug" => "paypal",
        ]];
    }