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

            if (count($lesson->reviews)) {
                foreach ($lesson->reviews as $review) {
                    if ($review->id_user_from === Auth::user()->id_user) {
                        break;
                    }
                    $review = false;
                }
            }

            return view('review.details', [
                'error' => $error,
                'lesson' => $lesson,
                'review' => $review,
                'validation' => []
            ]);
        }

        public function details (Request $request, string $id_lesson) {
            dd($id_lesson);
        }
    }