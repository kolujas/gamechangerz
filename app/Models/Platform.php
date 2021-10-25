<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Platform extends Model {
        /**
         * * Table name.
         * @var string
         */
        protected $table = 'platform';
        
        /**
         * * Table primary key name.
         * @var string
         */
        protected $primaryKey = 'id_platform';

        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'dolar', 'link',
        ];

        /**
         * * Scope a query to only include Platform current dolar.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeDolar ($query) {
            return $query->find(1)->dolar;
        }

        /**
         * * Scope a query to only include Platform current link.
         * @static
         * @param  \Illuminate\Database\Eloquent\Builder  $query
         * @return \Illuminate\Database\Eloquent\Builder
         */
        static public function scopeLink ($query) {
            return $query->find(1)->link;
        }

        /** @var array Validation rules & messages. */
        static $validation = [
            'banner' => [
                'rules' => [
                    'slider-1' => 'nullable|mimetypes:image/png',
                    'slider-2' => 'nullable|mimetypes:image/png',
                    'slider-3' => 'nullable|mimetypes:image/png',
                    'background' => 'nullable|mimetypes:image/pnh',
                ], 'messages' => [
                    'es' => [
                        'slider-1.mimetypes' => 'La imagen 1 del slider de la landing debe ser una imagen .png',
                        'slider-2.mimetypes' => 'La imagen 2 del slider de la landing debe ser una imagen .png',
                        'slider-3.mimetypes' => 'La imagen 3 del slider de la landing debe ser una imagen .png',
                        'background.mimetypes' => 'La foto de fondo debe ser una imagen .png',
                    ],
                ],
            ], 'info' => [
                'rules' => [
                    'dolar' => 'required',
                    'link' => 'required|regex:/^https:\/\/discord\.gg\//',
                ], 'messages' => [
                    'es' => [
                        'dolar.required' => 'El valor del dolar es obligatorio',
                        'link.required' => 'El link de Discord es obligatorio.',
                        'link.regex' => 'El link de Discord debe ser una URL válida (https://discord.gg/aaaaa).',
                    ],
                ],
            ],
        ];
    }