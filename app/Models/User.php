<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Achievements;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Friend;
    use App\Models\Game;
    use App\Models\Idiom;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\Review;
    use App\Models\Role;
    use App\Models\Teampro;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Passport\HasApiTokens;

    class User extends Authenticatable {
        use HasApiTokens, HasFactory, Notifiable;

        /** @var string Table name */
        protected $table = 'users';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_user';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'achievements', 'date_of_birth', 'description', 'email', 'folder', 'games', 'id_role', 'id_teampro', 'idioms', 'lessons', 'name', 'password', 'price', 'slug', 'teammate', 'username', 'video',
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
                    'source'	=> 'name',
                    'onUpdate'	=> true,
                ]
            ];
        }

        /**
         * * Get the User Abilities.
         * @return array
         */
        public function abilities () {
            $abilities = [['id_ability' => 1, 'stars' => 0],['id_ability' => 2, 'stars' => 0],['id_ability' => 3, 'stars' => 0],['id_ability' => 4, 'stars' => 0]];
            $this->abilities = Ability::parse($abilities);
        }

        /**
         * * Get the User Achievements.
         * @return array
         */
        public function achievements () {
            $this->achievements = Achievement::parse(json_decode($this->achievements));
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
         * @return array
         */
        public function days () {
            $this->days = Day::parse(json_decode($this->days));
        }

        /**
         * * Get the User Files.
         * @return array
         */
        public function files () {
            $files = Folder::getFiles($this->folder);
            $this->files = collect([]);
            foreach ($files as $file) {
                if (strpos($file, '-')) {
                    $fileExplode = explode('-', $file);
                    $fileExplode = explode('.', $fileExplode[1]);
                    $this->files->push([$fileExplode[0] => $file]);
                } else {
                    $this->files->push($file);
                }
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
         * @return array
         */
        public function games () {
            $this->games = Game::parse(json_decode($this->games));
        }

        /**
         * * Get the User hours.
         * @return array
         */
        public function hours () {
            $this->hours = 0;
            foreach ($this->lessons as $lesson) {
                foreach (json_decode($lesson->days) as $day) {
                    $day = (object) $day;
                    if (Hour::hasOptions($day->hour->id_hour)) {
                        $hour = Hour::findOptions($day->hour->id_hour);
                        if (now() > $day->date . "T" . $hour->to) {
                            $this->hours++;
                        }
                    }
                }
            }
        }

        /**
         * * Get the User Idioms.
         * @return array
         */
        public function idioms () {
            $this->idioms = Idiom::parse(json_decode($this->idioms));
        }

        /**
         * * Get the User Lessons.
         * @return array
         */
        public function lessons () {
            $this->lessons = collect([]);
            foreach (Lesson::where('id_user_from', '=', $this->id_user)->get() as $friend) {
                $this->lessons->push($friend);
            }
            foreach (Lesson::where('id_user_to', '=', $this->id_user)->get() as $friend) {
                $this->lessons->push($friend);
            }
        }

        /**
         * * Get the User Posts.
         * @return array
         */
        public function posts () {
            return $this->hasMany(Post::class, 'id_user', 'id_user');
        }

        /**
         * * Get the User Role.
         * @return array
         */
        public function prices () {
            $this->prices = Price::parse(json_decode($this->prices));
        }

        /**
         * * Get the User Reviews.
         * @return array
         */
        public function reviews () {
            return $this->hasMany(Review::class, 'id_user_to', 'id_user');
        }

        /**
         * * Get the User Role.
         * @return array
         */
        public function role () {
            $this->role = Role::parse(json_decode($this->id_role));
        }

        /**
         * * Get the User Teampro.
         * @return array
         */
        public function teampro () {
            if (Teampro::hasOptions($this->id_teampro)) {
                $this->teampro = Teampro::findOptions($this->id_teampro);
            }
        }
    }