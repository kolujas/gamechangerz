<?php
    namespace App\Models;

    use App\Models\Assigment;
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
            "description", "url", "id_assigment"
        ];

        /**
         * * Set the Assigment info. 
         * @param array [$columns]
         */
        public function and (array $columns = []) {
            foreach ($columns as $column) {
                if (!is_array($column)) {
                    switch ($column) {
                        case "assigment":
                            $this->assigment();
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
         * * Set the Presentation Assigment.
         */
        public function assigment () {
            $this->assigment = Assigment::find($this->id_assigment);
        }

        /**
         * * Return a Presentation by the Assigment.
         * @param int $id_assigment
         * @return Presentation
         */
        static public function findByAssigment (int $id_assigment) {
            $presentation = Presentation::where("id_assigment", "=", $id_assigment)->first();

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
                    "url" => "required|url",
                ], "messages" => [
                    "es" => [
                        "description.required" => "La descripción es obligatoria.",
                        "description.max" => "La descripción no puede tener más de :max caracteres.",
                        "url.required" => "El link al video es obligatorio.",
                        "url.url" => "La URL debe ser valida (https://youtube.be)",
        ]]]];
    }