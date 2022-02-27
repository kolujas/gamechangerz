<?php
    namespace App\Http\Controllers;

    use App\Models\Chat;
    use App\Models\Friend;
    use App\Models\Mail;
    use App\Models\User;
    use Auth;
    use Illuminate\Http\Request;

    class FriendshipController extends Controller {
        /**
         * * Executes the Friendship function.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug
         * @param string $action
         * @return \Illuminate\Http\Response
         */
        public function call (Request $request, string $slug, string $action) {
            switch (strtoupper($action)) {
                case "ACCEPT":
                    return $this->accept($request);
                case "CANCEL":
                    return $this->cancel($request);
                case "DELETE":
                    return $this->delete($request);
                case "REQUEST":
                    return $this->request($request);
            }
        }

        /**
         * * Accepts the Friendship.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function accept (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::bySlug($slug)->first();

            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }

            if (!$found) {
                return redirect("/users/$slug/profile")->with("status", [
                    "code" => 403,
                    "message" => "You are not $slug\"s friend",
                ]);
            }

            if ($found->accepted) {
                return redirect("/users/$slug/profile")->with("status", [
                    "code" => 403,
                    "message" => "Friendship request accepted",
                ]);
            }

            $found->accept();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud aceptada",
            ]);
        }

        /**
         * * Cancel the Friendship.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function cancel (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::bySlug($slug)->first();
            $found = false;
            
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }

            if (!$found) {
                return redirect("/users/$slug/profile")->with("status", [
                    "code" => 403,
                    "message" => "You are not $slug\"s friend",
                ]);
            }

            $found->cancel();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud cancelada",
            ]);
        }

        /**
         * * Delete the Friendship.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function delete (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::bySlug($slug)->first();

            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }

            if (!$found) {
                return redirect("/users/$slug/profile")->with("status", [
                    "code" => 403,
                    "message" => "You are not $slug\"s friend",
                ]);
            }

            $chat = Chat::byUsers($found->id_user_from, $found->id_user_to)->first();

            $chat->delete();

            $found->delete();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Amigo eliminado",
            ]);
        }

        /**
         * * Request a Friendship.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function request (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::bySlug($slug)->first();

            $found = false;
            foreach ($user->friends as $friend) {
                if ($friend->id_user_from === Auth::user()->id_user || $friend->id_user_to === Auth::user()->id_user) {
                    $found = $friend;
                    break;
                }
            }

            if ($found) {
                return redirect("/users/$slug/profile")->with("status", [
                    "code" => 403,
                    "message" => "You are $slug\"s friend",
                ]);
            }

            $friend = Friend::create([
                "id_user_from" => Auth::user()->id_user,
                "id_user_to" => $user->id_user,
                "accepted" => 0,
            ]);

            $friend->notify();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud enviada",
            ]);
        }
    }