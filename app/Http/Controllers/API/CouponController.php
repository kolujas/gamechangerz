<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Coupon;
    use Illuminate\Http\Request;

    class CouponController extends Controller {
        function check (Request $request) {
            $input = (object) $request->all();

            if (!$input->coupon) {
                return response()->json([
                    "code" => 200,
                    "message" => "El cupón no existe.",
                ]);
            }

            $coupon = Coupon::findByName($input->coupon);

            if (!$coupon) {
                return response()->json([
                    "code" => 404,
                    "message" => "El cupón no existe.",
                ]);
            }

            if ($coupon->limit) {
                $coupon->and(["used"]);

                if (intval($coupon->used) >= intval($coupon->limit)) {
                    return response()->json([
                        "code" => 403,
                        "message" => "El cupón ha caducado.",
                    ]);
                }
            }
            
            $coupon->and(["type"]);

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "coupon" => $coupon,
                ],
            ]);
        }
    }