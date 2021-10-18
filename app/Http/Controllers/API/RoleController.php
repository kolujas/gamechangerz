<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;

    class RoleController extends Controller {
        /**
         * * Get the User Role.
         * @param  \Illuminate\Http\Request  $request
         * @return JSON
         */
        public function get (Request $request) {
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'id_role' => $request->user()->id_role,
                ],
            ]);
        }
    }