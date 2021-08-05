<?php
    namespace App\Models;

    use App\Models\Lesson;
    use Illuminate\Database\Eloquent\Model;

    class Price extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_price';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_price', 'name', 'icon', 'price', 'slug'
        ];

        /**
         * * Parse a Prices array.
         * @param string [$prices] Example: "[{\"id_type\":1,\"price\":500}]"
         * @return Price[]
         */
        static public function parse (string $prices = '') {
            $collection = collect();

            foreach (json_decode($prices) as $data) {
                $type = Lesson::option($data->id_type);
                $type->price = $data->price;

                $collection->push($type);
            }

            return $collection;
        }

        /**
         * * Stringify a Prices array.
         * @param array [$prices] Example: [0=>500]]
         * @return string
         */
        static public function stringify (array $prices = []) {
            $collection = collect();

            foreach ($prices as $id_type => $data) {
                $collection->push([
                    "id_type" => $id_type + 1,
                    "price" => $data,
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Returns the Price options.
         * @param array [$prices] Example: [["id_price"=>1]]
         * @param bool [$all=true]
         * @return Price[]
         */
        static public function options (array $prices = [], bool $all = true) {
            $collection = collect();

            foreach (Price::$options as $option) {
                $option = new Price($option);
                $found = false;
                
                foreach ($prices as $data) {
                    if ($option->id_price === $data['id_price']) {
                        $found = true;
                        $price = $data['price'];
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($option);
                }
            }

            return $collection;
        }

        /**
         * * Price options.
         * @var array
         */
        static $options = [[
            'id_price' => 1,
            'name' => 'Online',
            'icon' => 'ClaseOnline1SVG',
            'slug' => 'online',
            'price' => 0
        ], [
            'id_price' => 2,
            'name' => 'Offline',
            'icon' => 'ClaseOnline2SVG',
            'slug' => 'offline',
            'price' => 0
        ], [
            'id_price' => 3,
            'name' => 'Pack',
            'icon' => 'ClaseOnline3SVG',
            'slug' => 'pack',
            'price' => 0
        ]];
    }