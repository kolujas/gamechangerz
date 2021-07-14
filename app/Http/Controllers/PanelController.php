<?php
    namespace App\Http\Controllers;

    use App\Models\Coupon;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\User;
    use Illuminate\Http\Request;

    class PanelController extends Controller {
        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function lessons (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $lessons = Lesson::all();
            
            return view('panel.lesson.list', [
                'error' => $error,
                'validation' => [],
                'lessons' => $lessons
            ]);
        }

        /**
         * * Control the posts list panel page.
         * @return [type]
         */
        public function blog (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $posts = Post::all();
            
            return view('panel.blog.list', [
                'error' => $error,
                'validation' => [],
                'posts' => $posts
            ]);
        }

        /**
         * * Control the Coupons list panel page.
         * @return [type]
         */
        public function coupons (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $coupons = Coupons::all();

            return view('panel.coupon.list', [
                'error' => $error,
                'validation' => [],
                'coupons' => $coupons
            ]);
        }

        /**
         * * Control the coupon details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function coupon (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $coupon = Coupon::findBySlug($slug);

            return view('panel.coupon.details', [
                'error' => $error,
                'validation' => [],
                'coupons' => $coupons
            ]);
        }

        /**
         * * Control the platform details panel page.
         * @return [type]
         */
        public function platform (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            return view('panel.platform.list', [
                'error' => $error,
                'validation' => []
            ]);
        }

        /**
         * * Control the post details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function post (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $post = Post::findBySlug($slug);

            return view('panel.blog.details', [
                'error' => $error,
                'validation' => [],
                'post' => $post
            ]);
        }

        /**
         * * Control the teachers list panel page.
         * @return [type]
         */
        public function teachers (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $users = User::allTeachers();

            return view('panel.teachers.list', [
                'error' => $error,
                'validation' => [],
                'users' => $users
            ]);
        }

        /**
         * * Control the teacher details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function teacher (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $user = User::findBySlug($slug);

            return view('panel.teachers.details', [
                'error' => $error,
                'validation' => [],
                'user' => $user
            ]);
        }

        /**
         * * Control the users list panel page.
         * @return [type]
         */
        public function users (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $users = User::allUsers();

            return view('panel.users.list', [
                'error' => $error,
                'validation' => [],
                'users' => $users
            ]);
        }

        /**
         * * Control the user details panel page.
         * @param string|false [$slug=false]
         * @return [type]
         */
        public function user (Request $request, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $user = User::findBySlug($slug);

            return view('panel.users.details', [
                'error' => $error,
                'validation' => [],
                'user' => $user
            ]);
        }

        public function teacher (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('panel.teachers.details', [
                'error' => $error,
                'validation' => [],
                'teacher' => false
            ]);
        }
    }