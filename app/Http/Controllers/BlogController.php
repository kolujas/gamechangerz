<?php
    namespace App\Http\Controllers;

    use Illuminate\Http\Request;

    class BlogController extends Controller {
        /**
         * * Control the Blog list page.
         * @return [type]
         */
        public function list(){
            return view('blog.list', [
                // ? Data
            ]);
        }

        /**
         * * Control the Blog details page.
         * @param string $slug Post slug.
         * @return [type]
         */
        public function details($slug){
            return view('blog.details', [
                // ? Data
            ]);
        }
    }