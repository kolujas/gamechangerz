<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Platform extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = "platform";
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = "id_platform";

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "dolar"
        ];

        static public function dolar () {
            $platform = Platform::find(1);
            return floatval($platform->dolar);
        }

        /** @var array Validation rules & messages. */
        static $validation = [
            "banner" => [
                "rules" => [
                    "banner" => "nullable|mimetypes:image/png",
                    "background" => "nullable|mimetypes:image/jpeg",
                ], "messages" => [
                    "es" => [
                        "banner.mimetypes" => "El banner debe ser una imagen .png",
                        "background.mimetypes" => "La foto de fondo debe ser una imagen .jpeg/jpg",
            ]]], "dolar" => [
                "rules" => [
                    "dolar" => "required",
                ], "messages" => [
                    "es" => [
                        "dolar.required" => "El valor del dolar es obligatorio",
        ]]]];
    }