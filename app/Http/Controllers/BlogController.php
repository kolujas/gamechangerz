<?php
    namespace App\Http\Controllers;

    use App\Models\Post;
    use Illuminate\Http\Request;

    class BlogController extends Controller {
        /**
         * * Control the Blog list page.
         * @return [type]
         */
        public function list () {
            return view('blog.list', [
                'posts' => Post::with('user')->limit(10)->orderBy('updated_at', 'DESC')->get(),
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string $slug Post slug.
         * @return [type]
         */
        public function details ($slug) {
            return view('blog.details', [
                'post' => Post::where('slug', '=', $slug)->with('user')->get()[0],
            ]);
        }
    }