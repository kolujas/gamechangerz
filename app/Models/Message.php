<?php
    namespace App\Models;

    use App\Models\Assigment;
    use Illuminate\Database\Eloquent\Model;

    class Message extends Model {
        static public function parse ($messagesToFor) {
            $messages = collect([]);
            foreach ($messagesToFor as $message) {
                if (isset($message->id_assigment)) {
                    $message->assigment = Assigment::find($message->id_assigment);
                    $message->assigment->abilities();
                }
                $messages->push($message);
            }
            return $messages;
        }
    }