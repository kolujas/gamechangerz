<?php
    namespace App\Casts\Review;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class AbilitiesAttribute implements CastsAttributes {
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
            if ($model->to->id_role === 0) {
                return \App\Models\Ability::parse($value ? $value : '[]');
            }

            $abilities = collect();

            foreach (json_decode($value) as $ability) {
                $ability = new Ability((array) $ability);
                $abilities->push($ability);
            }

            return Ability::options($abilities->toArray());
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