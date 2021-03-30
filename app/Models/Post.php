<?php
    namespace App\Models;

    use App\Models\User;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Post extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'posts';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_post';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'description', 'image', 'id_user', 'title', 'slug',
        ];

        /**
         * * Get the Post User.
         * @return array
         */
        public function user () {
            return $this->belongsTo(User::class, 'id_user', 'id_user');
        }
    }