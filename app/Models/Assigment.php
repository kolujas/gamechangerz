<?php
    namespace App\Models;

    use App\Models\Lesson;
    use App\Models\Presentation;
    use Illuminate\Database\Eloquent\Model;

    class Assigment extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = "assigments";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_assigment";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "description", "id_lesson", "url",
        ];

        /**
         * * Set the Assigment info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "lesson":
                            $this->lesson();
                            break;
                        case "presentation":
                            $this->presentation();
                            break;
                    }
                    continue;
                }
                switch ($column[0]) {
                    default:
                        break;
                }
            }
        }

        /**
         * * Set the Assigment Lesson.
         */
        public function lesson () {
            $this->lesson = Lesson::find($this->id_lesson);
            $this->lesson->and(["chat"]);
        }

        /**
         * * Set the Assigment Presentation.
         */
        public function presentation () {
            $this->presentation = Presentation::findByAssigment($this->id_assigment);
        }

        /**
         * * Get all the Assigments from a Lesson.
         * @param int $id_lesson
         * @return Assigment[]
         */
        static public function allFromLesson (int $id_lesson) {
            $assigments = Assigment::where("id_lesson", "=", $id_lesson)->get();

            return $assigments;
        }

        /**
         * * Get a Assigment by the slug.
         * @param string $slug
         * @return Assigment
         */
        static public function findBySlug (string $slug = "") {
            $assigment = Assigment::where("slug", "=", $slug)->first();

            return $assigment;
        }
        
        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            "make" => [
                "rules" => [
                    "description" => "required|max:255",
                    "url" => "nullable|url",
                ], "messages" => [
                    "es" => [
                        "description.required" => "La descripción es obligatoria.",
                        "description.max" => "La descripción no puede tener más de :max caracteres.",
                        "url.url" => "La URL debe ser valida (https://...)",
                    ],
                ],
            ],
        ];
    }