<?php
    namespace App\Http\Controllers;

    use App\Models\Friend;
    use App\Models\Mail;
    use App\Models\User;
    use Auth;
    use Illuminate\Http\Request;

    class FriendshipController extends Controller {
        /**
         * * Executes the Friendship function.
         * @param Request $request
         * @param string $slug
         * @param string $action
         * @return [type]
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
         * @param Request $request
         * @return [type]
         */
        public function accept (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::findBySlug($slug);
            $user->and(["friends"]);

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

            $found->update([
                "accepted" => 1,
            ]);

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud aceptada",
            ]);
        }

        /**
         * * Cancel the Friendship.
         * @param Request $request
         * @return [type]
         */
        public function cancel (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::findBySlug($slug);
            $user->and(["friends"]);
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

            $found->delete();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud cancelada",
            ]);
        }

        /**
         * * Delete the Friendship.
         * @param Request $request
         * @return [type]
         */
        public function delete (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::findBySlug($slug);
            $user->and(["friends"]);

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

            $chat = Chat::findByUsers($found->id_user_from, $found->id_user_to);

            $chat->delete();

            $found->delete();

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Amigo eliminado",
            ]);
        }

        /**
         * * Request a Friendship.
         * @param Request $request
         * @return [type]
         */
        public function request (Request $request) {
            $slug = $request->route()->parameter("slug");
            $user = User::findBySlug($slug);
            $user->and(["friends"]);

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

            $from = User::find($request->user()->id_user);

            new Mail([ "id_mail" => 6, ], [
                "email_to" => $user->email,
                "name" => $from->name,
                "slug" => $from->slug,
                "username" => $from->username,
            ]);

            return redirect("/users/$slug/profile")->with("status", [
                "code" => 200,
                "message" => "Solicitud enviada",
            ]);
        }
    }