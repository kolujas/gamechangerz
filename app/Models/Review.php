<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Review extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'reviews';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_review';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'title', 'description', 'abilities', 'slug,'
        ];

        /**
         * * Get the Review Abilities.
         * @return array
         */
        public function abilities () {
            $this->abilities = Ability::parse(json_decode($this->abilities));
        }

        /**
         * * Get the Review Users.
         * @return array
         */
        public function users () {
            $this->users = [
                'from' => User::find($this->id_user_from),
                'to' => User::find($this->id_user_to),
            ];
        }
    }