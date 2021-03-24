<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Lesson extends Model {
        use HasFactory;

        /** @var array Lesson options */
        static $options = [[
                'id_lesson' => 1,
                'name' => 'Español',
                'svg' => 'svg/ESPSVG.svg',
                'slug' => 'espanol',
            ], [
                'id_lesson' => 2,
                'name' => 'Inglés',
                'svg' => 'svg/USASVG.svg',
                'slug' => 'ingles',
            ], [
                'id_lesson' => 3,
                'name' => 'Italiano',
                'svg' => 'svg/ITASVG.svg',
                'slug' => 'italiano',
            ], [
                'id_lesson' => 4,
                'name' => 'Portugués',
                'svg' => 'svg/BRASVG.svg',
                'slug' => 'portugues',
        ]];

        /**
         * * Check if a Lesson exists.
         * @param int $id_lesson Lesson primary key. 
         * @return boolean
         */
        static public function has ($id_lesson) {
            $found = false;
            foreach ($this->options as $lesson) {
                if ($lesson->id_lesson === $id_lesson) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Lesson.
         * @param int $id_lesson Lesson primary key. 
         * @return object
         */
        static public function find ($id_lesson) {
            foreach ($this->options as $lesson) {
                if ($lesson->id_lesson === $id_lesson) {
                    $lessonFound = $lesson;
                }
            }
            return $lessonFound;
        }

        /**
         * * Parse a Lessons array.
         * @param array $lessonsToParse Example: "[{\"id_lesson\":1}]"
         * @return array
         */
        static public function parse ($lessonsToParse) {
            $lessons = [];
            foreach ($lessonsToParse as $lesson) {
                if ($this->has($lesson->id_lesson)) {
                    $lessons->push($this->find($lesson->id_lesson));
                }
            }
            return $lessons;
        }
    }