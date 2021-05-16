<?php
    namespace App\Models;

    use App\Models\Ability;
    use App\Models\Day;
    use App\Models\Folder;
    use Illuminate\Database\Eloquent\Model;

    class Lesson extends Model {
        /** @var string Table name */
        protected $table = 'lessons';
        
        /** @var string Table primary key name */
        protected $primaryKey = 'id_lesson';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_user_from', 'id_user_to', 'days', 'id_type', 'name', 'svg', 'slug',
        ];

        /** @var array Lesson options */
        static $options = [[
            'id_type' => 1,
            'name' => 'Online',
            'svg' => 'components.svg.ClaseOnline1SVG',
            'slug' => 'online',
        ], [
            'id_type' => 2,
            'name' => 'Offline',
            'svg' => 'components.svg.ClaseOnline2SVG',
            'slug' => 'offline',
        ], [
            'id_type' => 3,
            'name' => 'Packs',
            'svg' => 'components.svg.ClaseOnline3SVG',
            'slug' => 'packs',
        ]];

        /**
         * * Get the Lesson Hours.
         * @return array
         */
        public function days () {
            try {
                // $days = collect([]);
                // foreach (json_decode($this->days) as $day) {
                //     $day = (object) $day;
                //     $hour = (object) $day->hour;
                //     $hour = Hour::findOptions($hour->id_hour);
                //     $hour->active = false;
                //     $days->push([
                //         'date' => $day->date,
                //         'hour' => $hour,
                //     ]);
                // }
                // $this->days = $days;
                $this->days = Day::parse(json_decode($this->days));
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /** @var array Validation rules & messages. */
        static $validation = [
        'checkout' => [
            'online' => [
                'rules' => [
                    'dates' => 'required',
                    'hours' => 'required',
                ], 'messages' => [
                    'es' => [
                        'dates.required' => 'La fecha de la clase debe ser seleccionada.',
                        'hours.required' => 'El horario de la clase debe ser seleccionada.',
        ]]]], 'signin' => [
            'rules' => [
                //
            ], 'messages' => [
                'es' => [
                    //
        ]]]];

        /**
         * * Get the Game info. 
         * @param array $columns
         * @throws
         */
        public function and ($columns = []) {
            try {
                foreach ($columns as $column) {
                    switch ($column) {
                        case 'days':
                            $this->days();
                            break;
                    }
                }
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        /**
         * * Check if a Lesson exists.
         * @param string $field 
         * @return boolean
         */
        static public function has ($field) {
            $found = false;
            foreach (Lesson::$options as $lesson) {
                $lesson = new Lesson($lesson);
                if ($lesson->id_type === $field || $lesson->slug === $field) {
                    $found = true;
                }
            }
            return $found;
        }

        /**
         * * Returns a Lesson.
         * @param string $field
         * @return Lesson
         */
        static public function one ($field = '') {
            foreach (Lesson::$options as $lesson) {
                $lesson = new Lesson($lesson);
                if ($lesson->id_type === $field) {
                    return $lesson;
                }
            }
        }
    }