<?php
    namespace App\Http\Controllers\Panel;

    use App\Http\Controllers\Controller;
    use App\Models\Assignment;
    use App\Models\Chat;
    use App\Models\Lesson;
    use App\Models\User;
    use Carbon\Carbon;
    use Cviebrock\EloquentSluggable\Services\SlugService;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class LessonController extends Controller {
        /**
         * * Call the correct function.
         * @param  \Illuminate\Http\Request  $request
         * @param string $section
         * @param string $action
         * @return \Illuminate\Http\Response
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
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doCreate (Request $request) {
            $input = (object) $request->all();

            $type = isset($input->id_type) ? ($input->id_type == 1 ? "1on1" : ($input->id_type == 2 ? "seguimiento-online" : "packs")) : "seguimiento-online";

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["create"][$type]["rules"], Lesson::$validation["panel"]["create"][$type]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $days = collect();
            for ($i=1; $i <= count($input->dates); $i++) {
                if ($input->id_type == 2) {
                    $days->push([
                        "date" => $input->dates[$i],
                    ]);
                    continue;
                }
                $days->push([
                    "date" => $input->dates[$i],
                    "hour" => collect([
                        "id_hour" => $input->hours[$i],
                    ]),
                ]);
            }

            $user = User::find($input->id_user_from);
            $user->and(["lessons"]);
            $length = 0;
            foreach ($user->lessons as $lesson) {
                if ($lesson->id_type == $input->id_type && $input->id_user_to == $lesson->id_user_to) {
                    $lesson->and(["started_at"]);
                    foreach ($days as $newDay) {
                        foreach ($lesson->days as $day) {
                            if ($day->date === $newDay["date"]) {
                                $length += 1;
                                if ($input->id_type == 1 || $input->id_type == 2 || ($input->id_type == 3 && $length === 4)) {
                                    return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                                        "code" => 500,
                                        "message" => "Ya existe una reserva con estas características.",
                                    ]);
                                }
                            }
                        }
                        if ($input->id_type == 2 && Carbon::parse($newDay["date"]) > $lesson->started_at && Carbon::parse($newDay["date"]) < $lesson->ended_at) {
                            return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                                "code" => 500,
                                "message" => "Ya existe una reserva con estas características.",
                            ]);
                        }
                    }
                }
            }

            $input->days = $days->toJson();
            $input->id_type = intval($input->id_type);

            $input->price = json_encode([
                "value" => $input->price,
                "fee" => $input->fee,
                "credits" => $input->credits,
            ]);

            if (isset($input->created_at)) {
                unset($input->created_at);
            }

            $lesson = Lesson::create((array) $input);

            return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                "code" => 200,
                "message" => "Reserva creada exitosamente.",
            ]);
        }

        /**
         * * Deletes a Lesson.
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doDelete (Request $request) {
            $input = (object) $request->all();

            $lesson = Lesson::find($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["delete"]["rules"], Lesson::$validation["panel"]["delete"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $users = collect();

            $lesson->and(["reviews"]);
            if (count($lesson->reviews)) {
                foreach ($lesson->reviews as $review) {
                    $review->and(["users"]);
                    foreach ($review->users as $user) {
                        $users->push($user);
                    }
                    // $review->delete();
                }
            }

            foreach ($users as $user) {
                User::requilify($user->id_user);
            }

            $chat = Chat::findByUsers($lesson->id_user_from, $lesson->id_user_to);
            if ($chat) {
                $chat->delete();
            }

            $assignments = Assignment::allFromLesson($lesson->id_lesson);
            if (count($assignments)) {
                foreach ($assignments as $assignment) {
                    $assignment->and(["presentation"]);
                    if ($assignment->presentation) {
                        $assignment->presentation->delete();
                    }
                    $assignment->delete();
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
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        static public function doUpdate (Request $request) {
            $input = (object) $request->all();

            $type = isset($input->id_type) ? ($input->id_type == 1 ? "1on1" : ($input->id_type == 2 ? "seguimiento-online" : "packs")) : "seguimiento-online";

            $lesson = Lesson::find($request->route()->parameter("slug"));

            $validator = Validator::make($request->all(), Lesson::$validation["panel"]["create"][$type]["rules"], Lesson::$validation["panel"]["create"][$type]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $days = collect();
            for ($i=1; $i <= count($input->dates); $i++) {
                if ($input->id_type == 2) {
                    $days->push([
                        "date" => $input->dates[$i],
                    ]);
                    continue;
                }
                $days->push([
                    "date" => $input->dates[$i],
                    "hour" => collect([
                        "id_hour" => $input->hours[$i],
                    ]),
                ]);
            }

            $user = User::find($input->id_user_from);
            $user->and(["lessons"]);
            $length = 0;
            foreach ($user->lessons as $oldLesson) {
                if ($oldLesson->id_type == $input->id_type && $oldLesson->id_lesson !== $lesson->id_lesson && $input->id_user_to == $oldLesson->id_user_to) {
                    $oldLesson->and(["started_at"]);
                    foreach ($days as $newDay) {
                        foreach ($oldLesson->days as $day) {
                            if ($day->date === $newDay["date"]) {
                                $length += 1;
                                if ($input->id_type == 1 || $input->id_type == 2 || ($input->id_type == 3 && $length === 4)) {
                                    return redirect("/panel/bookings/$oldLesson->id_lesson")->with("status", [
                                        "code" => 500,
                                        "message" => "Ya existe una reserva con estas características.",
                                    ]);
                                }
                            }
                        }
                        if ($input->id_type == 2 && Carbon::parse($newDay["date"]) > $oldLesson->started_at && Carbon::parse($newDay["date"]) < $oldLesson->ended_at) {
                            return redirect("/panel/bookings/$oldLesson->id_lesson")->with("status", [
                                "code" => 500,
                                "message" => "Ya existe una reserva con estas características.",
                            ]);
                        }
                    }
                }
            }

            $input->days = $days->toJson();
            $input->id_type = intval($input->id_type);

            $input->price = json_encode([
                "value" => $input->price,
                "fee" => $input->fee,
                "credits" => $input->credits,
            ]);
            
            $lesson->update((array) $input);

            return redirect("/panel/bookings/$lesson->id_lesson")->with("status", [
                "code" => 200,
                "message" => "Reserva actualizada exitosamente.",
            ]);
        }
    }