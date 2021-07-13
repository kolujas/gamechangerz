<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Hour extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_hour';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_hour', 'active', 'from', 'time', 'to',
        ];

        /**
         * * Set the Day info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        default:
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case 'active':
                        $this->active($column[1]);
                        break;
                }
            }
        }

        /**
         * * Set if the Hour is active.
         * @param array [$hours]
         */
        public function active (array $hours = []) {
            $this->active = false;

            foreach ($hours as $data) {
                if ($this->id_hour === $data['id_hour']) {
                    $this->active = true;
                }
            }
        }

        /**
         * * Returns a Hour.
         * @param int $id_hour
         * @return Hour
         */
        static public function option (int $id_hour) {
            foreach (Hour::$options as $option) {
                if ($option['id_hour'] === $id_hour) {
                    return new Hour($option);
                }
            }

            dd("Hour \"$id_hour\" not found");
        }

        /**
         * * Returns the Hour options.
         * @param array [$hours] Example: [["id_hour"=>1]]
         * @param bool [$all=true]
         * @return Hour[]
         */
        static public function options (array $hours = [], bool $all = true) {
            $collection = collect();

            foreach (Hour::$options as $option) {
                $option = new Hour($option);
                $option->active = false;
                $found = false;
                
                foreach ($hours as $data) {
                    $option->active = false;

                    if ($option->id_hour === $data['id_hour']) {
                        $option->active = true;
                        $found = true;
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($option);
                }
            }

            return $collection;
        }

        /**
         * * Parse an Hours array.
         * @param string [$hours] Example: "[{\"id_hour\":1,\"stars\":3.5}]"
         * @return Hour[]
         */
        static public function parse (string $hours = '') {
            $collection = collect();
            
            foreach (json_decode($hours) as $data) {
                $hour = Hour::option($data->id_hour);

                $collection->push($hour);
            }
            
            return $collection;
        }

        /**
         * * Stringify an Hours array.
         * @param array [$hours] Example: [["id_hour"=>1]]
         * @return string
         */
        static public function stringify (array $hours = []) {
            $collection = collect();
            
            foreach ($hours as $time => $data) {
                $hours = Hour::time($time);
                
                foreach ($hours as $hour) {
                    $collection->push([
                        "id_hour" => $hour->id_hour,
                    ]);
                }
            }

            return $collection->toJson();
        }

        /**
         * * Get all the Hours by the time.
         * @param int [$time=1]
         * @return array
         */
        static public function time (int $time = 1) {
            $collection = collect();

            foreach (Hour::$options as $hour) {
                if ($hour['time'] === $time) {
                    $collection->push(new Hour($hour));
                }
            }

            return $collection;
        }

        /**
         * * Get an Hour from the "from" value.
         * @param string $from
         * @return Hour
         */
        static public function from (string $from = '') {
            foreach (Hour::$options as $hour) {
                if ($hour['from'] === $from) {
                    return new this($hour);
                }
            }

            dd("Hour from \"$from\" not found");
        }

        /**
         * * Get an Hour from the "to" value.
         * @param string $to
         * @return Hour
         */
        static public function to (string $to = '') {
            foreach (Hour::$options as $hour) {
                if ($hour['to'] === $to) {
                    return new this($hour);
                }
            }

            dd("Hour to \"$to\" not found");
        }

        /**
         * * Hour options.
         * @var array
         */
        static $options = [[
            'id_hour' => 1,
            'from' => '00:00',
            'to' => '01:00',
            'active' => true,
            'time' => 3
        ], [
            'id_hour' => 2,
            'from' => '07:00',
            'to' => '08:00',
            'active' => true,
            'time' => 1 
        ], [
            'id_hour' => 3,
            'from' => '08:00',
            'to' => '09:00',
            'active' => true,
            'time' => 1 
        ], [
            'id_hour' => 4,
            'from' => '09:00',
            'to' => '10:00',
            'active' => true,
            'time' => 1 
        ], [
            'id_hour' => 5,
            'from' => '10:00',
            'to' => '11:00',
            'active' => true,
            'time' => 1 
        ], [
            'id_hour' => 6,
            'from' => '11:00',
            'to' => '12:00',
            'active' => true,
            'time' => 1 
        ], [
            'id_hour' => 7,
            'from' => '12:00',
            'to' => '13:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 8,
            'from' => '13:00',
            'to' => '14:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 9,
            'from' => '14:00',
            'to' => '15:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 10,
            'from' => '15:00',
            'to' => '16:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 11,
            'from' => '16:00',
            'to' => '17:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 12,
            'from' => '17:00',
            'to' => '18:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 13,
            'from' => '18:00',
            'to' => '19:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 14,
            'from' => '19:00',
            'to' => '20:00',
            'active' => true,
            'time' => 2
        ], [
            'id_hour' => 15,
            'from' => '20:00',
            'to' => '21:00',
            'active' => true,
            'time' => 3
        ], [
            'id_hour' => 16,
            'from' => '21:00',
            'to' => '22:00',
            'active' => true,
            'time' => 3
        ], [
            'id_hour' => 17,
            'from' => '22:00',
            'to' => '23:00',
            'active' => true,
            'time' => 3
        ], [
            'id_hour' => 18,
            'from' => '23:00',
            'to' => '00:00',
            'active' => true,
            'time' => 3
        ]];
    }