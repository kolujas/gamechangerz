<?php
    namespace App\Models;

    use Carbon\Carbon;
    use Illuminate\Database\Eloquent\Model;
    use Spatie\GoogleCalendar\Event as GoogleEvent;

    class Event extends Model {
        /**
         * * Creates an instance of MercadoPago.
         * @param array $attributes
         */
        public function __construct (array $attributes = []) {
            parent::__construct($attributes);

            // * Create the GoogleEvent
            $this->create();
        }

        /**
         * * Creates the Google Event.
         * @return [type]
         */
        public function create () {
            dd($this->name);

            // * Create the Google Event
            $this->event = new GoogleEvent;

            // * Set the attributes
            $this->event->name = $this->name;
            $this->event->description = $this->description;
            $this->event->startDateTime = $this->started_at;
            $this->event->endDateTime = $this->ended_at;

            // ? If the enviroment is production
            if (config('app.env') === 'production') {
                // * Loop the Users
                foreach ($this->users as $user) {
                    // * Set an Attendee
                    $this->event->addAttendee([ 'email' => $user->email ]);
                }
            }
            // ? If the enviroment is not production
            if (config('app.env') !== 'production') {
                // * Set the testing Attendees
                $this->event->addAttendee([ 'email' => "juancarmentia@gmail.com" ]);
                $this->event->addAttendee([ 'email' => "juan.cruz.armentia@gmail.com" ]);
            }

            // * Save it
            $this->event->save();
        }
    }