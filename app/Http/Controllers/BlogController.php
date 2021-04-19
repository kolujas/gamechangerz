<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as AuthModel;
    use App\Models\Post;
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
        public function list () {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                
            }
            return view('blog.list', [
                'posts' => Post::with('user')->limit(10)->orderBy('updated_at', 'DESC')->get(),
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
                ]],
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string $slug Post slug.
         * @return [type]
         */
        public function details ($slug) {
            $error = null;
            if($request->session()->has('error')){
                $error = (object) $request->session()->pull('error');
                
            }
            return view('blog.details', [
                'post' => Post::where('slug', '=', $slug)->with('user')->get()[0],
                'validation' => [
                    'login' => (object)[
                        'rules' => AuthModel::$validation['login']['rules'],
                        'messages' => AuthModel::$validation['login']['messages']['es'],
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