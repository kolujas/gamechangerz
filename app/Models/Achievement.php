<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Achievement extends Model {
        use HasFactory;

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
         * * Check if a Achievement exists.
         * @param int $id_achievement Achievement primary key. 
         * @return boolean
         */
        static public function has ($id_achievement) {
            $found = false;
            foreach ($this->options as $achievement) {
                if ($achievement->id_achievement === $id_achievement) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Achievement.
         * @param int $id_achievement Achievement primary key. 
         * @return object
         */
        static public function find ($id_achievement) {
            foreach ($this->options as $achievement) {
                if ($achievement->id_achievement === $id_achievement) {
                    $achievementFound = $achievement;
                }
            }
            return $achievementFound;
        }

        /**
         * * Parse an Achievements array.
         * @param array $achievementsToParse Example: "[{\"name\":\"Something\",\"description\":\"Something\",\"icon\":\"trophy\"}]"
         * @return array
         */
        static public function parse ($achievementsToParse) {
            $achievements = [];
            foreach ($achievementsToParse as $achievement) {
                if ($this->has($achievement->id_achievement)) {
                    $achievements->push($this->find($achievement->id_achievement));
                } else {
                    $achievements->push($achievement);
                }
            }
            return $achievements;
        }
    }