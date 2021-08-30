<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class GoogleController extends Controller {
        public function code (Request $request){
            return redirect()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "code" => $request->code,
                ],
            ]);
        }
    }