<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Folder;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\GoogleCalendar\Event;

    class Lesson extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'lessons';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_lesson';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'coupon', 'days', 'id_game', 'id_type', 'id_user_from', 'id_user_to', 'method', 'name', 'slug', 'status', 'svg',
        ];

        /**
         * * Set the Lesson info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case 'assigments':
                            $this->assigments();
                            break;
                        case 'days':
                            $this->days();
                            break;
                        case 'end_at':
                            $this->end_at();
                            break;
                        case 'start_at':
                            $this->start_at();
                            break;
                        case 'type':
                            $this->type();
                            break;
                        case 'users':
                            $this->users();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    default:
                        break;
                }
            }
        }

        /**
         * * Set the Chat Assigment
         */
        public function assigments () {
            $this->assigments = collect();

            foreach (Assigment::allFromLesson($this->id_lesson) as $assigment) {
                $assigment->and(['abilities', 'game']);

                $this->assigments->push($assigment);
            }
        }

        /**
         * * Set the Lesson Hours.
         */
        public function days () {
            $this->days = Day::parse($this->days);
        }

        /**
         * * Set the Lesson end_at.
         */
        public function end_at () {
            $this->days();

            foreach ($this->days as $date) {
                if (count($date->hours)) {
                    // foreach ($date->hours as $hour) {
                    //     if (!isset($to)) {
                    //         $to = $hour->to;
                    //     }
                    //     if ($to < $hour->to) {
                    //         $to = $hour->to;
                    //     }
                    // }
                    // if (!isset($end_at)) {
                    //     $end_at = $date->date . "T" . $to;
                    // }
                    // if (Carbon::parse($end_at) < Carbon::parse($date->date . "T" . $to)) {
                    //     $end_at = $date->date . "T" . $to;
                    // }
                    dd("TODO: Lesson end_at");
                }
                if (!count($date->hours)) {
                    if (!isset($end_at)) {
                        $end_at = Carbon::parse($date->date)->addWeeks(1);
                    }
                    if ($end_at < Carbon::parse($date->date)) {
                        $end_at = Carbon::parse($date->date)->addWeeks(1);
                    }
                }
            }

            $this->end_at = $end_at;
        }

        /**
         * * Get all the Lesson Reviews.
         * @return array
         */
        public function reviews () {
            return $this->hasMany(Review::class, 'id_lesson', 'id_lesson');
        }

        /**
         * * Set the Lesson start_at.
         */
        public function start_at () {
            $this->days();

            foreach ($this->days as $date) {
                if (count($date->hours)) {
                    // foreach ($date->hours as $hour) {
                    //     if (!isset($to)) {
                    //         $to = $hour->to;
                    //     }
                    //     if ($to < $hour->to) {
                    //         $to = $hour->to;
                    //     }
                    // }
                    // if (!isset($start_at)) {
                    //     $start_at = $date->date . "T" . $to;
                    // }
                    // if (Carbon::parse($start_at) < Carbon::parse($date->date . "T" . $to)) {
                    //     $start_at = $date->date . "T" . $to;
                    // }
                    dd("TODO: Lesson start_at");
                }
                if (!count($date->hours)) {
                    if (!isset($start_at)) {
                        $start_at = Carbon::parse($date->date);
                    }
                    if ($start_at > Carbon::parse($date->date)) {
                        $start_at = Carbon::parse($date->date);
                    }
                }
            }

            $this->start_at = $start_at;
        }

        /**
         * * Set the Lesson Type.
         */
        public function type () {
            foreach (Lesson::$types as $type) {
                if ($type['id_type'] === $this->id_type) {
                    $this->type = (object) $type;
                }
            }
        }

        /**
         * * Set the Lesson Users.
         */
        public function users () {
            $this->users = (object) [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
            $this->users->from->and(['files', 'prices']);
            $this->users->to->and(['files']);
        }

        /**
         * * Get all the Lessons with status = 1.
         * @return Lesson[]
         */
        static public function allCreated () {
            $lessons = Lesson::where('status', '=', '1')->get();

            return $lessons;
        }

        /**
         * * Get all the Lessons with status = 4 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allDoneFromUser (int $id_user) {
            $lessons = Lesson::where([
                ['id_user_to', '=', $id_user],
                ['status', '>', 3],
            ])->get();

            return $lessons;
        }

        /**
         * * Get all the Lessons from a teacher.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allFromTeacher (int $id_user) {
            $lessons = Lesson::where([
                ['id_user_from', '=', $id_user],
                ['status', '>', 0],
            ])->get();

            return $lessons;
        }

        /**
         * * Get all the Lessons with status = 3 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allReadyFromUser (int $id_user) {
            $lessons = Lesson::where([
                ['id_user_from', '=', $id_user],
                ['status', '=', 3],
            ])->orwhere([
                ['id_user_to', '=', $id_user],
                ['status', '=', 3],
            ])->get();
            
            return $lessons;
        }

        /**
         * * Get a Lesson by the Users.
         * @param int $id_user_1
         * @param int $id_user_2
         * @return Lesson
         */
        static public function findByUsers (int $id_user_1, int $id_user_2) {
            $lesson = Lesson::where([
                ['id_user_from', '=', $id_user_1],
                ['id_user_to', '=', $id_user_2],
            ])->orwhere([
                ['id_user_from', '=', $id_user_2],
                ['id_user_to', '=', $id_user_1],
            ])->first();

            return $lesson;
        }

        /**
         * * Check if a Lesson exists.
         * @param string|int $field 
         * @return bool
         */
        static public function has ($field = '') {
            foreach (Lesson::$types as $option) {
                if ($option['id_type'] === $field || $option['slug'] === $field) {
                    return true;
                }
            }

            return false;
        }

        /**
         * * Returns a Lesson type.
         * @param string|int $field
         * @return Lesson
         */
        static public function option ($field = '') {
            foreach (Lesson::$types as $option) {
                if ($option['id_type'] === $field || $option['slug'] === $field) {
                    return new Lesson($option);
                }
            }

            dd("Lesson \"$field\" not found");
        }

        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
        'update' => [
            'rules' => [
                'dates' => 'required',
                'hours' => 'required',
            ], 'messages' => [
                'es' => [
                    'dates.required' => 'La fecha de la clase debe ser seleccionada.',
                    'hours.required' => 'El horario de la clase debe ser seleccionada.',
        ]]],
        'checkout' => [
            'online' => [
                'rules' => [
                    'dates' => 'required',
                    'dates.*' => 'required',
                    'hours' => 'required',
                    'hours.*' => 'required',
                ], 'messages' => [
                    'es' => [
                        'dates.required' => 'La fecha de la clase debe ser seleccionada.',
                        'hours.required' => 'El horario de la clase debe ser seleccionada.',
                        'dates.*.required' => 'No se seleccionó una fecha.',
                        'hours.*.required' => 'No se seleccionó una hora.',
            ]]], 'offline' => [
                'rules' => [
                    // 
                ], 'messages' => [
                    'es' => [
                        // 
            ]]], 'packs' => [
                'rules' => [
                    'dates' => 'required|array|max:4',
                    'dates.*' => 'required',
                    'hours' => 'required|array|min:4|max:4',
                    'hours.*' => 'required',
                ], 'messages' => [
                    'es' => [
                        'dates.required' => 'Las fechas de la clase deben ser seleccionadas.',
                        'dates.array' => 'Las fechas deben estar en un array ([]).',
                        'dates.max' => 'Máximo :max fechas deben ser seleccionadas.',
                        'hours.required' => 'Las horas de la clase deben ser seleccionadas.',
                        'hours.array' => 'Las horas deben estar en un array ([]).',
                        'hours.min' => 'Mínimo :min horas deben ser seleccionadas.',
                        'hours.max' => 'Máximo :max horas deben ser seleccionadas.',
                        'dates.*.required' => 'No se seleccionó una fecha.',
                        'hours.*.required' => 'No se seleccionó una hora.',
        ]]]]];

        /**
         * * Lesson types.
         * @var array
         */
        static $types = [[
            'id_type' => 1,
            'name' => 'Online',
            'svg' => 'components.svg.ClaseOnline1SVG',
            'slug' => 'online',
        ], [
            'id_type' => 2,
            'name' => 'Offline',
            'svg' => 'components.svg.ClaseOnline2SVG',
            'slug' => 'offline',
        ], [
            'id_type' => 3,
            'name' => 'Packs',
            'svg' => 'components.svg.ClaseOnline3SVG',
            'slug' => 'packs',
        ]];
    }