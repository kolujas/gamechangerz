<?php
    namespace App\Models;

    use App\Models\Lesson;
    use Illuminate\Database\Eloquent\Model;

    class Price extends Model {
        /**
         * * Parse a Prices array.
         * @param string [$prices] Example: "[{\"id_lesson\":1,\"price\":500}]"
         * @return Price[]
         */
        static public function parse (string $prices = '') {
            $collection = collect();

            foreach (json_decode($prices) as $data) {
                $type = Lesson::option($data->id_lesson);
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

            foreach ($prices as $id_lesson => $data) {
                $collection->push([
                    "id_lesson" => $id_lesson + 1,
                    "price" => $data,
                ]);
            }

            return $collection->toJson();
        }
    }