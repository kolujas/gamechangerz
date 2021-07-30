<?php
    namespace App\Models;

    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Hour;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Day extends Model {
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_day";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_day", "name", "slug",
        ];

        /**
         * * Set the Day info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "carbon":
                            $this->carbon();
                            break;
                        case "status":
                            $this->status();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    case "hours":
                        $this->hours($column[1]);
                        break;
                }
            }
        }

        /**
         * * Set the Day parts parsed with Carbon;
         */
        public function carbon () {
            $carbon = new Carbon($this->date);
            
            $this->carbon = (object) [
                "day" => $carbon->format("d"),
                "month" => Day::$months[$carbon->format("n") - 1],
                "year" => $carbon->format("Y"),
            ];
        }

        /**
         * * Set the Day Hours.
         * @param string [$hours]
         */
        public function hours (string $hours = "") {
            $this->hours = Hour::parse($hours);
        }

        /**
         * * Set the Day status.
         * @param string [$hours]
         */
        public function status () {
            $this->id_status = 0;
            $now = Carbon::now();

            if ($now > new Carbon($this->date)) {
                $this->id_status = 1;
                foreach ($this->hours as $hour) {
                    if ($now < new Carbon($this->date . "T" . $hour->to)) {
                        $this->id_status = 0;
                    }
                }
            }
        }

        /**
         * * Returns a Day.
         * @param int $id_day
         * @return Day
         */
        static public function option (int $id_day) {
            foreach (Day::$options as $option) {
                if ($option["id_day"] === $id_day) {
                    return new Day($option);
                }
            }

            dd("Day \"$id_day\" not found");
        }

        /**
         * * Returns the Day options.
         * @param array [$days] Example: [["id_day"=>1]]
         * @param bool [$all=true]
         * @return Day[]
         */
        static public function options (array $days = [], bool $all = true) {
            $collection = collect();

            foreach (Day::$options as $option) {
                $option = new Day($option);
                $found = false;
                
                foreach ($days as $data) {
                    if ($option->id_day === $data["id_day"]) {
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
         * * Parse an Days array.
         * @param string [$days] Example: "[{\"id_day\":1}]"
         * @return Day[]
         */
        static public function parse (string $days = "") {
            $collection = collect();
            
            foreach (json_decode($days) as $data) {
                if (isset($data->date)) {
                    $carbon = new Carbon($data->date);
                    $data->id_day = $carbon->dayOfWeek;

                    $day = Day::option($data->id_day);
                    $day->date = $data->date;
                    $hours = collect();
                    
                    if (isset($data->hour)) {
                        $hours->push($data->hour);
                    }
                    
                    $day->and(["carbon", ["hours", json_encode($hours)], "status"]);
                }

                if (!isset($data->date)) {
                    $day = Day::option($data->id_day);
    
                    if (isset($data->hours)) {
                        $day->and([["hours", json_encode($data->hours)], "status"]);
                    }
                }

                $collection->push($day);
            }

            return $collection;
        }

        /**
         * * Stringify an Days array.
         * @param array [$days] Example: [["id_day"=>1]]
         * @return string
         */
        static public function stringify (array $days = []) {
            $collection = collect();

            if (count($days) < 7) {
                $notFound = [];

                for ($i=0; $i < 7; $i++) {
                    foreach ($days as $id_day => $data) {
                        if ($i === $id_day) {
                            continue 2;
                        }
                    }

                    $notFound[] = $i;
                }

                foreach ($notFound as $id_day) {
                    $collection->push([
                        "id_day" => $id_day,
                        "hours" => [],
                    ]);
                }
            }
            
            foreach ($days as $id_day => $data) {
                $collection->push([
                    "id_day" => $id_day,
                    "hours" => json_decode(Hour::stringify($data)),
                ]);
            }

            return $collection->toJson();
        }

        /**
         * * Day options.
         * @var array
         */
        static $options = [[
            "id_day" => 0,
            "name" => "Domingo",
            "slug" => "domingo",
        ],[
            "id_day" => 1,
            "name" => "Lunes",
            "slug" => "lunes",
        ],[
            "id_day" => 2,
            "name" => "Martes",
            "slug" => "martes",
        ],[
            "id_day" => 3,
            "name" => "Miércoles",
            "slug" => "miercoles",
        ],[
            "id_day" => 4,
            "name" => "Jueves",
            "slug" => "jueves",
        ],[
            "id_day" => 5,
            "name" => "Viernes",
            "slug" => "viernes",
        ],[
            "id_day" => 6,
            "name" => "Sábado",
            "slug" => "sabado",
        ]];

        /**
         * * Year months.
         * @var array
         */
        static $months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ];
    }