<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Auth extends Model {
        /**
         * * Validation rules & messages.
         * @static
         * @var array
         */
        static $validation = [
            'login' => [
                'rules' => [
                    'data' => 'required',
                    'password' => 'required',
                ], 'messages' => [
                    'es' => [
                        'data.required' => 'El correo o el apodo son obligatorios.',
                        'password.required' => 'La contraseña es obligatoria.',
                    ],
                ],
            ], 'signin' => [
                'rules' => [
                    'username' => 'required|unique:users',
                    'discord' => 'nullable|unique:users|regex:/([a-z])*#([0-9])*/i',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed',
                    'date' => 'nullable|date',
                    'language' => 'required',
                    'accept' => 'required',
                ], 'messages' => [
                    'es' => [
                        'username.required' => 'El apodo es obligatorio.',
                        'username.unique' => 'Ese apodo ya se encuentra en uso.',
                        'discord.regex' => 'El nombre de usuario de Discord no es válido (username#0000).',
                        'discord.unique' => 'Ese nombre de usuario de Discord ya se encuentra en uso.',
                        'email.required' => 'El correo es obligatorio.',
                        'email.email' => 'El correo debe ser formato mail (ejemplo@correo.com).',
                        'email.unique' => 'Ese correo ya se encuentra en uso.',
                        'password.required' => 'La contraseña es obligatoria.',
                        'password.confirmed' => 'Las contraseñas no coinciden.',
                        'date.date' => 'La fecha de nacimiento debe ser formato fecha (2021-01-01).',
                        'language.required' => 'El idioma es obligatorio.',
                        'accept.required' => 'Debe aceptar los Términos y las Politicas de privacidad.',
                    ],
                ],
            ], 'change-password' => [
                'rules' => [
                    'data' => 'required',
                ], 'messages' => [
                    'es' => [
                        'data.required' => 'El correo o el apodo son obligatorios.',
                    ],
                ],
            ], 'reset-password' => [
                'rules' => [
                    'password' => 'required|confirmed',
                ], 'messages' => [
                    'es' => [
                        'password.required' => 'La contraseña es obligatoria.',
                        'password.confirmed' => 'Las contraseñas no coinciden.',
                    ],
                ],
            ],
        ];
    }