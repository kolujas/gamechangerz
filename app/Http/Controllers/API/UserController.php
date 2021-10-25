<?php
    namespace App\Http\Controllers\API;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Http\Request;

    class UserController extends Controller {
        /**
         * * Check if the User has a Lesson with a specific time.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug User slug.
         * @return JSON
         */
        public function checkLesson (Request $request, string $slug) {
            $input = (object) $request->all();
            $user = User::bySlug($slug)->first();
            $user->and(["lessons"]);

            $found = false;
            foreach ($user->lessons as $lesson) {
                $lesson->and(["days"]);
                foreach ($lesson->days as $day) {
                    $day = (object) $day;
                    if ($day->date === $input->date) {
                        foreach ($day->hours as $hour) {
                            if ($hour->id_hour === $input->id_hour) {
                                $found = true;
                                break;
                            }
                        }
                    }
                }
            }

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "found" => $found,
                ],
            ]);
        }
        
        /**
         * * Get the User Lessons.
         * @param  \Illuminate\Http\Request  $request
         * @param string $slug User slug.
         * @return JSON
         */
        public function lessons (Request $request, string $slug) {
            $user = User::bySlug($slug)->first();
            $user->and(["lessons"]);

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "lessons" => $user->lessons,
                ],
            ]);
        }

        /**
         * * Get the Users with id_role = 1.
         * @param  \Illuminate\Http\Request  $request
         * @return JSON
         */
        public function teachers (Request $request) {
            $users = User::teachers()->orderBy('updated_at', 'DESC')->get();

            foreach ($users as $user) {
                $user->and(["games", "files", "prices", "teampro", "languages", "days"]);
            }

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "users" => $users,
                ],
            ]);
        }
        /**
         * * Get the Users with id_role = 0.
         * @param  \Illuminate\Http\Request  $request
         * @return JSON
         */
        public function users (Request $request) {
            $users = User::available()->get();

            foreach ($users as $user) {
                $user->and(["lessons", "games", "files", "hours", "achievements"]);
            }

            return response()->json([
                "code" => 200,
                "message" => "Success",
                "data" => [
                    "users" => $users,
                ],
            ]);
        }

        function credits (Request $request) {
            $input = (object) $request->all();

            if (!intval($request->user()->credits) || intval($request->user()->credits) < intval($input->credits)) {
                return response()->json([
                    "code" => 403,
                    "message" => "No dispones de los créditos seleccionados.",
                ]);
            }

            return response()->json([
                "code" => 200,
                "message" => "Success",
            ]);
        }
    }