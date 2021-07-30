<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Assigment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class LessonController extends Controller {
        /**
         * * Call the correct function.
         * @param Request $request
         * @param string $section
         * @param string $action
         * @return [type]
         */
        static public function call (Request $request, string $section, string $action) {
            switch ($action) {
                case "create":
                    return LessonController::doCreate($request);
                case "delete":
                    return LessonController::doDelete($request);
                case "update":
                    return LessonController::doUpdate($request);
                default:
                    dd("Call to an undefined action \"$action\"");
            }
        }

        /**
         * * Creates a Lesson.
         * @param Request $request
         * @return [type]
         */
        static public function doCreate (Request $request) {
            $input = (object) $request->all();

            $type = isset($input->id_type) ? ($input->id_type === 1 ? "online" : ($input->id_type === 2 ? "offline" : "packs")) : "offline";

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["create"][$type]["rules"], Lesson::$validation["panel"]["create"][$type]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $days = collect();
            for ($i=1; $i <= count($input->dates); $i++) {
                $days->push([
                    "date" => $input->dates[$i],
                    "hour" => collect([
                        "id_hour" => $input->hours[$i],
                    ]),
                ]);
            }

            $input->days = $days->toJson();

            $input->id_game = 1;

            $lesson = Lesson::create((array) $input);

            return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                "code" => 200,
                "message" => "Reserva creada exitosamente.",
            ]);
        }

        /**
         * * Deletes a Lesson.
         * @param Request $request
         * @return [type]
         */
        static public function doDelete (Request $request) {
            $input = (object) $request->all();

            $lesson = Lesson::find($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["delete"]["rules"], Lesson::$validation["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $chat = Chat::findByUsers($lesson->id_user_from, $lesson->id_user_to);
            if ($chat) {
                $chat->delete();
            }

            $assigments = Assigment::allFromLesson($lesson->id_lesson);
            if (count($assigments)) {
                foreach ($assigments as $assigment) {
                    $assigment->and(["presentation"]);
                    if ($assigment->presentation) {
                        $assigment->presentation->delete();
                    }
                    $assigment->delete();
                }
            }

            $lesson->delete();

            return redirect("/panel/bookings")->with("status", [
                "code" => 200,
                "message" => "Reserva eliminada exitosamente.",
            ]);
        }

        /**
         * * Updates a Lesson.
         * @param Request $request
         * @return [type]
         */
        static public function doUpdate (Request $request) {
            $input = (object) $request->all();

            $type = isset($input->id_type) ? ($input->id_type === 1 ? "online" : ($input->id_type === 2 ? "offline" : "packs")) : "offline";

            $lesson = Lesson::find($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["create"][$type]["rules"], Lesson::$validation["panel"]["create"][$type]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $days = collect();
            for ($i=1; $i <= count($input->dates); $i++) {
                $days->push([
                    "date" => $input->dates[$i],
                    "hour" => collect([
                        "id_hour" => $input->hours[$i],
                    ]),
                ]);
            }

            $input->days = $days->toJson();

            $input->id_game = 1;
            
            $lesson->update((array) $input);

            return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                "code" => 200,
                "message" => "Reserva actualizada exitosamente.",
            ]);
        }
    }