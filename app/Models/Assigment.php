<?php
    namespace App\Models;

    use App\Models\Ability;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Assigment extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'assigments';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_assigment';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'abilities', 'description', 'id_lesson', 'slug', 'title', 'url',
        ];

        /**
         * * Get the Review Abilities.
         * @return array
         */
        public function abilities () {
            $this->abilities = Ability::parse(json_decode($this->abilities));
        }
    }