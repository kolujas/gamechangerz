<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class GoogleController extends Controller {
        /**
         * * Connect the User with Google.
         * @param string $token
         * @return Google
         */
        public function connect ($token) {
            $this->client->setAccessToken($token);
            return $this;
        }

        /**
         * * Save the User Google account access token.
         * @param Request $request
         * @param Google $google
         * @return [type]
         */
        public function store (Request $request, Google $google){
            if (! $request->has('code')) {
                return redirect($google->createAuthUrl());
            }
        
            // * Use the given code to authenticate the user.
            $google->authenticate($request->get('code'));
        
            $user = Auth::user();
            $user->update([
                'access_token' => $google->getAccessToken(),
            ]);
            
            return redirect("/users/$user->slug/profile");
        }
    }