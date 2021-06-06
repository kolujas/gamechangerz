<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use App\Models\Hour;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Day extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_day';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_day', 'name', 'slug',
        ];

        /** @var array Day options */
        static $options = [[
            'id_day' => 0,
            'name' => 'Domingo',
            'slug' => 'domingo',
        ],[
            'id_day' => 1,
            'name' => 'Lunes',
            'slug' => 'lunes',
        ],[
            'id_day' => 2,
            'name' => 'Martes',
            'slug' => 'martes',
        ],[
            'id_day' => 3,
            'name' => 'Miércoles',
            'slug' => 'miercoles',
        ],[
            'id_day' => 4,
            'name' => 'Jueves',
            'slug' => 'jueves',
        ],[
            'id_day' => 5,
            'name' => 'Viernes',
            'slug' => 'viernes',
        ],[
            'id_day' => 6,
            'name' => 'Sábado',
            'slug' => 'sabado',
        ]];

        static public function allDates ($daysToParse) {
            $days = collect([]);
            foreach (Day::$options as $day) {
                $day = (object) $day;
                $day->hours = collect([]);
                foreach (Hour::$options as $hour) {
                    $hour = (object) $hour;
                    $hour->active = false;
                    foreach ($daysToParse as $dayParsed) {
                        $dayParsed = (object) $dayParsed;
                        if ($day->id_day === $dayParsed->day->id_day) {
                            foreach ($dayParsed->hours as $hourParsed) {
                                $hourParsed = (object) $hourParsed;
                                if ($hour->id_hour === $hourParsed->id_hour) {
                                    $hour->active = true;
                                }
                            }
                        }
                    }
                    $day->hours->push($hour);
                }
                $days->push($day);
            }
            return $days;
        }

        /**
         * * Check if a Day exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Day::$options as $day) {
                $day = new Day($day);
                if ($day->id_day === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Returns a Day.
         * @param string $field
         * @return Day
         */
        static public function one ($field = '') {
            foreach (Day::$options as $day) {
                $day = new Day($day);
                if ($day->id_day === $field) {
                    return $day;
                }
            }
        }

        /**
         * * Parse a Days array.
         * @param array $daysToParse Example: "[{\"id_day\":1}]"
         * @return Day[]
         * @throws
         */
        static public function parse ($daysToParse = []) {
            $days = collect([]);
            $months = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
            foreach ($daysToParse as $data) {
                if (isset($data->id_day) && !Day::has($data->id_day)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Day with id = \"$data->id_day\" does not exist",
                    ];
                }
                if (isset($data->date)) {
                    $data->date = new Carbon($data->date);
                    $data->id_day = $data->date->dayOfWeek;
                }
                $aux = [
                    'day' => Day::one($data->id_day),
                    'hours' => collect([]),
                ];
                if (isset($data->date)) {
                    $aux['date'] = $data->date->format('Y') . '-'. ((intval($data->date->format('n')) < 10) ? '0' . intval($data->date->format('n')) : intval($data->date->format('n'))) . '-'. $data->date->format('d');
                    $aux['carbon'] = (object) [
                        'day' => $data->date->format('d'),
                        'month' => $months[$data->date->format('n')],
                        'year' => $data->date->format('Y'),
                    ];
                }
                if (isset($data->hours)) {
                    foreach ($data->hours as $hour) {
                        if (Hour::has($hour->id_hour)) {
                            $aux['hours']->push(Hour::one($hour->id_hour));
                        }
                    }
                }
                if (isset($data->hour)) {
                    if (Hour::has($data->hour->id_hour)) {
                        $aux['hours']->push(Hour::one($data->hour->id_hour));
                    }
                }
                $days->push($aux);
            }
            return $days;
        }

        static public function stringify ($daysToParse = []) {
            $days = [];
            foreach ($daysToParse as $id_day => $hours) {
                $days[] = [
                    "id_day" => $id_day,
                    "hours" => Hour::stringify($hours),
                ];
            }
            return json_encode($days);
        }
    }