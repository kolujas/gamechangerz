<?php
    namespace App\Models;

    use App\Models\Achievements;
    use App\Models\Day;
    use App\Models\Folder;
    use App\Models\Game;
    use App\Models\Idiom;
    use App\Models\Lesson;
    use App\Models\Post;
    use App\Models\Role;
    use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;

    class User extends Authenticatable {
        use HasFactory, Notifiable;

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
                dd($file);
            }
            return $this->files;
        }

        /**
         * * Get the User Games.
         * @return array
         */
        public function games () {
            $this->games = Game::parse(json_decode($this->games));
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
            return $this->hasMany(Lesson::class, 'id_user_from', 'id_user');
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
         * * Get the User Role.
         * @return array
         */
        public function role () {
            $this->role = Role::parse(json_decode($this->id_role));
        }
    }