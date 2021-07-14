<?php
    namespace App\Http\Controllers;

    use App\Models\Lesson;
    use Auth;
    use Illuminate\Http\Request;

    class ReviewController extends Controller {
        public function create (Request $request, string $id_lesson) {
            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            $lesson = Lesson::find($id_lesson);
            
            dd($lesson);

            return view('review.details', [
                'error' => $error,
                'lesson' => $lesson,
                'review' => $review,
                'validation' => []
            ]);
        }
    }