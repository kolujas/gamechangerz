<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Auth extends Model {
        /** @var array Validation rules & messages. */
        static $validation = [
            'login' => [
                'rules' => [
                    'data' => 'required',
                    'password' => 'required',
                ], 'messages' => [
                    'es' => [
                        'data.required' => 'El correo o el apodo son obligatorios.',
                        'password.required' => 'La contraseña es obligatoria.',
            ]]], 'signin' => [
                'rules' => [
                    'username' => 'required|unique:users',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed',
                    'date' => 'nullable|date',
                    'language' => 'required',
                    'accept' => 'required',
                ], 'messages' => [
                    'es' => [
                        'username.required' => 'El apodo es obligatorio.',
                        'username.unique' => 'Ese apodo ya se encuentra en uso.',
                        'email.required' => 'El correo es obligatorio.',
                        'email.email' => 'El correo debe ser formato mail (ejemplo@correo.com).',
                        'email.unique' => 'Ese correo ya se encuentra en uso.',
                        'password.required' => 'La contraseña es obligatoria.',
                        'password.confirmed' => 'Las contraseñas no coinciden.',
                        'date.date' => 'La fecha de nacimiento debe ser formato fecha (2021-01-01).',
                        'language.required' => 'El idioma es obligatorio.',
                        'accept.required' => 'Debe aceptar los Términos y las Politicas de privacidad.',
        ]]]];
    }