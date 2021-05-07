<?php
    namespace App\Http\Controllers;

    use App\Models\Ability;
    use App\Models\Auth as AuthModel;
    use App\Models\Game;
    use App\Models\Post;
    use App\Models\User;
    use Illuminate\Http\Request;

    class DefaultController extends Controller {
        /**
         * * Control the index page.
         * @return [type]
         */
        public function index (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.home', [
                'games' => Game::all(),
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                        'rules' => AuthModel::$validation['signin']['rules'],
                        'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return [type]
         */
        public function comingSoon (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.coming_soon', [
                'error' => $error,
            ]);
        }

        /**
         * * Control the game page.
         * @param string $slug Game slug.
         * @return [type]
         */
        public function game (Request $request, $slug) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            if ($error === null) {
                try {
                    $game = Game::find($slug);
                    $game->and(['abilities', 'users']);
                    foreach ($game->users as $user) {
                        $user->and(['abilities', 'games', 'languages', 'teampro', 'prices', 'files']);
                    }
                } catch (\Throwable $th) {
                    $error = $th;
                }
            }
            $posts = Post::join('users', 'posts.id_user', '=', 'users.id_user')->where('id_role', '=', 2)->select('posts.title', 'posts.description', 'posts.image', 'posts.slug', 'posts.id_user')->orderBy('posts.updated_at', 'desc')->limit(10)->get();
            foreach ($posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
            }
            return view('web.game', [
                'game' => $game,
                'posts' => $posts,
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                        'rules' => AuthModel::$validation['signin']['rules'],
                        'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the home page.
         * @return [type]
         */
        public function home (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.home', [
                'games' => Game::all(),
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                    'rules' => AuthModel::$validation['signin']['rules'],
                    'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the panel page.
         * @return [type]
         */
        public function panel (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.panel', [
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                    'rules' => AuthModel::$validation['signin']['rules'],
                    'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return [type]
         */
        public function privacyPolitics (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.privacy_politics', [
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                    'rules' => AuthModel::$validation['signin']['rules'],
                    'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the terms &contidions page.
         * @return [type]
         */
        public function termsAndContidions (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('web.terms_&_contidions', [
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ], 'signin' => (object)[
                    'rules' => AuthModel::$validation['signin']['rules'],
                    'messages' => AuthModel::$validation['signin']['messages']['es'],
                ]],
            ]);
        }
    }