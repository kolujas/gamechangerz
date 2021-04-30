<?php
    namespace App\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Friend extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'friends';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_friend';

        /**
         * * Get the Friend Users.
         * @return array
         */
        public function users () {
            $this->users = [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
        }
    }