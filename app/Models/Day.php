<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use App\Models\Hour;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Day extends Model {
        use HasFactory;
        
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
            foreach ($daysToParse as $data) {
                if (!Day::has($data->id_day)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Day with id = \"$data->id_day\" does not exist",
                    ];
                }
                $aux = [
                    'day' => Day::one($data->id_day),
                    'hours' => collect([]),
                ];
                foreach ($data->hours as $hour) {
                    if (Hour::has($hour->id_hour)) {
                        $aux['hours']->push(Hour::one($hour->id_hour));
                    }
                }
                $days->push($aux);
            }
            return $days;
        }
    }