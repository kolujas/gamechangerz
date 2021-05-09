<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Teampro extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_teampro';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_teampro', 'name', 'svg', 'slug',
        ];

        /** @var array Teampro options */
        static $options = [[
            'id_teampro' => 1,
            'name' => 'Astralis',
            'svg' => 'components.svg.TeamSVG',
            'slug' => 'astralis',
        ]];

        /**
         * * Check if a Teampro exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Teampro::$options as $teampro) {
                $teampro = new Teampro($teampro);
                if ($teampro->id_teampro === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Returns a Teampro.
         * @param string $field
         * @return Teampro
         */
        static public function one ($field = '') {
            foreach (Teampro::$options as $teampro) {
                $teampro = new Teampro($teampro);
                if ($teampro->id_teampro === $field) {
                    return $teampro;
                }
            }
        }
    }