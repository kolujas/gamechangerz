<?php
    namespace App\Casts\User;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Credentials implements CastsAttributes {
        /**
         * * Cast the given value.
         *
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  mixed  $value
         * @param  array  $attributes
         * @return mixed
         */
        public function get ($model, $key, $value, $attributes) {
            $credentials = (object) [
                'mercadopago' => null,
                'paypal' => null,
            ];

            foreach (\App\Models\Method::parse($value) as $credential) {
                switch ($credential->id_method) {
                    case 1:
                        $credentials->mercadopago = $credential;
                        break;
                    case 2:
                        $credentials->paypal = $credential;
                        break;
                }
            }

            ddd($credentials);

            return $credentials;
        }

        /**
         * * Prepare the given value for storage.
         *
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  array  $value
         * @param  array  $attributes
         * @return mixed
         */
        public function set ($model, $key, $value, $attributes) {
            return $value;
        }
    }