<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;

    class UserController extends Controller {
        public function teachers (Request $request) {
            $users = User::where('id_role', '=', 1)->get();
            foreach ($users as $user) {
                $user->and(['games', 'files', 'prices', 'teampro', 'languages']);
                foreach ($user->games as $game) {
                    $game->and(['abilities', 'files']);
                }
            }
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'users' => $users,
                ],
            ]);
        }

        public function users (Request $request) {
            $users = User::where('id_role', '=', 0)->get();
            foreach ($users as $user) {
                $user->and(['lessons', 'games', 'files', 'hours', 'achievements']);
                foreach ($user->games as $game) {
                    $game->and(['files']);
                }
            }
            return response()->json([
                'code' => 200,
                'message' => 'Success',
                'data' => [
                    'users' => $users,
                ],
            ]);
        }
    }