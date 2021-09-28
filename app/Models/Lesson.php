<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Method;
    use App\Models\Review;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\GoogleCalendar\Event;

    class Lesson extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = "lessons";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_lesson";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "assignments",
            "coupon",
            "days",
            "id_method",
            "id_status",
            "id_type",
            "id_user_from",
            "id_user_to",
            "name",
            "price",
            "slug",
            "svg",
        ];

        /**
         * * Set the Lesson info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "abilities":
                            $this->abilities();
                            break;
                        case "assignments":
                            $this->assignments();
                            break;
                        case "chat":
                            $this->chat();
                            break;
                        case "days":
                            $this->days();
                            break;
                        case "ended_at":
                            $this->ended_at();
                            break;
                        case "method":
                            $this->method();
                            break;
                        case "price":
                            $this->price();
                            break;
                        case "reviews":
                            $this->reviews();
                            break;
                        case "started_at":
                            $this->started_at();
                            break;
                        case "type":
                            $this->type();
                            break;
                        case "users":
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

            $this->users->from->and(["abilities", "games"]);
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
         * * Set the Lesson Assignment
         */
        public function assignments () {
            if (gettype($this->assignments) == "integer") {
                $this->{"quantity-of-assignments"} = $this->assignments;
                $this->assignments = collect();
    
                foreach (Assignment::allFromLesson($this->id_lesson) as $assignment) {
                    $assignment->and(["presentation"]);
    
                    $this->assignments->push($assignment);
                }
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
         * * Set the Lesson Hours.
         */
        public function method () {
            $this->method = Method::option($this->id_method);
        }

        /**
         * * Set the Lesson ended_at.
         */
        public function ended_at () {
            if (gettype($this->days) === "string") {
                $this->days();
            }

            if ($this->id_type == 1 || $this->id_type == 3) {
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
            }
            if ($this->id_type == 2) {
                $this->assignments();
                if (count($this->assignments) >= $this->{"quantity-of-assignments"}) {
                    foreach ($this->assignments as $assignment) {
                        if ($assignment->presentation) {
                            if (!isset($ended_at)) {
                                $ended_at = Carbon::parse($assignment->presentation->created_at)->addDays(2);
                            }
                            if ($ended_at < Carbon::parse($assignment->presentation->created_at)) {
                                $ended_at = Carbon::parse($assignment->presentation->created_at)->addDays(2);
                            }
                        }
                        if (!$assignment->presentation) {
                            $ended_at = Carbon::parse($this->created_at)->addYear(1);
                            break;
                        }
                    }
                }
                if (count($this->assignments) < $this->{"quantity-of-assignments"}) {
                    $ended_at = Carbon::parse($this->created_at)->addYear(1);
                }
            }

            if (!isset($ended_at)) {
                $ended_at = Carbon::now();
            }

            $this->ended_at = $ended_at;
        }

        /**
         * * Get all the Lesson price.
         * @return array
         */
        public function price () {
            $this->price = json_decode($this->price);
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
            if (gettype($this->days) === "string") {
                $this->days();
            }

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

            // if (!isset($started_at)) {
            //     $started_at = new Carbon();
            // }

            $this->started_at = $started_at;
        }

        /**
         * * Set the Lesson Type.
         */
        public function type () {
            foreach (Lesson::$types as $type) {
                if ($type["id_type"] === $this->id_type) {
                    $this->type = (object) $type;
                }
            }
        }

        /**
         * * Set the Lesson Users.
         */
        public function users () {
            $this->users = (object) [
                "from" => User::find($this->id_user_from),
                "to" => User::find($this->id_user_to),
            ];
            $this->users->from->and(["files", "prices", "games", "abilities"]);
            $this->users->to->and(["files", "games"]);
        }

        /**
         * * Get all the Lessons with id_status = 1.
         * @return Lesson[]
         */
        static public function allCreated () {
            return Lesson::where("id_status", "=", "1")->get();
        }

        /**
         * * Get all the Lessons with id_status = 4 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allStartedFromUser (int $id_user) {
            return Lesson::where([
                ["id_user_from", "=", $id_user],
                ["id_status", "=", 3],
            ])->orwhere([
                ["id_user_to", "=", $id_user],
                ["id_status", "=", 3]
            ])->get();
        }

        /**
         * * Get all the Lessons with id_status = 4 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allDoneFromUser (int $id_user) {
            return Lesson::where([
                ["id_user_from", "=", $id_user],
                ["id_status", ">=", 3],
            ])->orwhere([
                ["id_user_to", "=", $id_user],
                ["id_status", ">=", 3]
            ])->get();
        }

        /**
         * * Get all the Lessons from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allFromUser (int $id_user) {
            return Lesson::where("id_user_from", "=", $id_user)->orwhere("id_user_to", "=", $id_user)->get();
        }

        /**
         * * Get all the Lessons from a teacher.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allFromTeacher (int $id_user) {
            return Lesson::where([
                ["id_user_from", "=", $id_user],
                ["id_status", ">", 0],
            ])->get();
        }

        /**
         * * Get all the Lessons with id_status = 3 from an User.
         * @param int $id_user
         * @return Lesson[]
         */
        static public function allReadyFromUser (int $id_user) {
            return Lesson::where([
                ["id_user_from", "=", $id_user],
                ["id_status", "=", 3],
            ])->orwhere([
                ["id_user_to", "=", $id_user],
                ["id_status", "=", 3],
            ])->get();
        }

        /**
         * * Get a Lesson by the Users.
         * @param int $id_user_1
         * @param int $id_user_2
         * @return Lesson
         */
        static public function findByUsers (int $id_user_1, int $id_user_2) {
            return Lesson::where([
                ["id_user_from", "=", $id_user_1],
                ["id_user_to", "=", $id_user_2],
            ])->orwhere([
                ["id_user_from", "=", $id_user_2],
                ["id_user_to", "=", $id_user_1],
            ])->get();
        }

        /**
         * * Change the Lesson id_status to 4.
         * @param int $id_lesson
         */
        static public function finish (int $id_lesson) {
            $lesson = Lesson::find($id_lesson);
            $reviews = Review::allFromLesson($lesson->id_lesson);

            if (count($reviews) === 2) {
                $lesson->update([
                    "id_status" => 4,
                ]);
            }
        }

        /**
         * * Check if a Lesson exists.
         * @param string|int $field 
         * @return bool
         */
        static public function has ($field = "") {
            foreach (Lesson::$types as $option) {
                if ($option["id_type"] === $field || $option["slug"] === $field) {
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
        static public function option ($field = "") {
            foreach (Lesson::$types as $type) {
                if ($type["id_type"] === $field || $type["slug"] === $field) {
                    return new Lesson($type);
                }
            }

            dd("Lesson type: \"$field\" not found");
        }

        /**
         * * Returns the Lesson options.
         * @param array [$types] Example: [["id_type"=>1]]
         * @param bool [$all=true]
         * @return Lesson[]
         */
        static public function options (array $types = [], bool $all = true) {
            $collection = collect();

            foreach (Lesson::$types as $type) {
                $type = new Lesson($type);
                $found = false;
                
                foreach ($types as $data) {
                    if ($type->id_type === $data['id_type']) {
                        $found = true;
                        break;
                    }
                }

                if ($all || $found) {
                    $collection->push($type);
                }
            }

            return $collection;
        }

        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            "panel" => [
                "create" => [
                    "1on1" => [
                        "rules" => [
                            "dates" => "required",
                            "hours" => "required",
                            "id_user_from" => "required|exists:users,id_user",
                            "id_user_to" => "required|exists:users,id_user",
                            "id_method" => "required",
                            "id_type" => "required",
                            "price" => "required",
                            "fee" => "required",
                            "credits" => "required",
                        ], "messages" => [
                            "es" => [
                                "dates.required" => "La fecha de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.",
                                "hours.required" => "El horario de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.",
                                "id_user_from.required" => "El profesor es obligatorio.",
                                "id_user_from.exists" => "El profesor no existe.",
                                "id_user_to.required" => "El usuario es obligatorio.",
                                "id_user_to.exists" => "El usuario no existe.",
                                "id_method.required" => "El metodo es obligatorio.",
                                "id_type.required" => "El tipo de clase es obligatorio.",
                                "fee.required" => "La comisión es obligatoria.",
                                "credits.required" => "Los créditos son obligatorios.",
                            ],
                        ],
                    ], "seguimiento-online" => [
                        "rules" => [
                            "id_user_from" => "required|exists:users,id_user",
                            "id_user_to" => "required|exists:users,id_user",
                            "id_method" => "required",
                            "id_type" => "required",
                            "dates" => "required",
                            "assignments" => "required",
                            "price" => "required",
                            "fee" => "required",
                            "credits" => "required",
                        ], "messages" => [
                            "es" => [
                                "id_user_from.required" => "El profesor es obligatorio.",
                                "id_user_from.exists" => "El profesor no existe.",
                                "id_user_to.required" => "El usuario es obligatorio.",
                                "id_user_to.exists" => "El usuario no existe.",
                                "id_method.required" => "El metodo es obligatorio.",
                                "id_type.required" => "El tipo de clase es obligatorio.",
                                "dates.required" => "La fecha de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.",
                                "assignments.required" => "La cantidad de assignments es obligatoria.",
                                "fee.required" => "La comisión es obligatoria.",
                                "credits.required" => "Los créditos son obligatorios.",
                            ],
                        ],
                    ], "packs" => [
                        "rules" => [
                            "dates" => "required|array|min:4",
                            "hours" => "required|array|min:4",
                            "id_user_from" => "required|exists:users,id_user",
                            "id_user_to" => "required|exists:users,id_user",
                            "id_method" => "required",
                            "id_type" => "required",
                            "price" => "required",
                            "fee" => "required",
                            "credits" => "required",
                        ], "messages" => [
                            "es" => [
                                "dates.required" => "Las fechas de la clase deben ser seleccionadas. Recuerda que primero debes elegir el tipo de clase.",
                                "dates.array" => "Las fechas deben estar en un array ([]).",
                                "dates.min" => "Mínimo :min fechas deben ser seleccionadas.",
                                "hours.required" => "El horario de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.",
                                "hours.array" => "El horario deben estar en un array ([]).",
                                "hours.min" => "Mínimo :min horas deben ser seleccionadas.",
                                "id_user_from.required" => "El profesor es obligatorio.",
                                "id_user_from.exists" => "El profesor no existe.",
                                "id_user_to.required" => "El usuario es obligatorio.",
                                "id_user_to.exists" => "El usuario no existe.",
                                "id_method.required" => "El metodo es obligatorio.",
                                "id_type.required" => "El tipo de clase es obligatorio.",
                                "fee.required" => "La comisión es obligatoria.",
                                "credits.required" => "Los créditos son obligatorios.",
                            ],
                        ],
                    ],
                ], "delete" => [
                    "rules" => [
                        "message" => "required|regex:/^BORRAR$/",
                    ], "messages" => [
                        "es" => [
                            "message.required" => "El mensaje es obligatorio.",
                            "message.regex" => "El mensaje debe decir BORRAR.",
                        ],
                    ],
                ],
            ], "update" => [
                "rules" => [
                    "dates" => "required",
                    "hours" => "required",
                ], "messages" => [
                    "es" => [
                        "dates.required" => "La fecha de la clase debe ser seleccionada.",
                        "hours.required" => "El horario de la clase debe ser seleccionada.",
                    ],
                ],
            ], "checkout" => [
                "1on1" => [
                    "rules" => [
                        "dates" => "required",
                        "dates.*" => "required",
                        "hours" => "required",
                        "hours.*" => "required",
                        "discord" => "required|unique:users,discord,{id_user},id_user|regex:/([a-z])*#([0-9])*/i",
                    ], "messages" => [
                        "es" => [
                            "dates.required" => "La fecha de la clase debe ser seleccionada.",
                            "hours.required" => "El horario de la clase debe ser seleccionada.",
                            "dates.*.required" => "No se seleccionó una fecha.",
                            "hours.*.required" => "No se seleccionó una hora.",
                            "discord.required" => "El nombre de usuario de Discord es obligatorio.",
                            "discord.regex" => "El nombre de usuario de Discord no es válido (username#0000).",
                            'discord.unique' => 'Ese nombre de usuario de Discord ya se encuentra en uso.',
                        ],
                    ],
                ], "seguimiento-online" => [
                        "rules" => [
                        // 
                    ], "messages" => [
                        "es" => [
                            // 
                        ],
                    ],
                ], "packs" => [
                        "rules" => [
                        "dates" => "required|array|max:4",
                        "dates.*" => "required",
                        "hours" => "required|array|min:4|max:4",
                        "hours.*" => "required",
                        "discord" => "required|unique:users,discord,{id_user},id_user|regex:/([a-z])*#([0-9])*/i",
                    ], "messages" => [
                        "es" => [
                            "dates.required" => "Las fechas de la clase deben ser seleccionadas.",
                            "dates.array" => "Las fechas deben estar en un array ([]).",
                            "dates.max" => "Máximo :max fechas deben ser seleccionadas.",
                            "hours.required" => "Las horas de la clase deben ser seleccionadas.",
                            "hours.array" => "Las horas deben estar en un array ([]).",
                            "hours.min" => "Mínimo :min horas deben ser seleccionadas.",
                            "hours.max" => "Máximo :max horas deben ser seleccionadas.",
                            "dates.*.required" => "No se seleccionó una fecha.",
                            "hours.*.required" => "No se seleccionó una hora.",
                            "discord.required" => "El nombre de usuario de Discord es obligatorio.",
                            "discord.regex" => "El nombre de usuario de Discord no es válido (username#0000).",
                            'discord.unique' => 'Ese nombre de usuario de Discord ya se encuentra en uso.',
                        ],
                    ],
                ],
            ],
        ];

        /**
         * * Lesson types.
         * @var array
         */
        static $types = [[
            "id_type" => 1,
            "name" => "1on1",
            "svg" => "components.svg.ClaseOnline1SVG",
            "slug" => "1on1",
        ], [
            "id_type" => 2,
            "name" => "seguimiento-online",
            "svg" => "components.svg.ClaseOnline2SVG",
            "slug" => "seguimiento-online",
        ], [
            "id_type" => 3,
            "name" => "Packs",
            "svg" => "components.svg.ClaseOnline3SVG",
            "slug" => "packs",
        ]];
    }