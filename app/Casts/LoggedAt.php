<?php
    namespace App\Casts;

    use Carbon\Carbon;
    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class LoggedAt implements CastsAttributes {
        /**
         * * Cast the given value.
         * @param  \Illuminate\Database\Eloquent\Model  $model
         * @param  string  $key
         * @param  mixed  $value
         * @param  array  $attributes
         * @return mixed
         */
        public function get ($model, $key, $value, $attributes) {
            return json_decode($value);
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
            if (gettype($value) == 'integer') {
                $logged_at = collect();
                
                foreach (json_decode($attributes['logged_at']) as $user) {
                    if ($user->id_user != $value) {
                        $logged_at->push($user);
                    }
                }
    
                $logged_at->push((object) [
                    'id_user' => $value,
                    'at' => Carbon::now(),
                ]);
    
                return $logged_at->toJson();
            }

            return $value->toJson();
        }
    }