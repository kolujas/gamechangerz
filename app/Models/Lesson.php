<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Lesson extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'lessons';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_lesson';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'lessons',
        ];

        /** @var array Lesson options */
        static $options = [[
                'id_lesson' => 1,
                'name' => 'Online',
                'svg' => 'svg/ClaseOnline1SVG.svg',
                'slug' => 'online',
            ], [
                'id_lesson' => 2,
                'name' => 'Offline',
                'svg' => 'svg/ClaseOnline1SVG.svg',
                'slug' => 'offline',
            ], [
                'id_lesson' => 3,
                'name' => 'Packs',
                'svg' => 'svg/ClaseOnline3SVG.svg',
                'slug' => 'packs',
        ]];

        /** @var array Lesson days */
        static $days = [[
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

        /** @var array Lesson states */
        static $states = [[
                'id_state' => 0,
                'name' => 'Inactivo',
                'slug' => 'inactivo',
            ],[
                'id_state' => 1,
                'name' => 'En proceso',
                'slug' => 'en-proceso',
            ],[
                'id_state' => 2,
                'name' => 'Terminado',
                'slug' => 'terminado',
        ]];

        /** @var array Lesson hours */
        static $hours = [[
                'id_hour' => 1,
                'from' => '07:00:00',
                'to' => '08:00:00',
                'active' => true,
            ], [
                'id_hour' => 2,
                'from' => '08:00:00',
                'to' => '09:00:00',
                'active' => true,
            ], [
                'id_hour' => 3,
                'from' => '09:00:00',
                'to' => '10:00:00',
                'active' => true,
            ], [
                'id_hour' => 4,
                'from' => '10:00:00',
                'to' => '11:00:00',
                'active' => true,
            ], [
                'id_hour' => 5,
                'from' => '11:00:00',
                'to' => '12:00:00',
                'active' => true,
            ], [
                'id_hour' => 6,
                'from' => '12:00:00',
                'to' => '13:00:00',
                'active' => true,
            ], [
                'id_hour' => 7,
                'from' => '13:00:00',
                'to' => '14:00:00',
                'active' => true,
            ], [
                'id_hour' => 8,
                'from' => '14:00:00',
                'to' => '15:00:00',
                'active' => true,
            ], [
                'id_hour' => 9,
                'from' => '15:00:00',
                'to' => '16:00:00',
                'active' => true,
            ], [
                'id_hour' => 10,
                'from' => '16:00:00',
                'to' => '17:00:00',
                'active' => true,
            ], [
                'id_hour' => 11,
                'from' => '17:00:00',
                'to' => '18:00:00',
                'active' => true,
            ], [
                'id_hour' => 12,
                'from' => '18:00:00',
                'to' => '19:00:00',
                'active' => true,
            ], [
                'id_hour' => 1,
                'from' => '19:00:00',
                'to' => '20:00:00',
                'active' => true,
            ], [
                'id_hour' => 3,
                'from' => '20:00:00',
                'to' => '21:00:00',
                'active' => true,
            ], [
                'id_hour' => 14,
                'from' => '21:00:00',
                'to' => '22:00:00',
                'active' => true,
            ], [
                'id_hour' => 15,
                'from' => '22:00:00',
                'to' => '23:00:00',
                'active' => true,
            ], [
                'id_hour' => 16,
                'from' => '23:00:00',
                'to' => '00:00:00',
                'active' => true,
            ], [
                'id_hour' => 17,
                'from' => '00:00:00',
                'to' => '01:00:00',
                'active' => true,
        ]];

        /**
         * * Check if a Price exists.
         * @param int $id_lesson Price primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_lesson) {
            $found = false;
            foreach (Lesson::$options as $price) {
                $price = (object) $price;
                if ($price->id_lesson === $id_lesson) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Lesson option.
         * @param int $id_lesson Price primary key. 
         * @return object
         */
        static public function findOptions ($id_lesson) {
            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->id_lesson === $id_lesson) {
                    $lessonFound = $lesson;
                }
            }
            return $lessonFound;
        }

        /**
         * * Check if a Lesson exists.
         * @param int $id_day Lesson primary key. 
         * @return boolean
         */
        static public function hasDay ($id_day) {
            $found = false;
            foreach (Lesson::$days as $day) {
                $day = (object) $day;
                if ($day->id_day === $id_day) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Lesson.
         * @param int $id_day Lesson primary key. 
         * @return object
         */
        static public function findDay ($id_day) {
            foreach (Lesson::$days as $day) {
                $day = (object) $day;
                if ($day->id_day === $id_day) {
                    $dayFound = $day;
                }
            }
            return $dayFound;
        }

        /**
         * * Find a Lesson.
         * @param int $id_from Lesson hour primary key. 
         * @param int $id_to Lesson hour primary key. 
         * @return object
         */
        static public function findHours ($id_from, $id_to) {
            $hours = collect([]);
            foreach (Lesson::$hours as $hour) {
                $hour = (object) $hour;
                if ($hour->id_hour >= $id_from && $hour->id_hour <= $id_to) {
                    $hours->push($hour);
                }
            }
            return $hours;
        }

        /**
         * * Find a state.
         * @param int $id_state Lesson state primary key.
         * @return object
         */
        static public function findState ($id_state) {
            foreach (Lesson::$states as $state) {
                $state = (object) $state;
                if ($state->id_state === $id_state) {
                    $stateFound = $state;
                }
            }
            return $stateFound;
        }

        /**
         * * Parse a Lessons array.
         * @param array $lessonsToParse Example: "[{\"id_day\":1,\"id_from\":9,\"id_to\":16}]"
         * @return array
         */
        static public function parse ($lessonsToParse) {
            $lessons = collect([]);
            foreach ($lessonsToParse as $lesson) {
                $lesson = (object) $lesson;
                if (Lesson::hasDay($lesson->id_day)) {
                    $lessons->push([
                        'id_state' => (isset($lesson->id_state) ? Lesson::findState($lesson->id_state) : Lesson::$states[0]),
                        'day' => Lesson::findDay($lesson->id_day),
                        'hours' => Lesson::findHours($lesson->id_from, $lesson->id_to),
                    ]);
                }
            }
            return $lessons;
        }

        /**
         * * Get the User Lessons.
         * @return array
         */
        public function lessons () {
            $this->lessons = Lesson::parse(json_decode($this->lessons));
        }
    }