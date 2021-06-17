<?php
    namespace App\Http\Controllers;

    use App\Models\Assigment;
    use App\Models\Auth as AuthModel;
    use App\Models\Post;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Intervention\Image\ImageManagerStatic as Image;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Validator;
    use Storage;

    class BlogController extends Controller {
        public function showCreate (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            return view('blog.create', [
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
                ], 'post' => (object)[
                        'rules' => Post::$validation['add']['rules'],
                        'messages' => Post::$validation['add']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the Blog list page.
         * @return [type]
         */
        public function list (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            $posts = Post::join('users', 'posts.id_user', '=', 'users.id_user')->where('id_role', '=', 2)->select('posts.title', 'posts.description', 'posts.image', 'posts.slug', 'posts.id_user')->orderBy('posts.updated_at', 'desc')->limit(10)->get();
            foreach ($posts as $post) {
                $post->date = $this->dateToHuman($post->updated_at);
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
                ]],
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string $slug Post slug.
         * @return [type]
         */
        public function details (Request $request, $id_user, $slug) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
                // dd($error)
            }
            $post = Post::where('slug', '=', $slug)->with('user')->get()[0];
            $post->date = $this->justMonth($post->updated_at);
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
                ]],
            ]);
        }

        public function doCreate (Request $request) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Post::$validation['create']['rules'], Post::$validation['create']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            if ($request->hasFile('image')) {
                switch ($request->image->extension()) {
                    default:
                        $file = Image::make($request->file('image'))
                                ->resize(500, 400, function ($constrait) {
                                    $constrait->aspectRatio();
                                    $constrait->upsize();
                                });
                        break;
                }
            }

            $input->id_user = Auth::user()->id_user;
            $filepath = $request->file('image')->hashName("posts/$input->id_user");
            Storage::put($filepath, (string) $file->encode());
            $input->image = $filepath;
            $input->slug = SlugService::createSlug(Post::class, 'slug', $input->title);
            $post = Post::create((array) $input);

            return redirect("/blog/$user->id_user/$post->slug");
        }

        public function doUpdate (Request $request, $slug) {
            $post = Post::where('slug', '=', $slug)->get();
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Post::$validation['update']['rules'], Post::$validation['update']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            if ($request->hasFile('image')) {
                $currentImage = $post->image;
                switch ($request->image->extension()) {
                    default:
                        $file = Image::make($request->file('image'))
                                ->resize(500, 400, function ($constrait) {
                                    $constrait->aspectRatio();
                                    $constrait->upsize();
                                });
                        break;
                }
                $filepath = $request->file('image')->hashName("posts/$input->id_user");
                Storage::put($filepath, (string) $file->encode());
                $input->image = $filepath;
                
                if(isset($currentImage) && !empty($currentImage)){
                    Storage::delete($currentImage);
                }
            } else {
                $input->image = $post->image;
            }

            $input->id_user = Auth::user()->id_user;
            $input->slug = SlugService::createSlug(Post::class, 'slug', $input->title);
            $post->update((array) $input);

            return redirect("/blog/$user->id_user/$post->slug");
        }
    }