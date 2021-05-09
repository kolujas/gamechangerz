<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Auth extends Model {
        /** @var array Validation rules & messages. */
        static $validation = [
            'login' => [
                'rules' => [
                    'login_data' => 'required',
                    'login_password' => 'required',
                ], 'messages' => [
                    'es' => [
                        'login_data.required' => 'El correo o el nombre de usuario son obligatorios.',
                        'login_password.required' => 'La contraseña es obligatoria.',
            ]]], 'signin' => [
                'rules' => [
                    //
                ], 'messages' => [
                    'es' => [
                        //
        ]]]];
    }