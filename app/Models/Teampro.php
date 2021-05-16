<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Teampro extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'name', 'logo',
        ];

        /**
         * * Returns a Teampro.
         * @param string $data = "{\"name\":\"astralis\"}"
         * @return Teampro
         */
        static public function parse ($data = [], $user = null) {
            return new Teampro([
                'name' => (isset($data['name']) ? $data['name'] : null),
                'logo' => (isset($user->files['teampro']) ? $user->files['teampro'] : null),
            ]);
        }
    }