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
                        'data.required' => 'El correo o el nombre de usuario son obligatorios.',
                        'password.required' => 'La contraseña es obligatoria.',
            ]]], 'signin' => [
                'rules' => [
                    'username' => 'required|unique:users',
                    'email' => 'required|unique:users',
                    'password' => 'required|confirmed',
                    'date' => 'nullable|date',
                    'language' => 'required',
                    'accept' => 'required',
                ], 'messages' => [
                    'es' => [
                        'username.required' => 'El nombre de usuario es obligatorio.',
                        'username.unique' => 'Ese nombre de usuario ya se encuentra en uso.',
                        'email.required' => 'El correo es obligatorio.',
                        'email.unique' => 'Ese correo ya se encuentra en uso.',
                        'password.required' => 'La contraseña es obligatoria.',
                        'password.confirmed' => 'Las contraseñas no coinciden.',
                        'date.date' => 'La fecha de nacimiento debe ser formato fecha (2021-01-01).',
                        'language.required' => 'El idioma es obligatorio.',
                        'accept.required' => 'Debe aceptar los Términos y las Politicas de privacidad.',
        ]]]];
    }