<?php
    namespace App\Http\Controllers;

    use App\Models\Assigment;
    use App\Models\Auth as AuthModel;
    use App\Models\Post;
    use App\Models\Presentation;
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
         * @return [type]
         */
        public function list (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $posts = Post::fromAdmin();
            foreach ($posts as $post) {
                $post->and(['date']);
            }

            return view('blog.list', [
                'posts' => $posts,
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'assigment' => (object)[
                        'rules' => Assigment::$validation['make']['rules'],
                        'messages' => Assigment::$validation['make']['messages']['es'],
                ], 'presentation' => (object)[
                        'rules' => Presentation::$validation['make']['rules'],
                        'messages' => Presentation::$validation['make']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string $id_user Post slug.
         * @param string $slug Post slug.
         * @return [type]
         */
        public function details (Request $request, $id_user = false, $slug = false) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $post = false;
            if ($slug) {
                $post = Post::findBySlug($slug);
                $post->and(['user', 'date']);
            }

            return view('blog.details', [
                'post' => $post,
                'error' => $error,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'assigment' => (object)[
                        'rules' => Assigment::$validation['make']['rules'],
                        'messages' => Assigment::$validation['make']['messages']['es'],
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
                ]],
            ]);
        }

        /**
         * * Execute the Post correct function.
         * @param Request $request
         * @param bool $id_user Post User ID
         * @param bool $slug Post slug
         * @param string $action Function name
         * @return [type]
         */
        public function do (Request $request, $id_user = false, $slug = false, $action = 'update') {
            $input = (object) $request->all();

            if ($slug) {
                switch ($action) {
                    case 'delete':
                        return $this->doDelete($request, $id_user, $slug);
                        break;
                    case 'update':
                        return $this->doUpdate($request, $id_user, $slug);
                        break;
                    default:
                        # code...
                        break;
                }
            }
            if (!$slug) {
                return $this->doCreate($request);
            }
        }

        /**
         * * Create a new Post.
         * @param Request $request
         * @return [type]
         */
        public function doCreate (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Post::$validation['create']['rules'], Post::$validation['create']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
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

            return redirect("/blog/$user->id_user/$post->slug")->with('status', [
                'code' => 200,
                'message' => "Artículo creado exitosamente.",
            ]);
        }

        /**
         * * Update a Post.
         * @param Request $request
         * @param string $id_user Post User ID
         * @param string $slug Post slug
         * @return [type]
         */
        public function doUpdate (Request $request, string $id_user, string $slug) {
            $input = (object) $request->all();
            $post = Post::findBySlug($slug);

            $validator = Validator::make($request->all(), Post::$validation['update']['rules'], Post::$validation['update']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $user = Auth::user();

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

            return redirect("/blog/$user->id_user/$post->slug")->with('status', [
                'code' => 200,
                'message' => "Artículo actualizado exitosamente.",
            ]);
        }

        /**
         * * Delete a Post.
         * @param Request $request
         * @param string $id_user Post User ID
         * @param string $slug Post slug
         * @return [type]
         */
        public function doDelete (Request $request, string $id_user, string $slug) {
            $post = Post::findBySlug($slug);

            $validator = Validator::make($request->all(), Post::$validation['delete']['rules'], Post::$validation['delete']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            $user = Auth::user();

            Storage::delete($post->image);
                
            $post->delete();

            if ($user->id_role === 1) {
                return redirect("/users/$user->slug/profile")->with('status', [
                    'code' => 200,
                    'message' => "Artículo borrado exitosamente.",
                ]);
            }
            
            return redirect("/blog")->with('status', [
                'code' => 200,
                'message' => "Artículo borrado exitosamente.",
            ]);
        }
    }