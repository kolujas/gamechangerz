<?php
    namespace App\Casts\Chat;

    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Message implements CastsAttributes {
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
            return \App\Models\Message::parse($value ? $value : '[]');
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
            $messages = collect();
            $value->id_message = 1;

            foreach (json_decode($model->messages) as $message) {
                $value->id_message = intval($message->id_message) + 1;
                $messages->push($message);
            }

            $messages->push($value);

            return $messages->toJson();
        }
    }