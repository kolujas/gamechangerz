<?php
    namespace App\Casts;

    use App\Models\Message as Model;
    use Carbon\Carbon;
    use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

    class Message implements CastsAttributes {
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
                    $message = new Model((array) $data);
    
                    $collection->push($message);
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
            if (isset($value['abilities']) || isset($value['id_assignment']) || isset($value['says'])) {
                $messages = collect();
    
                $value['created_at'] = Carbon::now();
                
                $value['id_message'] = 1;
                
                foreach (json_decode($attributes['messages']) as $message) {
                    $value['id_message'] = intval($message->id_message) + 1;
    
                    $messages->push($message);
                }
    
                $messages->push(new Model((array) $value));
    
                return $messages->toJson();
            }

            return $value->toJson();
        }
    }