<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Coupon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class CouponController extends Controller {
        /**
         * * Call the correct function.
         * @param  \Illuminate\Http\Request  $request
         * @param string $section
         * @param string $action
         * @return \Illuminate\Http\Response
         */
        static public function call (Request $request, string $section, string $action) {
            switch ($action) {
                case "create":
                    return CouponController::doCreate($request);
                case "delete":
                    return CouponController::doDelete($request);
                case "update":
                    return CouponController::doUpdate($request);
                default:
                    dd("Call to an undefined action \"$action\"");
            }
        }

        /**
         * * Creates a Coupon.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doCreate (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Coupon::$validation["create"]["rules"], Coupon::$validation["create"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->type = Coupon::stringify((object) [
                "type" => $input->type,
                "value" => $input->value,
            ]);

            $input->slug = SlugService::createSlug(Coupon::class, "slug", $input->name);

            $coupon = Coupon::create((array) $input);

            return redirect("/panel/coupons/$coupon->slug")->with("status", [
                "code" => 200,
                "message" => "Cupón creado exitosamente.",
            ]);
        }

        /**
         * * Deletes a Coupon.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doDelete (Request $request) {
            $input = (object) $request->all();

            $coupon = Coupon::findBySlug($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Coupon::$validation["delete"]["rules"], Coupon::$validation["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $coupon->delete();

            return redirect("/panel/coupons")->with("status", [
                "code" => 200,
                "message" => "Cupón eliminado exitosamente.",
            ]);
        }

        /**
         * * Updates a Coupon.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doUpdate (Request $request) {
            $input = (object) $request->all();

            $coupon = Coupon::findBySlug($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Controller::replaceUnique(Coupon::$validation["update"]["rules"], $coupon->id_coupon), Coupon::$validation["update"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input->type = Coupon::stringify((object) [
                "type" => $input->type,
                "value" => $input->value,
            ]);

            if ($input->name !== $coupon->name) {
                $input->slug = SlugService::createSlug(Coupon::class, "slug", $input->name);
            }
            
            $coupon->update((array) $input);

            return redirect("/panel/coupons/$coupon->slug")->with("status", [
                "code" => 200,
                "message" => "Cupón actualizado exitosamente.",
            ]);
        }
    }