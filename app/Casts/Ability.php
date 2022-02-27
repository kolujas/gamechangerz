<?php
    namespace App\Casts;

    use App\Models\Ability as Model;
    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Ability implements CastsAttributes {
        /**
         * * Cast the given value.
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  mixed  $value
         * @param  array  $attributes
         * @return mixed
         */
        public function get ($model, $key, $value, $attributes) {
            $collection = collect();
            
            if ($value) {
                foreach (json_decode($value) as $data) {
                    $ability = Model::find($data->id_ability);

                    $ability->stars = isset($data->stars) ? $data->stars : 0;
    
                    $collection->push($ability);
                }
            }
            
            return $collection;
        }

        /**
         * * Prepare the given value for storage.
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  array  $value
         * @param  array  $attributes
         * @return mixed
         */
        public function set ($model, $key, $value, $attributes) {
            $abilities = collect();

            foreach ($value as $ability) {
                $abilities->push([
                    'id_ability' => $ability->id_ability,
                    'stars' => isset($ability->stars) ? $ability->stars : 0,
                ]);
            }

            return $abilities->toJson();
        }
    }