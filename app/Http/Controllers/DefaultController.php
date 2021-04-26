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
                // dd($error);
            }
            return view('web.home', [
                'games' => Game::getOptions(),
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the coming soon page.
         * @return [type]
         */
        public function comingSoon (Request $request) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            return view('web.coming_soon', [
                // ? Data
            ]);
        }

        /**
         * * Control the game page.
         * @param string $slug Game slug.
         * @return [type]
         */
        public function game (Request $request, $slug) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            $game = Game::search($slug);
            $game->abilities = Ability::parse($game->abilities);
            $usersFound = User::where('id_role', '=', 1)->with('reviews')->get();
            $users = collect([]);
            foreach ($usersFound as $user) {
                $user->abilities();
                $user->files();
                $user->games();
                $user->idioms();
                $user->teampro();
                $user->prices();
                foreach ($user->games as $game) {
                    if ($game->id_game) {
                        $users->push($user);
                    }
                }
                $user->game_abilities = collect([]);
                foreach ($user->games as $game) {
                    $abilities = Ability::parse($game->abilities);
                    foreach ($abilities as $ability) {
                        $user->game_abilities->push($ability);
                    }
                }
            }
            $posts = Post::join('users', 'posts.id_user', '=', 'users.id_user')->where('id_role', '=', 2)->select('posts.title', 'posts.description', 'posts.image', 'posts.slug', 'posts.id_user')->orderBy('posts.updated_at', 'desc')->get();
            foreach ($posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
            }
            return view('web.game', [
                'game' => $game,
                'posts' => $posts,
                'users' => $users,
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the home page.
         * @return [type]
         */
        public function home (Request $request) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            return view('web.home', [
                'games' => Game::getOptions(),
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the privacy politics page.
         * @return [type]
         */
        public function privacyPolitics (Request $request) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            return view('web.privacy_politics', [
                // ? Data
            ]);
        }

        /**
         * * Control the terms &contidions page.
         * @return [type]
         */
        public function termsAndContidions (Request $request) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            return view('web.terms_&_contidions', [
                // ? Data
            ]);
        }
    }