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
            foreach ($pricesToParse as $price) {
                if (Lesson::has($price->id_lesson)) {
                    $prices->push(Lesson::find($price->id_lesson));
                }
            }
            return $prices;
        }
    }