<?php
    namespace App\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Model;

    class Friend extends Model {
        /** @var string Table name */
        protected $table = 'friends';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_friend';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'accepted',
        ];

        /**
         * * Get the Friend Users.
         * @return array
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
         * @return boolean
         */
        static public function hasAction ($name) {
            switch (strtoupper($name)) {
                case 'ACCEPT':
                case 'CANCEL':
                case 'DELETE':
                case 'REQUEST':
                    return true;
                    break;
                default:
                    return false;
                    break;
            }
        }

        /**
         * * Get the Friend info. 
         * @param array $columns
         * @throws
         */
        public function and ($columns = []) {
            try {
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'users':
                            $this->users();
                            break;
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }