<?php
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class Auth extends Model {
        use HasFactory;

        /** @var array Validation rules & messages. */
        static $validation = [
            'login' => [
                'rules' => [
                    'data' => 'required',
                    'password' => 'required',
                ], 'messages' => [
                    'es' => [
                        'data.required' => 'El correo o el nombre de usuario es obligatorio.',
                        'password.required' => 'La contraseña es obligatoria.',
            ]]], 'signin' => [
                'rules' => [
                    //
                ], 'messages' => [
                    'es' => [
                        //
        ]]]];
    }