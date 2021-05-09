<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Achievement extends Model {
        /** @var string Table primary key name */
        protected $primaryKey = 'id_achievement';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_achievement', 'title', 'description', 'icon', 'slug', 'slug'
        ];

        /** @var array Achievement options */
        static $options = [[
            'id_achievement' => 1,
            'title' => 'Something',
            'description' => 'Something',
            'icon' => 'something',
            'slug' => 'something',
        ], [
            'id_achievement' => 2,
            'title' => 'Something',
            'description' => 'Something',
            'icon' => 'something',
            'slug' => 'something',
        ]];

        /**
         * * Returns a Achievement.
         * @param string $field
         * @return Achievement
         */
        static public function one ($field = '') {
            foreach (Achievement::$options as $achievement) {
                $achievement = new Achievement($achievement);
                if ($achievement->id_achievement === $field) {
                    return $achievement;
                }
            }
        }

        /**
         * * Check if a Achievement exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Achievement::$options as $achievement) {
                $achievement = new Achievement($achievement);
                if ($achievement->id_achievement === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Parse a Achievements array.
         * @param array $achievementsToParse Example: "[{\"id_achievement\":1,\"abilities\":[{\"id_ability\":1,\"stars\":3.5}]}]"
         * @return Achievement[]
         * @throws
         */
        static public function parse ($achievementsToParse = []) {
            $achievements = collect([]);
            foreach ($achievementsToParse as $data) {
                if (isset($data->id_achievement) && Achievement::has($data->id_achievement)) {
                    $achievement = Achievement::one($data->id_achievement);
                    $achievements->push($achievement);
                }
                if (!isset($data->id_achievement) || !Achievement::has($data->id_achievement)) {
                    $achievement = new Achievement((array) $data);
                    $achievements->push($achievement);
                }
            }
            return $achievements;
        }
    }