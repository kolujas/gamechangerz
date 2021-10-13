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
            "dolar",
            "link",
        ];

        /**
         * * Get the Platform dolar
         * @return int
         */
        static public function dolar () {
            $platform = Platform::find(1);
            return floatval($platform->dolar);
        }

        /**
         * * Get the Platform discord link
         * @return string
         */
        static public function link () {
            $platform = Platform::find(1);
            return $platform->link;
        }

        /** @var array Validation rules & messages. */
        static $validation = [
            "banner" => [
                "rules" => [
                    "slider-1" => "nullable|mimetypes:image/png",
                    "slider-2" => "nullable|mimetypes:image/png",
                    "slider-3" => "nullable|mimetypes:image/png",
                    "background" => "nullable|mimetypes:image/pnh",
                ], "messages" => [
                    "es" => [
                        "slider-1.mimetypes" => "La imagen 1 del slider de la landing debe ser una imagen .png",
                        "slider-2.mimetypes" => "La imagen 2 del slider de la landing debe ser una imagen .png",
                        "slider-3.mimetypes" => "La imagen 3 del slider de la landing debe ser una imagen .png",
                        "background.mimetypes" => "La foto de fondo debe ser una imagen .png",
                    ],
                ],
            ], "info" => [
                "rules" => [
                    "dolar" => "required",
                    "link" => "required|regex:/^https:\/\/discord\.gg\//",
                ], "messages" => [
                    "es" => [
                        "dolar.required" => "El valor del dolar es obligatorio",
                        "link.required" => "El link de Discord es obligatorio.",
                        "link.regex" => "El link de Discord debe ser una URL válida (https://discord.gg/aaaaa).",
                    ],
                ],
            ],
        ];
    }