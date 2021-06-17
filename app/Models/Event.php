<?php
    namespace App\Models;

    use Carbon\Carbon;
    use Spatie\GoogleCalendar\Event as Model;

    class Event {
        static public function create (object $attributes) {
            $event = new Model;
            $event->name = $attributes->name;
            $event->description = $attributes->description;
            $event->startDateTime = $attributes->startDateTime;
            $event->endDateTime = $attributes->endDateTime;
            if (config('app.env') === 'production') {
                foreach ($attributes->users as $user) {
                    $event->addAttendee([ 'email' => $user->email ]);
                }
            }
            if (config('app.env') !== 'production') {
                $event->addAttendee([ 'email' => "champarmentia@gmail.com" ]);
                $event->addAttendee([ 'email' => "juan.cruz.armentia@gmail.com" ]);
            }
            $event->save();
        }
    }