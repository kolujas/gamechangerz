<?php
    namespace App\Http\Controllers;

    use App\Models\Friend;
    use App\Models\User;
    use Auth;
    use Illuminate\Http\Request;

    class FriendshipController extends Controller {
        public function call (Request $request, $slug, $action) {
            switch (strtoupper($action)) {
                case 'ACCEPT':
                    $response = (object) $this->accept($request);
                    break;
                case 'CANCEL':
                    $response = (object) $this->cancel($request);
                    break;
                case 'DELETE':
                    $response = (object) $this->delete($request);
                    break;
                case 'REQUEST':
                    $response = (object) $this->request($request);
                    break;
            }
            if ($response->code !== 200) {
                $request->session()->put('error', $response);
                return redirect("/users/$slug/profile");
            }
            return redirect("/users/$slug/profile")->with('status', $response);
        }

        public function accept (Request $request) {
            $user = User::where('slug', '=', $request->slug)->first();
            $user->and(['friends']);
            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }
            if (!$found) {
                return [
                    'code' => 403,
                    'message' => "You are not $request->slug's friend",
                ];
            }
            if ($found->accepted) {
                return [
                    'code' => 403,
                    'message' => "Friendship request accepted",
                ];
            }
            $found->update([
                'accepted' => 1,
            ]);
            return [
                'code' => 200,
                'message' => 'Solicitud aceptada',
            ];
        }

        public function cancel (Request $request) {
            $user = User::where('slug', '=', $request->slug)->first();
            $user->and(['friends']);
            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }
            if (!$found) {
                return [
                    'code' => 403,
                    'message' => "You are not $request->slug's friend",
                ];
            }
            $found->delete();
            return [
                'code' => 200,
                'message' => 'Solicitud cancelada',
            ];
        }

        public function delete (Request $request) {
            $user = User::where('slug', '=', $request->slug)->first();
            $user->and(['friends']);
            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }
            if (!$found) {
                return [
                    'code' => 403,
                    'message' => "You are not $request->slug's friend",
                ];
            }
            $found->delete();
            return [
                'code' => 200,
                'message' => 'Amigo eliminado',
            ];
        }

        public function request (Request $request) {
            $user = User::where('slug', '=', $request->slug)->first();
            $user->and(['friends']);
            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }
            if ($found) {
                return [
                    'code' => 403,
                    'message' => "You are \"$request->slug\"'s friend",
                ];
            }
            $friend = Friend::create([
                'id_user_from' => Auth::user()->id_user,
                'id_user_to' => $user->id_user,
                'accepted' => 0,
            ]);
            return [
                'code' => 200,
                'message' => 'Solicitud enviada',
            ];
        }
    }