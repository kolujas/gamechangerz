<?php
    namespace App\Models;

    use App\Models\Chat;
    use App\Models\Mail;
    use App\Models\User;
    use App\Notifications\FriendshipAccepted;
    use App\Notifications\FriendshipRequested;
    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;

    class Friend extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'friends';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_friend';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'accepted', 'id_user_from', 'id_user_to',
        ];

        /**
         * * Accept the friendship.
         * @return void
         */
        public function accept () {
            $this->from->notify(new FriendshipAccepted([
                'id_friend' => $this->attributes['id_friend'],
                'to' => $this->to,
            ]));

            $this->update([
                'accepted' => 1,
            ]);
        }

        /**
         * * Cancel the friendship.
         * @return void
         */
        public function cancel () {
            $this->delete();
        }

        /**
         * * Get the Chat that owns the Friend.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function chat () {
            return $this->belongsTo(Chat::class, 'id_user_from', 'id_user_from')->where('id_user_to', $this->attributes['id_user_to']);
        }

        /**
         * * Get the User "from" that owns the Friend.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function from () {
            return $this->belongsTo(User::class, 'id_user_from', 'id_user');
        }

        /**
         * * Creates the Friend Chat.
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
         * * Get the User who is not the specified.
         * @param int $id_user
         * @return \App\Models\User
         */
        public function not (int $id_user) {
            if ($id_user == $this->attributes['id_user_from']) {
                return $this->to;
            } else {
                return $this->from;
            }
        }

        /**
         * * Notify the friendship request.
         * @return void
         */
        public function notify () {
            $this->to->notify(new FriendshipRequested([
                'id_friend' => $this->attributes['id_friend'],
                'from' => $this->from,
            ]));

            new Mail([ 'id_mail' => 6, ], [
                'email_to' => $this->from->email,
                'name' => $this->from->name,
                'slug' => $this->from->slug,
                'username' => $this->from->username,
            ]);
        }

        /**
         * * Get the User "to" that owns the Friend.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function to () {
            return $this->belongsTo(User::class, 'id_user_to', 'id_user');
        }

        /**
         * * Get all of the Users for the Friend.
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function users () {
            return $this->hasMany(User::class, 'id_user', 'id_user_from')->orwhere('id_user', $this->attributes['id_user_to']);
        }

        /**
         * * Scope a query to only include Friends where their id_user matches one of them.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUser ($query, int $id_user) {
            return $query->where('id_user_from', $id_user)->orwhere('id_user_to', $id_user);
        }
    }