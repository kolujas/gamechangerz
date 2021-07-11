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
         * * Parse a Teampro.
         * @param string $data Example: "{\"name\":\"astralis\"}"
         * @param User|null $user
         * @return Teampro
         */
        static public function parse (string $data, $user = null) {
            $data = json_decode($data);
            return new Teampro([
                'name' => $data->name,
                'logo' => (isset($user->files['teampro']) ? $user->files['teampro'] : null),
            ]);
        }

        /**
         * * Stringify a Games array.
         * @param string $name
         * @return string
         */
        static public function stringify (string $name = '') {
            return json_encode([
                'name' => $name,
            ]);
        }
    }