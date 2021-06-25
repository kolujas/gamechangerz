<?php
    namespace App\Http\Controllers;

    use App\Models\Auth as AuthModel;
    use App\Models\Assigment;
    use App\Models\Event;
    use App\Models\Hour;
    use App\Models\Lesson;
    use App\Models\MercadoPago;
    use App\Models\User;
    use Auth;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;

    class LessonController extends Controller {
        /**
         * * Check the Notification
         * @param Request $request
         * @param string $type Notification type.
         * @return [type]
         */
        public function checkNotification (Request $request, string $type) {
            // * Check the Notification type
            switch ($type) {
                case 'mercadopago':
                    // * Creates the MercadoPago
                    $MP = new MercadoPago();
        
                    // * Check the request topic
                    switch ($request->topic) {
                        case "payment":
                            // * Set the MercadoPago Payment
                            $MP->payment($request->id);
                            
                            // * Check the Payment status
                            if ($MP->payment->status === 'approved') {
                                // * Get the external Preference & updates
                                $lesson = Lesson::find($MP->payment->external_preference);
                
                                $lesson->update([
                                    'status' => 3,
                                ]);
                            }
                            break;
                    }
                    break;
                case 'paypal':
                    break;
            }
        }

        /**
         * * Update a Lesson & redirects to MercadoPago.
         * @param Request $request
         * @param string $id_lesson
         * @return [type]
         */
        public function checkout (Request $request, string $id_lesson) {
            $input = (object) $request->all();

            $validator = Validator::make($request->all(), Lesson::$validation['checkout']['online']['rules'], Lesson::$validation['checkout']['online']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $lesson = Lesson::find($id_lesson);

            $days = collect([]);
            for ($i=0; $i < count($input->dates); $i++) {
                foreach (Lesson::where([
                    ['id_user_from', '=', $lesson->id_user_from],
                    ['status', '>', 0],
                ])->get() as $lesson) {
                    $lesson->and(['days']);
                    if ($lesson->id_lesson !== intval($id_lesson)) {
                        foreach ($lesson->days as $day) {
                            $day = (object) $day;
                            if ($day->date === $input->dates[$i]) {
                                foreach ($day->hours as $hour) {
                                    if ($hour->id_hour === intval($input->hours[$i])) {
                                        $date = $input->dates[$i];
                                        $hours = $hour->from . " - " . $hour->to;
                                        return redirect()->back()->withInput()->with('status', [
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

            $lesson = Lesson::find($id_lesson);
            $input->days = json_encode($days);
            $lesson->update((array) $input);
            $lesson->and(['type']);

            if (config('app.env') !== 'local') {
                if ($lesson->type->id_type === 1 || $lesson->type->id_type === 3) {
                    foreach ($input->dates as $key => $date) {
                        $data = (object) [];
                        $data->users = [
                            'from' => $user,
                            'to' => Auth::user(),
                        ];
                        $data->name = ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $data->users['from']->username;
                        $data->description = "Clase reservada desde el sitio web GameChangerZ";
                        $data->startDateTime = new Carbon($date."T".Hour::one($input->hours[$key])->from);
                        $data->endDateTime = new Carbon($date."T".Hour::one($input->hours[$key])->to);
        
                        Event::Create($data);
                    }
                }
            }

            switch ($input->method) {
                case 'mercadopago':
                    $data = (object) [
                        'id' => $lesson->id_lesson,
                        'title' => ($lesson->type->id_type === 3 ? "4 Clases" : "1 Clase") . ($lesson->type->id_type === 2 ? " Offline" : " Online") . " de " . $user->username,
                        'price' => $user->prices[$lesson->type->id_type - 1]->price,
                    ];

                    $MP = new MercadoPago($data);
                    $MP->items([$data]);
                    $MP->preference($data);
                    $url = $MP->preference->init_point;
                    break;
                case 'paypal':
                    $lesson->update([
                        'status' => 3,
                    ]);
                    $url = route('lesson.checkout.status', [
                        'id_lesson' => $lesson->id_lesson,
                        'status' => 2,
                    ]);
                    break;
            }

            return redirect($url);
        }


        /**
         * * Show the Lesson status.
         * @param Request $request
         * @param string $id_lesson
         * @param string $status
         * @return [type]
         */
        public function showStatus (Request $request, string $id_lesson, string $status) {
            $lesson = Lesson::find($id_lesson);
            $lesson->and(['days']);

            $error = null;
            if ($request->session()->has('error')) {
                $error = (object) $request->session()->pull('error');
            }

            return view('lesson.status', [
                'error' => $error,
                'lesson' => $lesson,
                'status' => $status,
                'validation' => [
                    'login' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['login']['rules'], 'login_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['login']['messages']['es'], 'login_'),
                ], 'signin' => (object)[
                        'rules' => $this->encodeInput(AuthModel::$validation['signin']['rules'], 'signin_'),
                        'messages' => $this->encodeInput(AuthModel::$validation['signin']['messages']['es'], 'signin_'),
                ], 'assigment' => (object)[
                        'rules' => Assigment::$validation['make']['rules'],
                        'messages' => Assigment::$validation['make']['messages']['es'],
                ]],
            ]);
        }
    }