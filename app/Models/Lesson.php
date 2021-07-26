<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Review;
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
                        case 'abilities':
                            $this->abilities();
                            break;
                        case 'assigments':
                            $this->assigments();
                            break;
                        case 'chat':
                            $this->chat();
                            break;
                        case 'days':
                            $this->days();
                            break;
                        case 'ended_at':
                            $this->ended_at();
                            break;
                        case 'reviews':
                            $this->reviews();
                            break;
                        case 'started_at':
                            $this->started_at();
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
         * * Set the Lesson Abilities
         */
        public function abilities () {
            $this->users();
            $this->abilities = (object)[];

            $this->users->from->and(['abilities', 'games']);
            $from = collect();
            foreach ($this->users->from->games as $game) {   
                foreach ($game->abilities as $ability) {   
                    $from->push($ability);
                }
            }
            $this->abilities->from = $from;

            $to = collect();
            foreach ($this->users->from->abilities as $ability) {
                $to->push($ability);
            }
            $this->abilities->to = $to;
        }

        /**
         * * Set the Lesson Assigment
         */
        public function assigments () {
            $this->assigments = collect();

            foreach (Assigment::allFromLesson($this->id_lesson) as $assigment) {
                $assigment->and(['abilities', 'game']);

                $this->assigments->push($assigment);
            }
        }

        /**
         * * Set the Lesson Chat.
         */
        public function chat () {
            $this->chat = Chat::findByUsers($this->id_user_from, $this->id_user_to);
        }

        /**
         * * Set the Lesson Hours.
         */
        public function days () {
            $this->days = Day::parse($this->days);
        }

        /**
         * * Set the Lesson ended_at.
         */
        public function ended_at () {
            $this->days();

            foreach ($this->days as $date) {
                if (count($date->hours)) {
                    foreach ($date->hours as $hour) {
                        if (!isset($ended_at)) {
                            $ended_at = Carbon::parse($date->date . "T" . $hour->to)->addWeeks(1);
                        }
                        if ($ended_at < Carbon::parse($date->date . "T" . $hour->to)) {
                            $ended_at = Carbon::parse($date->date . "T" . $hour->to)->addWeeks(1);
                        }
                    }
                }
                if (!count($date->hours)) {
                    if (!isset($ended_at)) {
                        $ended_at = Carbon::parse($date->date)->addWeeks(1);
                    }
                    if ($ended_at < Carbon::parse($date->date)) {
                        $ended_at = Carbon::parse($date->date)->addWeeks(1);
                    }
                }
            }

            $this->ended_at = $ended_at;
        }

        /**
         * * Get all the Lesson Reviews.
         * @return array
         */
        public function reviews () {
            $this->reviews = Review::allFromLesson($this->id_lesson);
        }

        /**
         * * Set the Lesson started_at.
         */
        public function started_at () {
            $this->days();

            foreach ($this->days as $date) {
                if (count($date->hours)) {
                    foreach ($date->hours as $hour) {
                        if (!isset($started_at)) {
                            $started_at = Carbon::parse($date->date . "T" . $hour->from);
                        }
                        if ($started_at < Carbon::parse($date->date . "T" . $hour->from)) {
                            $started_at = Carbon::parse($date->date . "T" . $hour->from);
                        }
                    }
                }
                if (!count($date->hours)) {
                    if (!isset($started_at)) {
                        $started_at = Carbon::parse($date->date);
                    }
                    if ($started_at > Carbon::parse($date->date)) {
                        $started_at = Carbon::parse($date->date);
                    }
                }
            }

            $this->started_at = $started_at;
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
            $this->users->from->and(['files', 'prices', 'games', 'abilities']);
            $this->users->to->and(['files', 'games']);
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
        static public function allStartedFromUser (int $id_user) {
            $lessons = Lesson::where([
                ['id_user_from', '=', $id_user],
                ['status', '=', 3],
            ])->orwhere([
                ['id_user_to', '=', $id_user],
                ['status', '=', 3]
            ])->get();

            return $lessons;
        }

        /**
         * * Get all the Lessons with status = 4 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allDoneFromUser (int $id_user) {
            $lessons = Lesson::where([
                ['id_user_from', '=', $id_user],
                ['status', '>=', 3],
            ])->orwhere([
                ['id_user_to', '=', $id_user],
                ['status', '>=', 3]
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
         * * Change the Lesson status to 4.
         * @param int $id_lesson
         */
        static public function finish (int $id_lesson) {
            $lesson = Lesson::find($id_lesson);
            $reviews = Review::allFromLesson($lesson->id_lesson);

            if (count($reviews) === 2) {
                $lesson->update([
                    "status" => 4,
                ]);
            }
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