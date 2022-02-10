<?php
    namespace App\Models;

    use App\Models\Mail;
    use App\Models\User;
    use App\Notifications\FriendshipAccepted;
    use App\Notifications\FriendshipRequested;
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
         * * Set the Friend info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
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
         * * Cancel the friendship.
         * @return void
         */
        public function cancel () {
            $this->delete();
        }

        /**
         * * Get the User "from" that owns the Friend.
         * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function from () {
            return $this->belongsTo(User::class, 'id_user_from', 'id_user');
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
         * * Set the Friend Users.
         */
        public function users () {
            $this->users = (object) [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
            $this->users->from->and(['files']);
            $this->users->to->and(['files']);
        }

        /**
         * * Check if the Friend has an action.
         * @param string $name
         * @return bool
         */
        static public function hasAction (string $name) {
            switch (strtoupper($name)) {
                case 'ACCEPT':
                case 'CANCEL':
                case 'DELETE':
                case 'REQUEST':
                    return true;
                default:
                    return false;
            }
        }

        /**
         * * Scope a query to only include Abilities where their id_user matches one of them.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @param  int $id_user
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeByUser ($query, int $id_user) {
            return $query->where('id_user_from', $id_user)->orwhere('id_user_to', $id_user);
        }
    }