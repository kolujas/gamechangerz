<?php
    namespace App\Http\Controllers;
    use Illuminate\Http\Request;

    class PanelController extends Controller {
        /**
         * * Control the index page.
         * @return [type]
         */
        public function teachers (Request $request) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }
            return view('panel.teachers.list', [
                'error' => $error,
                'validation' => []
            ]);
        }
    }