<?php
    namespace App\Models;

    use App\Models\Chat;
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
            'assignments', 'id_coupon', 'days', 'id_method', 'id_status', 'id_type', 'id_user_from', 'id_user_to', 'name', 'price', 'slug', 'svg',
        ];

        /**
         * * Returns if the Lesson end.
         * @return bool
         */
        public function getEndedAttribute () {
            switch ($this->attributes['id_type']) {
                case 2:
                    return $this->original['assignments'] == Assignment::byLesson($this->attributes['id_lesson'])->count() && Assignment::byLesson($this->attributes['id_lesson'])->orderBy('id_assignment', 'ASC')->get()->last()->presentation != null;
                default:
                    $this->and(['ended_at']);
                    return Carbon::now() > $this->ended_at;
            }
        }

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
                        case 'assignments':
                            $this->assignments();
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
                        case 'method':
                            $this->method();
                            break;
                        case 'price':
                            $this->price();
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
         * * Set the Lesson Assignment
         */
        public function assignments () {
            if (gettype($this->assignments) == 'integer') {
                $this->{'quantity-of-assignments'} = $this->assignments;
                $this->assignments = collect();
    
                foreach (Assignment::byLesson($this->id_lesson)->orderBy('id_assignment', 'ASC')->get() as $assignment) {
                    $this->assignments->push($assignment);
                }
            }
        }

        /**
         * * Get the Chat that owns the Lesson.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function chat () {
            return $this->belongsTo(Chat::class, 'id_user_from', 'id_user_from')->where('id_user_to', $this->attributes['id_user_to']);
        }

        /**
         * * Set the Lesson Hours.
         */
        public function days () {
            $this->days = Day::parse($this->days);
        }

        /**
         * * Creates the Lesson Chat.
         * @return void
         */
        public function generate () {
            $logged_at = collect();

            $logged_at->push([
                'id_user' => $this->attributes['id_user_from'],
                'at' => Carbon::now(),
            ]);

            $logged_at->push([
                'id_user' => $this->attributes['id_user_to'],
                'at' => Carbon::now(),
            ]);

            Chat::create([
                'id_user_from' => $this->attributes['id_user_from'],
                'id_user_to' => $this->attributes['id_user_to'],
                'messages' => collect(),
                'logged_at' => $logged_at,
            ]);
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
            if (gettype($this->days) === 'string') {
                $this->days();
            }

            if ($this->id_type == 1 || $this->id_type == 3) {
                foreach ($this->days as $date) {
                    if (count($date->hours)) {
                        foreach ($date->hours as $hour) {
                            $dayDate = Carbon::parse($date->date);
                            if ($hour->id_hour == 18) {
                                $dayDate->addDays(1);
                            }
        
                            if (!isset($ended_at)) {
                                $ended_at = Carbon::parse($dayDate->format('y-m-d') . 'T' . $hour->to);
                            }
                            if ($ended_at < Carbon::parse($dayDate->format('y-m-d') . 'T' . $hour->to)) {
                                $ended_at = Carbon::parse($dayDate->format('y-m-d') . 'T' . $hour->to);
                            }
                        }
                    }
                    if (!count($date->hours)) {
                        if (!isset($ended_at)) {
                            $ended_at = Carbon::parse($date->date);
                        }
                        if ($ended_at < Carbon::parse($date->date)) {
                            $ended_at = Carbon::parse($date->date);
                        }
                    }
                }
            }
            if ($this->id_type == 2) {
                $this->assignments();
                if (count($this->assignments) >= $this->{'quantity-of-assignments'}) {
                    foreach ($this->assignments as $assignment) {
                        if ($assignment->presentation) {
                            if (!isset($ended_at)) {
                                $ended_at = Carbon::parse($assignment->presentation->created_at);
                            }
                            if ($ended_at < Carbon::parse($assignment->presentation->created_at)) {
                                $ended_at = Carbon::parse($assignment->presentation->created_at);
                            }
                        }
                        if (!$assignment->presentation) {
                            $ended_at = Carbon::parse($this->created_at)->addYear(5);
                            break;
                        }
                    }
                }
                if (count($this->assignments) < $this->{'quantity-of-assignments'}) {
                    $ended_at = Carbon::parse($this->created_at)->addYear(5);
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
            $this->reviews = Review::byLesson($this->id_lesson)->get();
        }

        /**
         * * Set the Lesson started_at.
         */
        public function started_at () {
            if (gettype($this->days) === 'string') {
                $this->days();
            }

            if ($this->id_type == 1 || $this->id_type == 3) {
                foreach ($this->days as $date) {
                    if (count($date->hours)) {
                        foreach ($date->hours as $hour) {        
                            if (!isset($started_at)) {
                                $started_at = Carbon::parse($date->date . 'T' . $hour->from);
                            }
                            if ($started_at < Carbon::parse($date->date . 'T' . $hour->from)) {
                                $started_at = Carbon::parse($date->date . 'T' . $hour->from);
                            }
                        }
                    }
                    if (!count($date->hours)) {
                        if (!isset($started_at)) {
                            $started_at = Carbon::parse($date->date);
                        }
                        if ($started_at < Carbon::parse($date->date)) {
                            $started_at = Carbon::parse($date->date);
                        }
                    }
                }
            }
            if ($this->id_type == 2) {
                $started_at = Carbon::parse($this->created_at);
            }

            if (!isset($started_at)) {
                $started_at = Carbon::now();
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
            $this->users->from->and(['prices', 'games', 'abilities']);
            $this->users->from->files = $this->users->from->files;
            $this->users->to->and(['games']);
            $this->users->to->files = $this->users->to->files;
        }

        /**
         * * Change the Lesson id_status to 4.
         * @param int $id_lesson
         */
        static public function finish (int $id_lesson) {
            $lesson = Lesson::find($id_lesson);
            $reviews = Review::byLesson($lesson->id_lesson)->get();

            if (count($reviews) === 2) {
                $lesson->update([
                    'id_status' => 4,
                ]);
            }
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
            foreach (Lesson::$types as $type) {
                if ($type['id_type'] === $field || $type['slug'] === $field) {
                    return new Lesson($type);
                }
            }

            dd('Lesson type: \'$field\' not found');
        }

        /**
         * * Returns the Lesson options.
         * @param array [$types] Example: [['id_type'=>1]]
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
         * * Scope a query to only include Lessons where their id_user matches one of them.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUser ($query, int $id_user) {
            return $query->where('id_user_from', $id_user)->orwhere('id_user_to', $id_user);
        }

        /**
         * * Scope a query to only include Lessons where their id_user matches one of them.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByCoach ($query, int $id_user) {
            return $query->where([
                ['id_user_from', $id_user],
                ['id_status', '>', 1],
            ]);
        }

        /**
         * * Scope a query to only include Lessons where their id_status = 1.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeCurrent ($query) {
            return $query->where('id_status', 1);
        }

        /**
         * * Scope a query to only include Lessons where their id_user matches one of them and id_status >= 3.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeDoneByUser ($query, int $id_user) {
            return $query->where([
                ['id_user_from', $id_user],
                ['id_status', '>=', 3],
            ])->orwhere([
                ['id_user_to', $id_user],
                ['id_status', '>=', 3],
            ]);
        }

        /**
         * * Scope a query to only include Lessons where their id_user matches one of them and id_status = 3.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeStartedByUser ($query, int $id_user) {
            return $query->where([
                ['id_user_from', $id_user],
                ['id_status', 3],
            ])->orwhere([
                ['id_user_to', $id_user],
                ['id_status', 3],
            ]);
        }

        /**
         * * Scope a query to only include Lessons where their id_user matches both.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user_1
         * @param  int $id_user_2
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUsers ($query, int $id_user_1, int $id_user_2) {
            return $query->where([
                ['id_user_from', $id_user_1],
                ['id_user_to', $id_user_2],
            ])->orwhere([
                ['id_user_from', $id_user_2],
                ['id_user_to', $id_user_1],
            ]);
        }

        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            'panel' => [
                'create' => [
                    '1on1' => [
                        'rules' => [
                            'dates' => 'required',
                            'hours' => 'required',
                            'id_user_from' => 'required|exists:users,id_user',
                            'id_user_to' => 'required|exists:users,id_user',
                            'id_method' => 'required',
                            'id_type' => 'required',
                            'price' => 'required',
                            'fee' => 'required',
                            'credits' => 'required',
                        ], 'messages' => [
                            'es' => [
                                'dates.required' => 'La fecha de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.',
                                'hours.required' => 'El horario de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.',
                                'id_user_from.required' => 'El profesor es obligatorio.',
                                'id_user_from.exists' => 'El profesor no existe.',
                                'id_user_to.required' => 'El usuario es obligatorio.',
                                'id_user_to.exists' => 'El usuario no existe.',
                                'id_method.required' => 'El metodo es obligatorio.',
                                'id_type.required' => 'El tipo de clase es obligatorio.',
                                'fee.required' => 'La comisión es obligatoria.',
                                'credits.required' => 'Los créditos son obligatorios.',
                            ],
                        ],
                    ], 'seguimiento-online' => [
                        'rules' => [
                            'id_user_from' => 'required|exists:users,id_user',
                            'id_user_to' => 'required|exists:users,id_user',
                            'id_method' => 'required',
                            'id_type' => 'required',
                            'dates' => 'required',
                            'assignments' => 'required',
                            'price' => 'required',
                            'fee' => 'required',
                            'credits' => 'required',
                        ], 'messages' => [
                            'es' => [
                                'id_user_from.required' => 'El profesor es obligatorio.',
                                'id_user_from.exists' => 'El profesor no existe.',
                                'id_user_to.required' => 'El usuario es obligatorio.',
                                'id_user_to.exists' => 'El usuario no existe.',
                                'id_method.required' => 'El metodo es obligatorio.',
                                'id_type.required' => 'El tipo de clase es obligatorio.',
                                'dates.required' => 'La fecha de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.',
                                'assignments.required' => 'La cantidad de assignments es obligatoria.',
                                'fee.required' => 'La comisión es obligatoria.',
                                'credits.required' => 'Los créditos son obligatorios.',
                            ],
                        ],
                    ], 'packs' => [
                        'rules' => [
                            'dates' => 'required|array|min:4',
                            'hours' => 'required|array|min:4',
                            'id_user_from' => 'required|exists:users,id_user',
                            'id_user_to' => 'required|exists:users,id_user',
                            'id_method' => 'required',
                            'id_type' => 'required',
                            'price' => 'required',
                            'fee' => 'required',
                            'credits' => 'required',
                        ], 'messages' => [
                            'es' => [
                                'dates.required' => 'Las fechas de la clase deben ser seleccionadas. Recuerda que primero debes elegir el tipo de clase.',
                                'dates.array' => 'Las fechas deben estar en un array ([]).',
                                'dates.min' => 'Mínimo :min fechas deben ser seleccionadas.',
                                'hours.required' => 'El horario de la clase debe ser seleccionada. Recuerda que primero debes elegir el tipo de clase.',
                                'hours.array' => 'El horario deben estar en un array ([]).',
                                'hours.min' => 'Mínimo :min horas deben ser seleccionadas.',
                                'id_user_from.required' => 'El profesor es obligatorio.',
                                'id_user_from.exists' => 'El profesor no existe.',
                                'id_user_to.required' => 'El usuario es obligatorio.',
                                'id_user_to.exists' => 'El usuario no existe.',
                                'id_method.required' => 'El metodo es obligatorio.',
                                'id_type.required' => 'El tipo de clase es obligatorio.',
                                'fee.required' => 'La comisión es obligatoria.',
                                'credits.required' => 'Los créditos son obligatorios.',
                            ],
                        ],
                    ],
                ], 'delete' => [
                    'rules' => [
                        'message' => 'required|regex:/^BORRAR$/',
                    ], 'messages' => [
                        'es' => [
                            'message.required' => 'El mensaje es obligatorio.',
                            'message.regex' => 'El mensaje debe decir BORRAR.',
                        ],
                    ],
                ],
            ], 'update' => [
                'rules' => [
                    'dates' => 'required',
                    'hours' => 'required',
                ], 'messages' => [
                    'es' => [
                        'dates.required' => 'La fecha de la clase debe ser seleccionada.',
                        'hours.required' => 'El horario de la clase debe ser seleccionada.',
                    ],
                ],
            ], 'checkout' => [
                '1on1' => [
                    'rules' => [
                        'hours' => 'required',
                        'hours.*' => 'required',
                        'discord' => 'required|unique:users,discord,{id_user},id_user|regex:/([a-z])*#([0-9])*/i',
                    ], 'messages' => [
                        'es' => [
                            'hours.required' => 'El horario de la clase debe ser seleccionada.',
                            'hours.*.required' => 'No se seleccionó una hora.',
                            'discord.required' => 'El nombre de usuario de Discord es obligatorio.',
                            'discord.regex' => 'El nombre de usuario de Discord no es válido (username#0000).',
                            'discord.unique' => 'Ese nombre de usuario de Discord ya se encuentra en uso.',
                        ],
                    ],
                ], 'seguimiento-online' => [
                    'rules' => [
                        // 
                    ], 'messages' => [
                        'es' => [
                            // 
                        ],
                    ],
                ], 'packs' => [
                    'rules' => [
                        'hours' => 'required|array|min:4|max:4',
                        'hours.*' => 'required',
                        'discord' => 'required|unique:users,discord,{id_user},id_user|regex:/([a-z])*#([0-9])*/i',
                    ], 'messages' => [
                        'es' => [
                            'hours.required' => 'Las horas de la clase deben ser seleccionadas.',
                            'hours.array' => 'Las horas deben estar en un array ([]).',
                            'hours.min' => 'Mínimo :min horas deben ser seleccionadas.',
                            'hours.max' => 'Máximo :max horas deben ser seleccionadas.',
                            'hours.*.required' => 'No se seleccionó una hora.',
                            'discord.required' => 'El nombre de usuario de Discord es obligatorio.',
                            'discord.regex' => 'El nombre de usuario de Discord no es válido (username#0000).',
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
        static $types = [
            [
                'id_type' => 1,
                'name' => '1on1',
                'svg' => 'components.svg.ClaseOnline1SVG',
                'slug' => '1on1',
            ], [
                'id_type' => 2,
                'name' => 'Seguimiento Online',
                'svg' => 'components.svg.ClaseOnline2SVG',
                'slug' => 'seguimiento-online',
            ], [
                'id_type' => 3,
                'name' => 'Packs',
                'svg' => 'components.svg.ClaseOnline3SVG',
                'slug' => 'packs',
            ],
        ];
    }