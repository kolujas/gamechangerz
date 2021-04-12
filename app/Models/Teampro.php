<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Teampro extends Model {
        use HasFactory;

        /** @var array Teampro options */
        static $options = [[
            'id_teampro' => 1,
            'name' => 'Astralis',
            'svg' => 'components.svg.TeamSVG',
            'slug' => 'astralis',
        ]];

        /**
         * * Check if a Teampro exists.
         * @param int $id_teampro Teampro primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_teampro) {
            $found = false;
            foreach (Teampro::$options as $teampro) {
                $teampro = (object) $teampro;
                if ($teampro->id_teampro === $id_teampro) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Teampro.
         * @param int $id_teampro Teampro primary key. 
         * @return object
         */
        static public function findOptions ($id_teampro) {
            foreach (Teampro::$options as $teampro) {
                $teampro = (object) $teampro;
                if ($teampro->id_teampro === $id_teampro) {
                    $teamproFound = $teampro;
                }
            }
            return $teamproFound;
        }
    }