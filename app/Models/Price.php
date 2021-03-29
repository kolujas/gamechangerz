<?php
    namespace App\Models;

    use App\Models\Lesson;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Price extends Model {
        use HasFactory;

        /**
         * * Parse a Prices array.
         * @param array $pricesToParse Example: "[{\"id_lesson\":1,\"price\":500}]"
         * @return array
         */
        static public function parse ($pricesToParse) {
            $prices = collect([]);
            $pricesToParse[2] = [
                'id_lesson' => 3,
                'price' => intval($pricesToParse[0]->price) * 3,
            ];
            foreach ($pricesToParse as $price) {
                $price = (object) $price;
                if (Lesson::hasOptions($price->id_lesson)) {
                    $lesson = Lesson::findOptions($price->id_lesson);
                    $lesson->price = $price->price;
                    $prices->push($lesson);
                }
            }
            return $prices;
        }
    }