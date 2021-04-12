<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use App\Models\Hour;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Day extends Model {
        use HasFactory;

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

        /**
         * * Check if a Day exists.
         * @param int $id_day Day primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_day) {
            $found = false;
            foreach (Day::$options as $day) {
                $day = (object) $day;
                if ($day->id_day === $id_day) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Day.
         * @param int $id_day Day primary key. 
         * @return object
         */
        static public function findOptions ($id_day) {
            foreach (Day::$options as $day) {
                $day = (object) $day;
                if ($day->id_day === $id_day) {
                    $dayFound = $day;
                }
            }
            return $dayFound;
        }

        /**
         * * Parse a Days array.
         * @param array $daysToParse Example: "[{\"id_day\":1,\"hours\":[{\"id_hour\":1},{\"id_hour\":2}]}]"
         * @return array
         */
        static public function parse ($daysToParse) {
            $days = collect([]);
            foreach ($daysToParse as $day) {
                $day = (object) $day;
                if (Day::hasOptions($day->id_day)) {
                    $aux = [
                        'day' => Day::findOptions($day->id_day),
                        'hours' => collect([]),
                    ];
                    foreach ($day->hours as $hour) {
                        $hour = (object) $hour;
                        if (Hour::hasOptions($hour->id_hour)) {
                            $aux['hours']->push(Hour::findOptions($hour->id_hour));
                        }
                    }
                    $days->push($aux);
                }
            }
            return $days;
        }

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
    }