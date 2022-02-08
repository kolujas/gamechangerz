<?php
    namespace App\Casts\Coupon;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class TypeAttribute implements CastsAttributes {
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
            $type = json_decode($value);

            $type->key = $type->id_type == 1 ? '%' : '$';

            return $type;
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
            return json_encode([
                'id_type' => $value->type == '%' ? 1 : 2,
                'value' => $value->value
            ]);
        }
    }