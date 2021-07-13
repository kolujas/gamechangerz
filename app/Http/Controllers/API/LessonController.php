<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\Lesson;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class LessonController extends Controller {
        /**
         * * Updates a Lesson.
         * @param Request $request
         * @param string $id_lesson
         * @return JSON
         */
        public function update (Request $request, string $id_lesson) {
            $input = (object) $request->all();

            $validator = Validator::make((array) $input, Lesson::$validation['update']['rules'], Lesson::$validation['update']['messages']['es']);
            if ($validator->fails()) {
                return response()->json([
                    'code' => 401,
                    'message' => 'Validation error',
                    'data' => [
                        'errors' => $validator->errors()->messages(),
                    ],
                ]);
            }

            $input->hours = explode(',', $input->hours);
            $input->dates = explode(',', $input->dates);
            $lesson = Lesson::find($id_lesson);
            
            $days = collect();
            for ($i=0; $i < count($input->dates); $i++) {
                foreach (Lesson::allFromTeacher($lesson->id_user_from) as $previousLesson) {
                    $previousLesson->and(['days']);
                    if ($previousLesson->id_lesson !== intval($id_lesson)) {
                        foreach ($previousLesson->days as $day) {
                            $day = (object) $day;
                            if ($day->date === $input->dates[$i]) {
                                foreach ($day->hours as $hour) {
                                    if ($hour->id_hour === intval($input->hours[$i])) {
                                        $date = $input->dates[$i];
                                        $hours = $hour->from . " - " . $hour->to;
                                        return response()->json([
                                            'code' => 500,
                                            'message' => "La fecha $date entre las $hours ya fue tomada.",
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
                $days->push([
                    'date' => $input->dates[$i],
                    'hour' => collect([
                        'id_hour' => $input->hours[$i],
                    ]),
                ]);
            }

            $lesson->update([
                'days' => json_encode($days),
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'Success',
            ]);
        }
    }