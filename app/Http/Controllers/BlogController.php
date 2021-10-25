<?php
    namespace App\Http\Controllers;

    use App\Models\Assignment;
    use App\Models\Auth as AuthModel;
    use App\Models\Post;
    use App\Models\Presentation;
    use App\Models\User;
    use Auth;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Intervention\Image\ImageManagerStatic as Image;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Validator;
    use Storage;

    class BlogController extends Controller {
        /**
         * * Control the Blog list page.
         * @return \Illuminate\Http\Response
         */
        public function list (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            $posts = Post::byAdmin()->limit(10)->get();
            foreach ($posts as $post) {
                $post->and(['date', 'user']);
            }

            return view('blog.list', [
                'error' => $error,
                // 'notifications' => $notifications,
                'posts' => $posts,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                    ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                    ], 'assignment' => (object)[
                        'rules' => Assignment::$validation['make']['rules'],
                        'messages' => Assignment::$validation['make']['messages']['es'],
                    ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                    ], 'presentation' => (object)[
                        'rules' => Presentation::$validation['make']['rules'],
                        'messages' => Presentation::$validation['make']['messages']['es'],
                    ],
                ],
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string|false $user Post User slug.
         * @param string|false $post Post slug.
         * @return \Illuminate\Http\Response
         */
        public function details (Request $request, $user = false, $post = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            
            // $notifications = Auth::check() ? Auth::user()->notifications : [];
            // foreach ($notifications as $notification) {
            //     $notification->delete();
            // }

            if ($post) {
                $post = Post::bySlug($post)->first();
                $post->and(['user', 'date']);
            }

            return view('blog.details', [
                'error' => $error,
                // 'notifications' => $notifications,
                'post' => $post,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                    ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                    ], 'assignment' => (object)[
                        'rules' => Assignment::$validation['make']['rules'],
                        'messages' => Assignment::$validation['make']['messages']['es'],
                    ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                    ], 'presentation' => (object)[
                        'rules' => Presentation::$validation['make']['rules'],
                        'messages' => Presentation::$validation['make']['messages']['es'],
                    ], 'create' => (object)[
                        'rules' => Post::$validation['create']['rules'],
                        'messages' => Post::$validation['create']['messages']['es'],
                    ], 'update' => (object)[
                        'rules' => Post::$validation['update']['rules'],
                        'messages' => Post::$validation['update']['messages']['es'],
                    ], 'delete' => (object)[
                        'rules' => Post::$validation['delete']['rules'],
                        'messages' => Post::$validation['delete']['messages']['es'],
                    ],
                ],
            ]);
        }

        /**
         * * Execute the Post correct function.
         * @param  \Illuminate\Http\Request  $request
         * @param string|false $user Post User slug.
         * @param string|false $post Post slug.
         * @param string $action Function name.
         * @return \Illuminate\Http\Response
         */
        public function do (Request $request, $user = false, $post = false, $action = 'update') {
            $input = (object) $request->all();

            if ($post) {
                switch ($action) {
                    case 'delete':
                        return $this->doDelete($request, $user, $post);
                        break;
                    case 'update':
                        return $this->doUpdate($request, $user, $post);
                        break;
                    default:
                        # code...
                        break;
                }
            }
            if (!$post) {
                return $this->doCreate($request, $user);
            }
        }

        /**
         * * Create a new Post.
         * @param  \Illuminate\Http\Request  $request
         * @param string $user Post User slug.
         * @return \Illuminate\Http\Response
         */
        public function doCreate (Request $request, string $user) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Post::$validation['create']['rules'], Post::$validation['create']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = User::bySlug($user)->first();
            $input->id_user = $user->id_user;
            
            $file = Image::make($request->file('image'))
                    ->resize(1349, 395, function ($constrait) {
                        $constrait->aspectRatio();
                        $constrait->upsize();
                    });
            $filepath = $request->file('image')->hashName("posts/$input->id_user");
            Storage::put($filepath, (string) $file->encode());
            $input->image = $filepath;

            $input->slug = SlugService::createSlug(Post::class, 'slug', $input->title);

            $post = Post::create((array) $input);

            return redirect("/blog/$user->slug/$post->slug")->with('status', [
                'code' => 200,
                'message' => "Artículo creado exitosamente.",
            ]);
        }

        /**
         * * Update a Post.
         * @param  \Illuminate\Http\Request  $request
         * @param string $user Post User slug.
         * @param string $post Post slug.
         * @return \Illuminate\Http\Response
         */
        public function doUpdate (Request $request, string $user, string $post) {
            $input = (object) $request->all();
            $post = Post::bySlug($post)->first();

            $validator = Validator::make($request->all(), Post::$validation['update']['rules'], Post::$validation['update']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $user = User::bySlug($user)->first();

            if ($request->hasFile('image')) {
                Storage::delete($post->image);

                $file = Image::make($request->file('image'))
                        ->resize(1349, 395, function ($constrait) {
                            $constrait->aspectRatio();
                            $constrait->upsize();
                        });
                $filepath = $request->file('image')->hashName("posts/$post->id_user");
                Storage::put($filepath, (string) $file->encode());
                $input->image = $filepath;
            }

            if ($post->title !== $input->title) {
                $input->slug = SlugService::createSlug(Post::class, 'slug', $input->title);
            }

            $post->update((array) $input);

            return redirect("/blog/$user->slug/$post->slug")->with('status', [
                'code' => 200,
                'message' => "Artículo actualizado exitosamente.",
            ]);
        }

        /**
         * * Delete a Post.
         * @param  \Illuminate\Http\Request  $request
         * @param string $user Post User slug.
         * @param string $post Post slug.
         * @return \Illuminate\Http\Response
         */
        public function doDelete (Request $request, string $user, string $post) {
            $post = Post::bySlug($post)->first();

            $validator = Validator::make($request->all(), Post::$validation['delete']['rules'], Post::$validation['delete']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $user = User::bySlug($user)->first();

            Storage::delete($post->image);
                
            $post->delete();

            if (Auth::user()->id_role === 1) {
                return redirect("/users/$user->slug/profile")->with('status', [
                    'code' => 200,
                    'message' => "Artículo borrado exitosamente.",
                ]);
            }
            
            return redirect("/panel/blog")->with('status', [
                'code' => 200,
                'message' => "Artículo borrado exitosamente.",
            ]);
        }
    }