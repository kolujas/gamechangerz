<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as AuthModel;
    use App\Models\Assigment;
    use App\Models\Event;
    use App\Models\Hour;
    use App\Models\Lesson;
    use App\Models\MercadoPago;
    use App\Models\Presentation;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class CheckoutController extends Controller {
        /**
         * * Update a Lesson & redirects to MercadoPago.
         * @param Request $request
         * @param string $id_lesson
         * @return [type]
         */
        public function complete (Request $request, string $id_lesson) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Lesson::$validation["checkout"]["online"]["rules"], Lesson::$validation["checkout"]["online"]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lesson = Lesson::find($id_lesson);
            $lesson->update((array) $input);
            $lesson->and(["type", "users"]);

            dd($input);

            if (config("app.env") === "production") {
                // * Create the GoogleCalendar event.
                // if ($lesson->type->id_type === 1 || $lesson->type->id_type === 3) {
                //     foreach ($input->dates as $key => $date) {
                //         $data = (object) [];
                //         $data->users = $lesson->users;
                //         $data->name = ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $data->users->from->username;
                //         $data->description = "Clase reservada desde el sitio web GameChangerZ";
                //         $data->startDateTime = new Carbon($date."T".Hour::option($input->hours[$key])->from);
                //         $data->endDateTime = new Carbon($date."T".Hour::option($input->hours[$key])->to);
        
                //         Event::Create($data);
                //     }
                // }
            }

            switch ($input->id_method) {
                case 1:
                    $data = (object) [
                        "id" => $lesson->id_lesson,
                        "title" => ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $lesson->users->from->username,
                        "price" => $lesson->users->from->prices[$lesson->type->id_type - 1]->price,
                    ];

                    $user = $lesson->users->from;
                    $user->and(["credentials"]);

                    $MP = new MercadoPago($user->credentials->mercadopago->access_token);
                    $MP->items([$data]);
                    $MP->preference($data);
                    $url = $MP->preference->init_point;
                    if (config("app.env") !== "production") {
                        $lesson->update([
                            "id_status" => 3,
                        ]);
                    }
                    break;
                case 2:
                    $lesson->update([
                        "id_status" => 3,
                    ]);
                    $url = route("checkout.status", [
                        "id_lesson" => $lesson->id_lesson,
                        "id_status" => 2,
                    ]);
                    break;
            }

            return redirect($url);
        }

        /**
         * * Check the Notification
         * @param Request $request
         * @param int $id_lesson
         * @param string $type Notification type.
         * @return [type]
         */
        public function notification (Request $request, int $id_lesson, string $type) {
            // * Check the Notification type
            switch ($type) {
                case "mercadopago":
                    // * Creates the MercadoPago
                    // TODO: Get access_token
                    $MP = new MercadoPago(/* ACCESS_TOKEN*/ );
        
                    // * Check the request topic
                    switch ($request->route("topic")) {
                        case "payment":
                            // * Set the MercadoPago Payment
                            $MP->payment($request->route("id"));
                            
                            // * Check the Payment status
                            if ($MP->payment->status === "approved") {
                                // * Get the external Preference & updates
                                $lesson = Lesson::find($MP->payment->external_preference);

                                $lesson->update([
                                    "id_status" => 3,
                                ]);
                            }
                            break;
                    }
                    break;
                case "paypal":
                    // TODO: PayPal Notification
                    break;
            }
        }

        /**
         * * Show the checkout page.
         * @param string $slug User slug.
         * @param string $type User type of Lesson.
         * @return [type]
         */
        public function show (Request $request, string $slug, string $typeSearched) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }
            
            $user = User::findBySlug($slug);
            $user->and(["prices", "days", "lessons"]);
            foreach ($user->prices as $price) {
                if ($price->slug === $typeSearched) {
                    $type = $price;
                }
            }

            $found = false;
            foreach (Lesson::allCreated() as $lesson) {
                if ($lesson->id_user_to === Auth::user()->id_user && $lesson->id_user_from === $user->id_user) {
                    $found = true;
                    $lesson->update([
                        "days" => "[]",
                    ]);
                    break;
                } else if (Carbon::parse($lesson->updated_at)->diffInMinutes(Carbon::now()) === 5) {
                    $lesson->delete();
                }
            }

            // TODO: Remove id_method
            if (!$found) {
                $lesson = Lesson::create([
                    "id_user_from" => $user->id_user,
                    "id_user_to" => Auth::user()->id_user,
                    "id_type" => $type->id_type,
                    "id_method" => 1,
                    "id_status" => 1,
                ]);
            }

            return view("user.checkout", [
                "lesson" => $lesson,
                "user" => $user,
                "type" => $type,
                "error" => $error,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "advanced" => (object)[
                        "rules" => User::$validation["advanced"]["rules"],
                        "messages" => User::$validation["advanced"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ], "checkout" => (object)[
                        "rules" => Lesson::$validation["checkout"][$type->slug]["rules"],
                        "messages" => Lesson::$validation["checkout"][$type->slug]["messages"]["es"],
                ]],
            ]);
        }


        /**
         * * Show the Lesson status.
         * @param Request $request
         * @param int $id_lesson
         * @param int $id_status
         * @return [type]
         */
        public function status (Request $request, int $id_lesson, int $id_status) {
            $error = null;
            if ($request->session()->has("error")) {
                $error = (object) $request->session()->pull("error");
            }

            $lesson = Lesson::find($id_lesson);
            $lesson->and(["days"]);

            return view("lesson.status", [
                "error" => $error,
                "lesson" => $lesson,
                "id_status" => $id_status,
                "validation" => [
                    "login" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["login"]["rules"], "login_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["login"]["messages"]["es"], "login_"),
                ], "signin" => (object)[
                        "rules" => $this->encodeInput(AuthModel::$validation["signin"]["rules"], "signin_"),
                        "messages" => $this->encodeInput(AuthModel::$validation["signin"]["messages"]["es"], "signin_"),
                ], "assigment" => (object)[
                        "rules" => Assigment::$validation["make"]["rules"],
                        "messages" => Assigment::$validation["make"]["messages"]["es"],
                ], "presentation" => (object)[
                        "rules" => Presentation::$validation["make"]["rules"],
                        "messages" => Presentation::$validation["make"]["messages"]["es"],
                ]],
            ]);
        }
    }