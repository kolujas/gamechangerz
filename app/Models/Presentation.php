<?php
    namespace App\Models;

    use App\Models\Assignment;
    use Illuminate\Database\Eloquent\Model;

    class Presentation extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = "presentations";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_presentation";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "description", "url", "id_assignment"
        ];

        /**
         * * Set the Assignment info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "assignment":
                            $this->assignment();
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
         * * Set the Presentation Assignment.
         */
        public function assignment () {
            $this->assignment = Assignment::find($this->id_assignment);
        }

        /**
         * * Return a Presentation by the Assignment.
         * @param int $id_assignment
         * @return Presentation
         */
        static public function findByAssignment (int $id_assignment) {
            $presentation = Presentation::where("id_assignment", "=", $id_assignment)->first();

            return $presentation;
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
        ]]]];
    }