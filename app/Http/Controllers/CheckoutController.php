<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as AuthModel;
    use App\Models\Assigment;
    use App\Models\Coupon;
    use App\Models\Event;
    use App\Models\Hour;
    use App\Models\Lesson;
    use App\Models\Mail;
    use App\Models\MercadoPago;
    use App\Models\Method;
    use App\Models\Platform;
    use App\Models\Presentation;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Validator;

    class CheckoutController extends Controller {
        /**
         * * Creates the User MercadoPago access_token.
         * @param Request $request
         * @return [type]
         */
        public function authorization (Request $request) {
            if ($request->code) {
                $response = Http::withHeaders([
                    "accept" => "application/json",
                    "content-type" => "application/x-www-form-urlencoded",
                ])->post("https://api.mercadopago.com/oauth/token", [
                    "client_secret" => config("services.mercadopago.access_token"),
                    "grant_type" => "authorization_code",
                    "code" => $request->code,
                    "redirect_uri" => "https://plannet.space/mercadopago/authorization"
                ]);

                if ($response->ok()) {
                    $user = User::find($request->state);
                    if (!$user) {
                        return response()->json([
                            "code" => 403,
                            "message" => "Error",
                            "data" => [
                                //
                            ],
                        ]);
                    }

                    $methods = collect();
                    $methods->push([
                        "id_method" => 1,
                        "access_token" => $response->json()["access_token"],
                    ]);

                    $user->update([
                        "credentials" => Method::stringify($methods->toArray()),
                        'id_status' => 2,
                    ]);

                    return redirect("/#login");
                }

                return $response->throw();
            }
            
            return response()->json([
                "code" => 403,
                "message" => "Error",
                "data" => [
                    //
                ],
            ]);
        }

        /**
         * * Update a Lesson & redirects to MercadoPago.
         * @param Request $request
         * @param int $id_lesson
         * @param string $type
         * @return [type]
         */
        public function complete (Request $request, int $id_lesson, string $type) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Controller::replaceUnique(Lesson::$validation["checkout"][$type]["rules"], Auth::user()->id_user), Lesson::$validation["checkout"][$type]["messages"]["es"]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lesson = Lesson::find($id_lesson);
            
            $days = collect();
            if (isset($input->dates)) {
                for ($i=0; $i < count($input->dates); $i++) {
                    foreach (Lesson::allFromTeacher($lesson->id_user_from) as $previousLesson) {
                        $previousLesson->and(["days"]);
                        if ($previousLesson->id_lesson !== intval($id_lesson)) {
                            foreach ($previousLesson->days as $day) {
                                $day = (object) $day;
                                if ($day->date === $input->dates[$i]) {
                                    foreach ($day->hours as $hour) {
                                        if ($hour->id_hour === intval($input->hours[$i])) {
                                            $date = $input->dates[$i];
                                            return redirect()->back()->with("status", [
                                                "code" => 500,
                                                "message" => "La fecha $date entre las $hour->from - $hour->to ya fue tomada.",
                                            ]);
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($input->hours[$i]) {
                        $days->push([
                            "date" => $input->dates[$i],
                            "hour" => collect([
                                "id_hour" => intval($input->hours[$i]),
                            ]),
                        ]);
                    }
                    if (!$input->hours[$i]) {
                        $days->push([
                            "date" => $input->dates[$i],
                        ]);
                    }
                }
            }
            if (!isset($input->dates)) {
                $days->push([
                    "date" => Carbon::now()->format("Y-m-d"),
                ]);
            }

            if (isset($input->credits)) {
                $input->credits = intval($input->credits);
            }
            if (!isset($input->credits)) {
                $input->credits = 0;
            }

            $input->days = $days->toJson();

            $input->id_status = 2;

            $lesson->and(["type", "users"]);

            $user = $lesson->users->from;

            $coupon = false;
            if (isset($input->coupon)) {
                $coupon = Coupon::findByName($input->coupon);
            }

            switch ($input->id_method) {
                case 1:
                    $price = intval($lesson->users->from->prices[$lesson->type->id_type - 1]->price);
                    if ($price >= 10) {
                        if ($price - $input->credits >= 10) {
                            $price -= $input->credits;
                        } else {
                            $input->credits = 0;
                        }
                        if ($coupon) {
                            $bool = true;

                            if ($coupon->limit) {
                                $coupon->and(["used"]);
                                $bool = false;
    
                                if (intval($coupon->used) < intval($coupon->limit)) {
                                    $bool = true;
                                }
                            }

                            if ($bool) {
                                $coupon->and(["type"]);

                                if ($coupon->type->id_type == 1) {
                                    if ($price - ($price * intval($coupon->type->value) / 100) >= 10) {
                                        $price -= $price * intval($coupon->type->value) / 100;
                                        $input->id_coupon = $coupon->id_coupon;
                                    }
                                }
                                if ($coupon->type->id_type == 2) {
                                    if ($price - intval($coupon->type->value) >= 10) {
                                        $price -= intval($coupon->type->value);
                                        $input->id_coupon = $coupon->id_coupon;
                                    }
                                }
                            }
                        }
                    }
                    if ($price < 10) {
                        $price = 10;
                    }

                    $data = (object) [
                        "id" => $lesson->id_lesson,
                        "title" => ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $lesson->users->from->username,
                        "price" => $price,
                    ];

                    $user->and(["credentials"]);
                    
                    $MP = new MercadoPago([
                        "access_token" => $user->credentials->mercadopago->access_token,
                    ]);
                    $MP->items([$data]);
                    $MP->preference($data);
                    $url = $MP->preference->init_point;
                    break;
                case 2:
                    $url = route("checkout.status", [
                        "id_lesson" => $lesson->id_lesson,
                        "id_status" => 3,
                    ]);

                    if ($coupon) {
                        $coupon = Coupon::findByName($input->coupon);
                        $input->id_coupon = $coupon->id_coupon;
                    }
                    break;
            }

            unset($lesson->type);
            unset($lesson->users);
            unset($input->coupon);
            $lesson->update((array) $input);

            $lesson->and(["type", "users", "started_at", "ended_at"]);

            new Mail([ "id_mail" => 5, ], [
                "email_to" => $lesson->users->from->email,
                "lesson" => $lesson,
                "link" => Platform::link(),
            ]);
            new Mail([ "id_mail" => 8, ], [
                "email_to" => $lesson->users->to->email,
                "lesson" => $lesson,
                "link" => Platform::link(),
            ]);
            
            // * Create the GoogleCalendar event.
            if ($lesson->type->id_type === 1 || $lesson->type->id_type === 3) {
                foreach ($days as $day) {
                    $data = [];
                    $data["users"] = $lesson->users;
                    $data["name"] = ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $lesson->users->from->username;
                    $data["description"] = "Clase reservada desde el sitio web GameChangerZ";
                    $data["started_at"] = new Carbon($day["date"]."T".Hour::option($day["hour"]["id_hour"])->from);
                    $data["ended_at"] = new Carbon($day["date"]."T".Hour::option($day["hour"]["id_hour"])->to);
    
                    new Event($data);
                }
            }

            if (isset(Auth::user()->credits) && Auth::user()->credits && intval(Auth::user()->credits)) {
                Auth::user()->update([
                    "credits" => intval(Auth::user()->credits) - intval($input->credits),
                ]);
            }

            if (!Auth::user()->discord || $input->discord != Auth::user()->discord) {
                Auth::user()->update([
                    "discord" => $input->discord,
                ]);
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
        public function notification (Request $request) {
            // * Get the Lesson
            $lesson = Lesson::find($request->id_lesson);

            // * Get the User credentials
            $lesson->and(["users"]);
            $lesson->users->from->and(["credentials"]);

            // * Check the Notification type
            switch ($request->type) {
                case "mercadopago":
                    // // * Create the MercadoPago
                    // $MP = new MercadoPago([
                    //     "access_token" => $lesson->users->from->credentials->mercadopago->access_token,
                    // ]);
                    $MP = new MercadoPago([
                        "access_token" => config("services.mercadopago.access_token"),
                    ]);
        
                    // * Check the request topic
                    switch ($request->topic) {
                        case "payment":
                            // * Set the MercadoPago Payment & Merchant order
                            $MP->payment($request->id);
                            break;
                        case "merchant_order":
                            // * Set the MercadoPago Merchant order
                            $MP->merchant_order($request->id);
                            break;
                    }
                    break;

                    // * Get the amount paid
                    $paid_amount = 0;
                    foreach ($MP->merchant_order->payments as $payment) {
                        if ($payment["status"] == "approved") {
                            $paid_amount += $payment["transaction_amount"];
                        }
                    }
                    
                    // ? If the payment's transaction amount is equal (or bigger) than the merchant_order's amount you can release your items
                    if ($paid_amount >= $MP->merchant_order->total_amount) {
                        // unset($lesson->users);

                        // // * Totally paid. Release your item
                        // $lesson->update([
                        //     "id_status" => 3,
                        // ]);
                        dd(true);
                    } else {
                        // * Not paid yet. Do not release your item
                    }
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
            $user->and(["prices", "days", "lessons", "credentials"]);
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
                        "id_type" => $type->id_type,
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

            if (isset($user->credentials->paypal)) {
                $client_id = $user->credentials->paypal->access_token;
            }
            if (!isset($user->credentials->paypal)) {
                $client_id = config("services.paypal.client_id");
            }

            return view("user.checkout", [
                "client_id" => $client_id,
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
            $lesson->and(["started_at", "ended_at"]);

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