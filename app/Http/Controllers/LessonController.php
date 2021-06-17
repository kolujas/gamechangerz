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
        public function doCheckout (Request $request, $slug, $type) {
            $input = (object) $request->all();
            $user = User::where('slug', '=', $slug)->get()[0];

            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->slug === $type) {
                    $type = $lesson;
                }
            }

            $user->and(['prices']);

            $validator = Validator::make($request->all(), Lesson::$validation['checkout']['online']['rules'], Lesson::$validation['checkout']['online']['messages']['es']);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $days = collect([]);
            for ($i=0; $i < count($input->dates); $i++) {
                foreach (Lesson::where([
                    ['id_user_from', '=', $user->id_user],
                    ['status', '>', 0],
                ])->get() as $lesson) {
                    $lesson->and(['days']);
                    foreach ($lesson->days as $day) {
                        $day = (object) $day;
                        foreach ($day->hours as $hour) {
                            if ($hour->id_hour === intval($input->hours[$i])) {
                                if ($day->date === $input->dates[$i]) {
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
            $input->id_type = $type->id_type;
            if (config('app.env') !== 'local') {
                if ($type->id_type === 1 || $type->id_type === 3) {
                    foreach ($input->dates as $key => $date) {
                        $data = (object) [];
                        $data->users = [
                            'from' => $user,
                            'to' => Auth::user(),
                        ];
                        $data->name = ($type->id_type === 3 ? "4 Clases" : "1 Clase") . ($type->id_type === 2 ? " Offline" : " Online") . " de " . $data->users['from']->username;
                        $data->description = "Clase reservada desde el sitio web GameChangerZ";
                        $data->startDateTime = new Carbon($date."T".Hour::one($input->hours[$key])->from);
                        $data->endDateTime = new Carbon($date."T".Hour::one($input->hours[$key])->to);
        
                        Event::Create($data);
                    }
                }
            }
            $lesson = Lesson::create((array) $input);

            switch ($input->method) {
                case 'mercadopago':
                    $data = (object) [
                        'id' => $lesson->id_lesson,
                        'title' => ($type->id_type === 3 ? "4 Clases" : "1 Clase") . ($type->id_type === 2 ? " Offline" : " Online") . " de " . $user->username,
                        'price' => $user->prices[$type->id_type - 1]->price,
                    ];
                    $url = MercadoPago::createPreference($data);
                    break;
            }

            return redirect($url);
        }

        public function showStatus (Request $request, $id_lesson, $status) {
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

        public function checkNotification (Request $request) {
            $input = (object) $request->all();

            $status = MercadoPago::getStatus($_GET["topic"], $_GET["id"]);
            
            dd($status);
            // if ($status === 200) {
                // $id_lesson = MercadoPago::getDataID($_GET["id"]);
                // $lesson
                // return response([], 200);
            // }
        }
    }