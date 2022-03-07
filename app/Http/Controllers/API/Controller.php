<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller as BaseController;
    use App\Models\Platform;
    use Illuminate\Http\Request;

    class Controller extends BaseController {
        /**
         * * Get the Platform dolar value.
         * @param  \Illuminate\Http\Request  $request
         * @return JSON
         */
        public function dolar (Request $request) {
            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "dolar" => Platform::dolar(),
                ],
            ]);
        }
    }