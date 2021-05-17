<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Achievements;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Friend;
    use App\Models\Game;
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

        /** @var string Table name */
        protected $table = 'users';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_user';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'achievements', 'date_of_birth', 'description', 'email', 'folder', 'games', 'id_role', 'teampro', 'languages', 'lessons', 'name', 'password', 'prices', 'slug', 'teammate', 'username', 'video', 'important', 'stars', 'days',
        ];

        /**
         * * The attributes that should be hidden for arrays.
         * @var array
         */
        protected $hidden = [
            'password',
            'remember_token',
        ];

        /**
         * * The attributes that should be cast to native types.
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];
        
        /**
         * * The Sluggable configuration for the Model.
         * @return array
         */
        public function sluggable () {
            return [
                'slug' => [
                    'source'	=> 'username',
                    'onUpdate'	=> true,
                ]
            ];
        }

        /**
         * * Get the User Posts.
         * @return array
         */
        public function posts () {
            return $this->hasMany(Post::class, 'id_user', 'id_user');
        }

        /**
         * * Get the User Reviews.
         * @return array
         */
        public function reviews () {
            return $this->hasMany(Review::class, 'id_user_to', 'id_user');
        }

        /**
         * * Get the Game info. 
         * @param array $columns
         * @throws
         */
        public function and ($columns = []) {
            try {
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'abilities':
                            $this->abilities();
                            break;
                        case 'achievements':
                            $this->achievements();
                            break;
                        case 'days':
                            $this->days();
                            break;
                        case 'files':
                            $this->files();
                            break;
                        case 'friends':
                            $this->friends();
                            break;
                        case 'games':
                            $this->games();
                            break;
                        case 'hours':
                            $this->hours();
                            break;
                        case 'languages':
                            $this->languages();
                            break;
                        case 'lessons':
                            $this->lessons();
                            break;
                        case 'prices':
                            $this->prices();
                            break;
                        case 'role':
                            $this->role();
                            break;
                        case 'teampro':
                            $this->teampro();
                            break;
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Abilities.
         * @return array
         */
        public function abilities () {
            $abilities = [
                (object) ['id_ability' => 1, 'stars' => 0],
                (object) ['id_ability' => 2, 'stars' => 0],
                (object) ['id_ability' => 3, 'stars' => 0],
                (object) ['id_ability' => 4, 'stars' => 0]
            ];
            $this->abilities = Ability::parse($abilities);
        }

        /**
         * * Get the User Achievements.
         * @throws
         */
        public function achievements () {
            try {
                $this->achievements = Achievement::parse(json_decode($this->achievements));
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Chats.
         * @return array
         */
        public function chats () {
            $this->chats = collect([]);
            foreach (Chat::where('id_user_from', '=', $this->id_user)->get() as $chat) {
                $this->chats->push($chat);
            }
            foreach (Chat::where('id_user_to', '=', $this->id_user)->get() as $chat) {
                $this->chats->push($chat);
            }
            $this->chats->sort(function ($a, $b) {
                return ($a->updated_at < $b->updated_at) ? -1 : 1;
            });
        }

        /**
         * * Get the User Days.
         * @throws
         */
        public function days () {
            try {
                $days = json_decode($this->days);
                foreach ($days as $day) {
                    if (!is_array($day->hours)) {
                        $day->hours = json_decode($day->hours);
                    }
                }
                $this->days = Day::parse($days);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Files.
         * @return array
         */
        
        public function files () {
            try {
                $this->files = collect([]);
                $files = Folder::getFiles($this->folder);
                if (!count($files)) {
                    $this->files = false;
                }
                foreach ($files as $file) {
                    if (strpos($file, '-')) {
                        $fileExplode = explode('-', $file);
                        $fileExplode = explode('.', $fileExplode[1]);
                        $this->files[$fileExplode[0]] = $file;
                        $files[$fileExplode[0]] = $file;
                    } else {
                        $this->files->push($file);
                        $files->push($file);
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Friends.
         * @return array
         */
        public function friends () {
            $this->friends = collect([]);
            foreach (Friend::where('id_user_from', '=', $this->id_user)->get() as $friend) {
                $this->friends->push($friend);
            }
            foreach (Friend::where('id_user_to', '=', $this->id_user)->get() as $friend) {
                $this->friends->push($friend);
            }
        }

        /**
         * * Get the User Games.
         * @throws
         */
        public function games () {
            try {
                $this->games = Game::parse(json_decode($this->games));
                foreach ($this->games as $game) {
                    $game->and(['abilities']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Lessons.
         * @return array
         */
        public function hours () {
            $this->hours = 0;
            foreach ($this->lessons as $lesson) {
                if ($lesson->id_type === 1 || $lesson->id_type === 3) {
                    foreach (json_decode($lesson->days) as $day) {
                        if (Hour::has($day->hour->id_hour)) {
                            $hour = Hour::one($day->hour->id_hour);
                            if (now() > $day->date . "T" . $hour->to) {
                                $this->hours++;
                            }
                        }
                    }
                }
            }
        }

        /**
         * * Get the User Languages.
         * @throws
         */
        public function languages () {
            try {
                $this->languages = Language::parse(json_decode($this->languages));
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Lessons.
         * @return array
         */
        public function lessons () {
            $this->lessons = collect([]);
            if ($this->id_role === 0) {
                foreach (Lesson::where('id_user_to', '=', $this->id_user)->get() as $lesson) {
                    if ($lesson->id_type === 1) {
                        $lesson->hours = 0;
                        foreach (json_decode($lesson->days) as $day) {
                            if (Hour::has($day->hour->id_hour)) {
                                $hour = Hour::one($day->hour->id_hour);
                                if (now() > $day->date . "T" . $hour->to) {
                                    $lesson->hours++;
                                }
                            }
                        }
                    }
                    $this->lessons->push($lesson);
                }
            }
            if ($this->id_role === 1) {
                foreach (Lesson::where('id_user_from', '=', $this->id_user)->get() as $lesson) {
                    if ($lesson->id_type === 1) {
                        $lesson->hours = 0;
                        foreach (json_decode($lesson->days) as $day) {
                            if (Hour::has($day->hour->id_hour)) {
                                $hour = Hour::one($day->hour->id_hour);
                                if (now() > $day->date . "T" . $hour->to) {
                                    $lesson->hours++;
                                }
                            }
                        }
                    }
                    $this->lessons->push($lesson);
                }
            }
        }

        /**
         * * Get the User Prices.
         * @throws
         */
        public function prices () {
            try {
                $this->prices = Price::parse(json_decode($this->prices));
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User profile image.
         * @throws
         */
        public function profile () {
            try {
                foreach (Folder::getFiles($this->folder) as $file) {
                    if (strpos($file, '-')) {
                        $fileExplode = explode('-', $file);
                        $fileExplode = explode('.', $fileExplode[1]);
                        if ($fileExplode[0] === 'profile') {
                            return $file;
                        }
                    }
                }
                return false;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Role.
         * @return array
         */
        public function role () {
            try {
                if (!Role::has($this->id_role)) {
                    throw (object)[
                        'code' => 404,
                        'message' => "Role with id = \"$this->id_role\" does not exist",
                    ];
                }
                $this->role = Role::one($this->id_role);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Get the User Teampro.
         * @throws
         */
        public function teampro () {
            try {
                $this->teampro = Teampro::parse((array) json_decode($this->teampro), $this);
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Fidn and returns the User by a Game.
         * @param ine $id_game
         * @return User[]
         * @throws
         */
        static public function findByGame ($id_game = '', $id_role = false) {
            try {
                $users = collect([]);
                $usersToSearch = User::orderBy('stars', 'DESC')->orderBy('username', 'ASC')->orderBy('important', 'DESC')->orderBy('updated_at', 'DESC')->get();
                foreach ($usersToSearch as $user) {
                    if ($id_role && $user->id_role === $id_role) {
                        $user->and(['games']);
                        foreach ($user->games as $game) {
                            if ($game->id_game === $id_game) {
                                $users->push($user);
                            }
                        }
                    }
                    if (!$id_role) {
                        $user->and(['games']);
                        foreach ($user->games as $game) {
                            if ($game->id_game === $id_game) {
                                $users->push($user);
                            }
                        }
                    }
                }
                return $users;
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        
        /** @var array Validation rules & messages. */
        static $validation = [
            'user' => [
                'update' => [
                    'rules' => [
                        'username' => 'required|unique:users,username,{id_user},id_user|max:25',
                        'name' => 'max:25',
                        // 'profile' => 'mimetype:image/png,image/jpeg',
                        // 'banner' => 'mimetype:image/png,image/jpeg',
                    ], 'messages' => [
                        'es' => [
                            'username.required' => 'El apodo es obligatorio.',
                            'username.unique' => 'Ese apodo ya esta en uso.',
                            'username.max' => 'El apodo no puede tener más de :max caracteres.',
                            'name.max' => 'El nombre no puede tener más de :max caracteres.',
            ]]]], 'teacher' => [
                'update' => [
                    'rules' => [
                        'username' => 'required|unique:users,username,{id_user},id_user|max:25',
                        'name' => 'required|max:25',
                        'description' => 'max:255',
                        'teampro_name' => 'required|max:25',
                        // 'teampro_logo' => 'required|mimetype:image/png,image/jpeg',
                        // 'prices' => 'required',
                        // 'hours' => 'required',
                    ], 'messages' => [
                        'es' => [
                            'username.required' => 'El apodo es obligatorio.',
                            'username.unique' => 'Ese apodo ya esta en uso.',
                            'username.max' => 'El apodo no puede tener más de :max caracteres.',
                            'name.required' => 'El nombre es obligatorio.',
                            'name.max' => 'El nombre no puede tener más de :max caracteres.',
                            'description.max' => 'La descripción no puede tener más de :max caracteres.',
                            'teampro_name.required' => 'El nombre de tu equipo es obligatorio.',
                            'teampro_name.max' => 'El nombre de tu equipo no puede tener más de :max caracteres.',
        ]]]]];

       /**
        * * Replace the unique {id_user} rule.
        * @param mixed $rules Rules to replace.
        * @param mixed $id_user User primary key to put.
        * @return string
        */
        static function replaceUniqueIDUser ($rules, $id_user) {
            return preg_replace("({[a-z_]*})", $id_user, $rules);
        }
    }