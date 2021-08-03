<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Achievements;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Friend;
    use App\Models\Game;
    use App\Models\Hour;
    use App\Models\Language;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\Review;
    use App\Models\Role;
    use App\Models\Teampro;
    use Cviebrock\EloquentSluggable\Sluggable;
    use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;

    class User extends Authenticatable {
        use HasApiTokens, Notifiable, Sluggable, SluggableScopeHelpers;

        /**
         * * Table name.
         * @var string
         */
        protected $table = "users";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_user";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "achievements", "credits", "date_of_birth", "days", "description", "email", "folder", "games", "id_role", "important", "languages", "lessons", "name", "password", "prices", "slug", "stars", "id_status", "teammate", "teampro", "token", "username", "credentials"
        ];

        /**
         * * The attributes that should be hidden for arrays.
         * @var array
         */
        protected $hidden = [
            "credentials", "password", "remember_token",
        ];

        /**
         * * The attributes that should be cast to native types.
         * @var array
         */
        protected $casts = [
            "email_verified_at" => "datetime",
        ];

        /**
         * * Set the User info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "abilities":
                            $this->abilities();
                            break;
                        case "achievements":
                            $this->achievements();
                            break;
                        case "credentials":
                            $this->credentials();
                            break;
                        case "days":
                            $this->days();
                            break;
                        case "files":
                            $this->files();
                            break;
                        case "friends":
                            $this->friends();
                            break;
                        case "games":
                            $this->games();
                            break;
                        case "hours":
                            $this->hours();
                            break;
                        case "languages":
                            $this->languages();
                            break;
                        case "lessons":
                            $this->lessons();
                            break;
                        case "posts":
                            $this->posts();
                            break;
                        case "prices":
                            $this->prices();
                            break;
                        case "reviews":
                            $this->reviews();
                            break;
                        case "role":
                            $this->role();
                            break;
                        case "status":
                            $this->status();
                            break;
                        case "teampro":
                            $this->teampro();
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
         * * Set the User Abilities.
         */
        public function abilities () {
            $this->reviews();
            $this->abilities = Ability::options();

            foreach ($this->abilities as $ability) {
                $quantity = 0;
                $stars = 0;

                foreach ($this->reviews as $review) {
                    foreach ($review->abilities as $reviewAbility) {
                        if ($ability->id_ability !== $reviewAbility->id_ability) {
                            continue;
                        }
                        $stars += $reviewAbility->stars;
                        $quantity++;
                    }
                }

                $ability->and([["stars", (($stars && $quantity) ? $stars / $quantity : 0)]]);
            }
        }

        /**
         * * Set the User Achievements.
         */
        public function achievements () {
            $this->achievements = Achievement::parse($this->achievements);
            if ($this->id_role === 0) {
                foreach (Achievement::options() as $achievement) {
                    // TODO: Add Achievement
                    if (false) {
                        $this->achievements->push($achievement);
                    }
                }
            }
        }

        /**
         * * Set the User Chats.
         */
        public function chats () {
            $this->chats = collect();
            foreach (Chat::allFromUser($this->id_user)->get() as $chat) {
                $this->chats->push($chat);
            }
        }

        /**
         * * Set the User Credentials.
         */
        public function credentials () {
            $credentials = Method::parse($this->credentials);
            $this->credentials = (object)[
                "mercadopago" => null,
                "paypal" => null,
            ];

            foreach ($credentials as $credential) {
                if ($credential->id_method === 1) {
                    $this->credentials->mercadopago = $credential;
                }
                if ($credential->id_method === 2) {
                    $this->credentials->paypal = $credential;
                }
            }
        }

        /**
         * * Set the User Days.
         */
        public function days () {
            $this->days = Day::parse($this->days);
        }

        /**
         * * Set the User Files.
         */
        public function files () {
            $this->files = collect();
            $files = Folder::getFiles($this->folder);

            if (!count($files)) {
                $this->files = false;
            }
            
            if (count($files)) {
                foreach ($files as $file) {
                    $fileExplode = explode(".", $file);
                    $fileExplode = explode("-", $fileExplode[0]);
                    $this->files[$fileExplode[1]] = $file;
                }
            }
        }

        /**
         * * Set the User Friends.
         */
        public function friends () {
            $this->friends = collect();

            foreach (Friend::allFromUser($this->id_user) as $friend) {
                $this->friends->push($friend);
            }
        }

        /**
         * * Set the User Games.
         */
        public function games () {
            $this->games = Game::parse($this->games);
            
            foreach ($this->games as $game) {
                $game->and(["colors", "files"]);
            }
        }

        /**
         * * Set the User Lessons.
         */
        public function hours () {
            $this->lessons();
            $this->hours = 0;

            foreach ($this->lessons as $lesson) {
                if ($lesson->id_type === 1 || $lesson->id_type === 3) {
                    if ($lesson->id_status > 2) {
                        $lesson->and(["days"]);

                        foreach ($lesson->days as $day) {
                            foreach ($day->hours as $hour) {
                                if (now() > $day->date . "T" . $hour->to) {
                                    $this->hours++;
                                }
                            }
                        }
                    }
                }
            }
        }

        /**
         * * Set the User Languages.
         */
        public function languages () {
            $this->languages = Language::parse($this->languages);
        }

        /**
         * * Set the User Lessons.
         */
        public function lessons () {
            $this->lessons = collect();
            $this->{"lessons-done"} = 0;

            if ($this->id_role === 0) {
                foreach (Lesson::allDoneFromUser($this->id_user) as $lesson) {
                    $lesson->and(["type", "users", "reviews"]);
                    if ($lesson->id_status === 4) {
                        $this->lessons->push($lesson);
                        $this->{"lessons-done"}++;
                        continue;
                    }
                    if (count($lesson->reviews)) {
                        foreach ($lesson->reviews as $review) {
                            if ($review->id_user_from === $this->id_user) {
                                $this->lessons->push($lesson);
                                $this->{"lessons-done"}++;
                                continue 2;
                            }
                        }
                    }
                }
            }
            if ($this->id_role === 1) {
                foreach (Lesson::allFromTeacher($this->id_user) as $lesson) {
                    $lesson->and(["reviews", "users", "abilities", "ended_at"]);
                    $this->lessons->push($lesson);
                    if ($lesson->id_status === 4) {
                        $this->{"lessons-done"}++;
                        continue;
                    }
                    if (count($lesson->reviews)) {
                        foreach ($lesson->reviews as $review) {
                            if ($review->id_user_from === $this->id_user) {
                                $this->{"lessons-done"}++;
                                continue 2;
                            }
                        }
                    }
                }
            }
        }

        /**
         * * Get the User Posts.
         * @return array
         */
        public function posts () {
            $this->posts = Post::allFromUser($this->id_user);
            foreach ($this->posts as $post) {
                $post->and(["user"]);
            }
        }

        /**
         * * Set the User Prices.
         */
        public function prices () {
            $this->prices = Price::parse($this->prices);
        }

        /**
         * * Set the User profile image.
         * @return string|false
         */
        public function profile () {
            foreach (Folder::getFiles($this->folder) as $file) {
                if (strpos($file, "-")) {
                    $fileExplode = explode("-", $file);
                    $fileExplode = explode(".", $fileExplode[1]);
                    if ($fileExplode[0] === "profile") {
                        return $file;
                    }
                }
            }

            return false;
        }

        /**
         * * Set the User Reviews.
         */
        public function reviews () {
            $this->reviews = collect();
            
            foreach (Review::allToUser($this->id_user) as $review) {
                $review->and(["abilities", "lesson", "game"]);
                $this->reviews->push($review);
            }
        }

        /**
         * * Set the User Role.
         */
        public function role () {
            $this->role = Role::option($this->id_role);
        }
        
        /**
         * * The Sluggable configuration for the Model.
         * @return array
         */
        public function sluggable (): array {
            return [
                "slug" => [
                    "source"	=> "username",
                    "onUpdate"	=> true,
                ]
            ];
        }

        /**
         * * Set the User status.
         */
        public function status () {
            switch ($this->id_status) {
                case 0:
                    $this->status = (object) [
                        "id_status" => 0,
                        "name" => "Banned",
                    ];
                    break;
                case 1:
                    $this->status = (object) [
                        "id_status" => 1,
                        "name" => "Email confirmation pending",
                    ];
                    break;
                case 2:
                    $this->status = (object) [
                        "id_status" => 2,
                        "name" => "Available",
                    ];
                    break;
            }
        }

        /**
         * * Set the User Teampro.
         */
        public function teampro () {
            $this->teampro = Teampro::parse($this->teampro, $this);
        }

        /**
         * * Get all the Users with id_role = 2.
         * @return User[]
         */
        static public function allAdmins () {
            $users = User::where("id_role", "=", 2)->orderBy("updated_at")->get();

            return $users;
        }

        /**
         * * Get all the Users with id_role = 1.
         * @param boolean [$paginate=false]
         * @return User[]
         */
        static public function allTeachers ($paginate = false) {
            if (!$paginate) {
                $users = User::where("id_role", "=", 1)->orderBy("updated_at")->get();
            }
            if ($paginate) {
                $users = User::where("id_role", "=", 1)->orderBy("updated_at")->paginate(5);
            }

            return $users;
        }

        /**
         * * Get all the Users with id_role = 0.
         * @param boolean [$paginate=false]
         * @return User[]
         */
        static public function allUsers ($paginate = false) {
            if (!$paginate) {
                $users = User::where("id_role", "=", 0)->orderBy("updated_at")->get();
            }
            if ($paginate) {
                $users = User::where("id_role", "=", 0)->orderBy("updated_at")->paginate(5);
            }

            return $users;
        }

        /**
         * * Get a User by the email.
         * @param string $email
         * @return User
         */
        static public function findByEmail (string $email = "") {
            $user = User::where("email", "=", $email)->first();

            return $user;
        }

        /**
         * * Get all the Users by a Game.
         * @param int $id_game
         * @return User[]
         */
        static public function allByGame (int $id_game, $id_role = false) {
            $users = collect();

            foreach (User::orderBy("stars", "DESC")->orderBy("username", "ASC")->orderBy("important", "DESC")->orderBy("updated_at", "DESC")->get() as $user) {
                if ($id_role && $user->id_role === $id_role) {
                    $user->and(["games"]);

                    foreach ($user->games as $game) {
                        if ($game->id_game === $id_game) {
                            $users->push($user);
                        }
                    }
                }
                if (!$id_role) {
                    $user->and(["games"]);

                    foreach ($user->games as $game) {
                        if ($game->id_game === $id_game) {
                            $users->push($user);
                        }
                    }
                }
            }

            return $users;
        }

        /**
         * * Get a User by the slug.
         * @param string $slug
         * @return User
         */
        static public function findBySlug (string $slug = "") {
            $user = User::where("slug", "=", $slug)->first();

            return $user;
        }

        /**
         * * Set the Users with id_role = 1.
         * @return User[]
         */
        static public function teachers () {
            $users = User::where("id_role", "=", 1)->get();

            return $users;
        }

        /**
         * * Set the Users with id_role = 0.
         * @return User[]
         */
        static public function users () {
            $users = User::where([
                ["id_role", "=", 0],
                ["id_status", ">", 1],
            ])->get();

            return $users;
        }

        /**
         * * Requilify the User by the Reviews or the Games.
         * @param int $id_user
         */
        static public function requilify (int $id_user) {
            $user = User::find($id_user);

            if ($user->id_role === 1) {
                $reviews = Review::allToUser($id_user);

                $stars = 0;
                $quantity = 0;
                foreach ($reviews as $review) {
                    $stars += floatval($review->stars);
                    $quantity++;
                }

                $user->update([
                    "stars" => ($stars ? $stars / $quantity : 0),
                ]);
            }
            if ($user->id_role === 0) {
                $games = Game::requilify($user->id_user, $user->games);

                $user->update([
                    "games" => $games,
                ]);

                $stars = 0;
                $quantity = 0;
                foreach (json_decode($games) as $game) {
                    $stars += floatval($game->stars);
                    $quantity++;
                }

                $user->update([
                    "stars" => ($stars ? $stars / $quantity : 0),
                ]);
            }
        }
        
        /** @var array Validation rules & messages. */
        static $validation = [
            "user" => [
                "panel" => [
                    "create" => [
                        "rules" => [
                            "username" => "required|unique:users|max:25",
                            "email" => "required|email|unique:users|regex:/^([a-z0-9\.\_])*@gmail\.com(\.[a-z]*)?$/i",
                            "password" => "required",
                            "name" => "nullable|max:25",
                            "profile" => "nullable|mimetypes:image/png,image/jpeg",
                            "banner" => "nullable|mimetypes:image/png,image/jpeg",
                            "languages" => "required",
                        ], "messages" => [
                            "es" => [
                                "username.required" => "El apodo es obligatorio.",
                                "username.unique" => "Ese apodo ya esta en uso.",
                                "username.max" => "El apodo no puede tener más de :max caracteres.",
                                "email.required" => "El correo es obligatorio.",
                                "email.email" => "El correo debe ser formato mail (ejemplo@gmail.com).",
                                "email.unique" => "Ese correo ya se encuentra en uso.",
                                "email.regex" => "El correo debe ser gmail (ejemplo@gmail.com).",
                                "password.required" => "La contraseña es obligatoria.",
                                "name.max" => "El nombre no puede tener más de :max caracteres.",
                                "profile.mimetypes" => "La foto de perfil debe ser una imagen .jpeg/jpg o .png",
                                "banner.mimetypes" => "La foto del banner debe ser una imagen .jpeg/jpg o .png",
                                "languages.required" => "Al menos 1 idioma es obligatorio.",
                            ]
                        ]
                    ],
                    "delete" => [
                        "rules" => [
                            "message" => "required|regex:/^BORRAR$/",
                        ], "messages" => [
                            "es" => [
                                "message.required" => "El mensaje es obligatorio.",
                                "message.regex" => "El mensaje debe decir BORRAR.",
                            ]
                        ]
                    ],
                    "update" => [
                        "rules" => [
                            "username" => "required|unique:users,username,{id_user},id_user|max:25",
                            "email" => "required|email|unique:users,username,{id_user},id_user|regex:/^([a-z0-9\.\_])*@gmail\.com(\.[a-z]*)?$/i",
                            "name" => "nullable|max:25",
                            "profile" => "nullable|mimetypes:image/png,image/jpeg",
                            "banner" => "nullable|mimetypes:image/png,image/jpeg",
                            "languages" => "required",
                        ], "messages" => [
                            "es" => [
                                "username.required" => "El apodo es obligatorio.",
                                "username.unique" => "Ese apodo ya esta en uso.",
                                "username.max" => "El apodo no puede tener más de :max caracteres.",
                                "email.required" => "El correo es obligatorio.",
                                "email.email" => "El correo debe ser formato mail (ejemplo@gmail.com).",
                                "email.unique" => "Ese correo ya se encuentra en uso.",
                                "email.regex" => "El correo debe ser gmail (ejemplo@gmail.com).",
                                "name.max" => "El nombre no puede tener más de :max caracteres.",
                                "profile.mimetypes" => "La foto de perfil debe ser una imagen .jpeg/jpg o .png",
                                "banner.mimetypes" => "La foto del banner debe ser una imagen .jpeg/jpg o .png",
                                "languages.required" => "Al menos 1 idioma es obligatorio.",
                            ]
                        ]
                    ],
                ],
                "update" => [
                    "rules" => [
                        "username" => "required|unique:users,username,{id_user},id_user|max:25",
                        "name" => "nullable|max:25",
                        "profile" => "nullable|mimetypes:image/png,image/jpeg",
                        "banner" => "nullable|mimetypes:image/png,image/jpeg",
                        "languages" => "required",
                    ], "messages" => [
                        "es" => [
                            "username.required" => "El apodo es obligatorio.",
                            "username.unique" => "Ese apodo ya esta en uso.",
                            "username.max" => "El apodo no puede tener más de :max caracteres.",
                            "name.max" => "El nombre no puede tener más de :max caracteres.",
                            "profile.mimetypes" => "La foto de perfil debe ser una imagen .jpeg/jpg o .png",
                            "banner.mimetypes" => "La foto del banner debe ser una imagen .jpeg/jpg o .png",
            ]]]], "teacher" => [
                "panel" => [
                    "create" => [
                        "rules" => [
                            "username" => "required|unique:users,username,{id_user},id_user|max:25",
                            "email" => "required|email|unique:users|regex:/^([a-z0-9\.\_])*@gmail\.com(\.[a-z]*)?$/i",
                            "password" => "required",
                            "name" => "required|max:25",
                            "description" => "nullable|max:255",
                            "teampro_name" => "required|max:25",
                            "teampro_logo" => "required|mimetypes:image/png",
                            "profile" => "required|mimetypes:image/png",
                            "abilities" => "required",
                            "languages" => "required",
                            "id_status" => "required",
                            "mp_access_token" => "required",
                        ], "messages" => [
                            "es" => [
                                "username.required" => "El apodo es obligatorio.",
                                "username.unique" => "Ese apodo ya esta en uso.",
                                "username.max" => "El apodo no puede tener más de :max caracteres.",
                                "email.required" => "El correo es obligatorio.",
                                "email.email" => "El correo debe ser formato mail (ejemplo@gmail.com).",
                                "email.unique" => "Ese correo ya se encuentra en uso.",
                                "email.regex" => "El correo debe ser gmail (ejemplo@gmail.com).",
                                "password.required" => "La contraseña es obligatoria.",
                                "name.required" => "El nombre es obligatorio.",
                                "name.max" => "El nombre no puede tener más de :max caracteres.",
                                "description.max" => "La descripción no puede tener más de :max caracteres.",
                                "teampro_name.required" => "El nombre del equipo es obligatorio.",
                                "teampro_name.max" => "El nombre del equipo no puede tener más de :max caracteres.",
                                "teampro_logo.required" => "La foto del equipo es obligatoria.",
                                "teampro_logo.mimetypes" => "La foto del equipo debe ser una imagen .png",
                                "profile.required" => "La foto de perfil es obligatoria.",
                                "profile.mimetypes" => "La foto de perfil debe ser una imagen .png",
                                "abilities.required" => "Al menos 1 Habilidad es obligatoria.",
                                "languages.required" => "Al menos 1 idioma es obligatorio.",
                                "id_status.required" => "El estado es obligatorio.",
                                "mp_access_token.required" => "El access token de MercadoPago es obligatorio.",
                            ]
                        ]
                    ],
                    "delete" => [
                        "rules" => [
                            "message" => "required|regex:/^BORRAR$/",
                        ], "messages" => [
                            "es" => [
                                "message.required" => "El mensaje es obligatorio.",
                                "message.regex" => "El mensaje debe decir BORRAR.",
                            ]
                        ]
                    ],
                    "update" => [
                        "rules" => [
                            "username" => "required|unique:users,username,{id_user},id_user|max:25",
                            "email" => "required|email|unique:users,email,{id_user},id_user|regex:/^([a-z0-9\.\_])*@gmail\.com(\.[a-z]*)?$/i",
                            "name" => "required|max:25",
                            "description" => "nullable|max:255",
                            "teampro_name" => "required|max:25",
                            "teampro_logo" => "nullable|mimetypes:image/png",
                            "profile" => "nullable|mimetypes:image/png",
                            "abilities" => "required",
                            "languages" => "required",
                            "id_status" => "required",
                            "mp_access_token" => "required",
                        ], "messages" => [
                            "es" => [
                                "username.required" => "El apodo es obligatorio.",
                                "username.unique" => "Ese apodo ya esta en uso.",
                                "username.max" => "El apodo no puede tener más de :max caracteres.",
                                "email.required" => "El correo es obligatorio.",
                                "email.email" => "El correo debe ser formato mail (ejemplo@gmail.com).",
                                "email.unique" => "Ese correo ya se encuentra en uso.",
                                "email.regex" => "El correo debe ser gmail (ejemplo@gmail.com).",
                                "name.required" => "El nombre es obligatorio.",
                                "name.max" => "El nombre no puede tener más de :max caracteres.",
                                "description.max" => "La descripción no puede tener más de :max caracteres.",
                                "teampro_name.required" => "El nombre del equipo es obligatorio.",
                                "teampro_name.max" => "El nombre del equipo no puede tener más de :max caracteres.",
                                "teampro_logo.mimetypes" => "La foto del equipo debe ser una imagen .png",
                                "profile.mimetypes" => "La foto de perfil debe ser una imagen .png",
                                "abilities.required" => "Al menos 1 Habilidad es obligatoria.",
                                "languages.required" => "Al menos 1 idioma es obligatorio.",
                                "id_status.required" => "El estado es obligatorio.",
                                "mp_access_token.required" => "El access token de MercadoPago es obligatorio.",
                            ]
                        ]
                    ],
                ],
                "update" => [
                    "rules" => [
                        "username" => "required|unique:users,username,{id_user},id_user|max:25",
                        "name" => "required|max:25",
                        "description" => "nullable|max:255",
                        "teampro_name" => "required|max:25",
                        "teampro_logo" => "nullable|mimetypes:image/png",
                        "profile" => "nullable|mimetypes:image/png",
                        // "prices" => "required",
                        // "hours" => "required",
                    ], "messages" => [
                        "es" => [
                            "username.required" => "El apodo es obligatorio.",
                            "username.unique" => "Ese apodo ya esta en uso.",
                            "username.max" => "El apodo no puede tener más de :max caracteres.",
                            "name.required" => "El nombre es obligatorio.",
                            "name.max" => "El nombre no puede tener más de :max caracteres.",
                            "description.max" => "La descripción no puede tener más de :max caracteres.",
                            "teampro_name.required" => "El nombre de tu equipo es obligatorio.",
                            "teampro_name.max" => "El nombre de tu equipo no puede tener más de :max caracteres.",
                            "teampro_logo.mimetypes" => "La foto de tu equipo debe ser una imagen .png",
                            "profile.mimetypes" => "La foto de perfil debe ser una imagen .png",
        ]]]]];
    }