<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Hour extends Model {
        use HasFactory;

        /** @var array Hour options */
        static $options = [[
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
                'id_hour' => 13,
                'from' => '19:00',
                'to' => '20:00',
                'active' => true,
            ], [
                'id_hour' => 14,
                'from' => '20:00',
                'to' => '21:00',
                'active' => true,
            ], [
                'id_hour' => 15,
                'from' => '21:00',
                'to' => '22:00',
                'active' => true,
            ], [
                'id_hour' => 16,
                'from' => '22:00',
                'to' => '23:00',
                'active' => true,
            ], [
                'id_hour' => 17,
                'from' => '23:00',
                'to' => '00:00',
                'active' => true,
            ], [
                'id_hour' => 18,
                'from' => '00:00',
                'to' => '01:00',
                'active' => true,
        ]];

        /**
         * * Check if a Hour exists.
         * @param int $id_hour Hour primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_hour) {
            $found = false;
            foreach (Hour::$options as $hour) {
                $hour = (object) $hour;
                if ($hour->id_hour === $id_hour) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Hour.
         * @param int $id_hour Hour primary key. 
         * @return object
         */
        static public function findOptions ($id_hour) {
            foreach (Hour::$options as $hour) {
                $hour = (object) $hour;
                if ($hour->id_hour === $id_hour) {
                    return $hour;
                }
            }
        }

        /**
         * * Parse a Hours array.
         * @param array $hoursToParse Example: "[{\"id_hour\":1},{\"id_hour\":15},{\"id_hour\":15}]"
         * @return array
         */
        static public function parse ($hoursToParse, $active) {
            $hours = collect([]);
            foreach ($hoursToParse as $hour) {
                $hour = (object) $hour;
                if (Hour::hasOptions($hour->id_hour)) {
                    $hourFound = Hour::findOptions($hour->id_hour);
                    if (!$active) {
                        $hourFound->active = false;
                    }
                    $hours->push($hourFound);
                }
            }
            return $hours;
        }
    }