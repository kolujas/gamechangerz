<?php
    namespace App\Models;

    use App\Models\Lesson;
    use Illuminate\Database\Eloquent\Model;

    class Price extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_lesson';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_lesson', 'price',
        ];

        /**
         * * Parse a Prices array.
         * @param array $pricesToParse Example: "[{\"id_lesson\":1,\"price\":500}]"
         * @return Price[]
         * @throws
         */
        static public function parse ($pricesToParse = []) {
            $prices = collect([]);
            // $pricesToParse[] = (object)[
            //     'id_lesson' => 3,
            //     'price' => intval($pricesToParse[0]->price) * 3,
            // ];
            foreach ($pricesToParse as $data) {
                if (!Lesson::has($data->id_lesson)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Lesson with id = \"$data->id_lesson\" does not exist",
                    ];
                }
                $lesson = Lesson::one($data->id_lesson);
                $lesson->price = $data->price;
                $prices->push($lesson);
            }
            return $prices;
        }

        static public function stringify ($priceToParse = []) {
            $prices = [];
            foreach ($priceToParse as $id_lesson => $price) {
                $prices[] = [
                    "id_lesson" => $id_lesson + 1,
                    "price" => $price,
                ];
            }
            return json_encode($prices);
        }
    }