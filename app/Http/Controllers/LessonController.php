<?php
    namespace App\Http\Controllers;

    use App\Models\Lesson;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class LessonController extends Controller {
        public function doCheckout (Request $request, $slug, $type) {
            $input = (object) $request->all();
            $user = User::where('slug', '=', $slug)->get()[0];

            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->slug === $type) {
                    $type = $lesson;
                }
            }
            if ($type->id_type !== 2) {
                $validator = Validator::make($request->all(), Lesson::$validation['checkout']['online']['rules'], Lesson::$validation['checkout']['online']['messages']['es']);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }

            $days = collect([]);
            for ($i=0; $i < count($input->dates); $i++) { 
                $days->push([
                    'date' => $input->dates[$i],
                    'hour' => collect([
                        'id_hour' => $input->hours[$i],
                    ]),
                ]);
            }

            $input->id_user_from = $user->id_user;
            $input->id_user_to = Auth::user()->id_user;
            $input->days = json_encode($days);
            $lesson = Lesson::create((array) $input);
            return redirect()->with('status', [
                'code' => 200,
                'message' => 'Clase reservada.',
            ]);
        }
    }