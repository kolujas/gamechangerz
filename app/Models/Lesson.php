<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Lesson extends Model {
        use HasFactory;

        /** @var string Table name */
        protected $table = 'lessons';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_lesson';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'date', 'hours',
        ];

        /** @var array Lesson options */
        static $options = [[
                'id_type' => 1,
                'name' => 'Online',
                'svg' => 'svg/ClaseOnline1SVG.svg',
                'slug' => 'online',
            ], [
                'id_type' => 2,
                'name' => 'Offline',
                'svg' => 'svg/ClaseOnline1SVG.svg',
                'slug' => 'offline',
            ], [
                'id_type' => 3,
                'name' => 'Packs',
                'svg' => 'svg/ClaseOnline3SVG.svg',
                'slug' => 'packs',
        ]];

        /**
         * * Check if a Price exists.
         * @param int $id_type Price primary key. 
         * @return boolean
         */
        static public function hasOptions ($id_type) {
            $found = false;
            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->id_type === $id_type) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Find a Lesson option.
         * @param int $id_type Price primary key. 
         * @return object
         */
        static public function findOptions ($id_type) {
            foreach (Lesson::$options as $lesson) {
                $lesson = (object) $lesson;
                if ($lesson->id_type === $id_type) {
                    $lessonFound = $lesson;
                }
            }
            return $lessonFound;
        }

        /**
         * * Get the Lesson Hours.
         * @return array
         */
        public function hours () {
            $this->hours = Hour::parse(json_decode($this->hours), false);
        }
    }