<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
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

        /** @var array Day hours */
        static $hours = [[
                'id_hour' => 1,
                'from' => '07:00',
                'to' => '08:00',
                'active' => true,
            ], [
                'id_hour' => 2,
                'from' => '08:00',
                'to' => '09:00',
                'active' => true,
            ], [
                'id_hour' => 3,
                'from' => '09:00',
                'to' => '10:00',
                'active' => true,
            ], [
                'id_hour' => 4,
                'from' => '10:00',
                'to' => '11:00',
                'active' => true,
            ], [
                'id_hour' => 5,
                'from' => '11:00',
                'to' => '12:00',
                'active' => true,
            ], [
                'id_hour' => 6,
                'from' => '12:00',
                'to' => '13:00',
                'active' => true,
            ], [
                'id_hour' => 7,
                'from' => '13:00',
                'to' => '14:00',
                'active' => true,
            ], [
                'id_hour' => 8,
                'from' => '14:00',
                'to' => '15:00',
                'active' => true,
            ], [
                'id_hour' => 9,
                'from' => '15:00',
                'to' => '16:00',
                'active' => true,
            ], [
                'id_hour' => 10,
                'from' => '16:00',
                'to' => '17:00',
                'active' => true,
            ], [
                'id_hour' => 11,
                'from' => '17:00',
                'to' => '18:00',
                'active' => true,
            ], [
                'id_hour' => 12,
                'from' => '18:00',
                'to' => '19:00',
                'active' => true,
            ], [
                'id_hour' => 1,
                'from' => '19:00',
                'to' => '20:00',
                'active' => true,
            ], [
                'id_hour' => 3,
                'from' => '20:00',
                'to' => '21:00',
                'active' => true,
            ], [
                'id_hour' => 14,
                'from' => '21:00',
                'to' => '22:00',
                'active' => true,
            ], [
                'id_hour' => 15,
                'from' => '22:00',
                'to' => '23:00',
                'active' => true,
            ], [
                'id_hour' => 16,
                'from' => '23:00',
                'to' => '00:00',
                'active' => true,
            ], [
                'id_hour' => 17,
                'from' => '00:00',
                'to' => '01:00',
                'active' => true,
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
         * * Check if a Day Hour exists.
         * @param int $id_hour Day Hour primary key. 
         * @return boolean
         */
        static public function hasHour ($id_hour) {
            $found = false;
            foreach (Day::$hours as $hour) {
                $hour = (object) $hour;
                if ($hour->id_hour === $id_hour) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Day Hour.
         * @param int $id_hour Day Hour primary key. 
         * @return object
         */
        static public function findHour ($id_hour) {
            foreach (Day::$hours as $hour) {
                $hour = (object) $hour;
                if ($hour->id_hour === $id_hour) {
                    return $hour;
                }
            }
        }

        /**
         * * Parse a Days array.
         * @param array $daysToParse Example: "[{\"id_day\":1,\"id_from\":9,\"id_to\":16}]"
         * @return array
         */
        static public function parse ($daysToParse) {
            $days = collect([]);
            foreach ($daysToParse as $day) {
                $day = (object) $day;
                if (Day::hasOptions($day->id_day)) {
                    $aux = [
                        'day' => Day::findOptions($day->id_day),
                    ];
                    if (isset($day->id_hour)) {
                        if (Day::hasHour($day->id_hour)) {
                            $aux['hour'] = Day::findHour($day->id_hour);
                        }
                    } else {
                        $aux['hours'] = collect([]);
                        foreach ($day->hours as $hour) {
                            $hour = (object) $hour;
                            if (Day::hasHour($hour->id_hour)) {
                                $aux['hours']->push(Day::findHour($hour->id_hour));
                            }
                        }
                    }
                    $days->push($aux);
                }
            }
            return $days;
        }
    }