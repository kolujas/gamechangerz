<?php
    namespace App\Models;

    use Carbon\Carbon;
    use Google\Client;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Spatie\GoogleCalendar\Event as GoogleEvent;
    use Storage;

    class Event extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "users", "name", "description", "started_at", "ended_at",
        ];

        /**
         * * Creates an instance of MercadoPago.
         * @param array $attributes
         */
        public function __construct (array $attributes = []) {
            parent::__construct($attributes);

            $token = json_decode(Storage::disk("google-calendar")->get("oauth-token.json"));

            $response = Http::get("https://www.googleapis.com/oauth2/v1/tokeninfo?access_token=" . $token->access_token);

            dd($response);

            if (isset($response->json()->error)) {
                $client = new Client();
                $client->refreshToken($token->refresh_token);
                dd([
                    "access_token" => $client->getAccessToken(),
                    "refresh_token" => $client->getRefreshToken(),
                    "expires_in" => 3600,
                    "scope" => "https:\/\/www.googleapis.com\/auth\/calendar",
                    "token_type" => "Bearer",
                    "created" => 1629841846,
                ]);
            }

            // * Create the GoogleEvent
            $this->create();
        }

        /**
         * * Creates the Google Event.
         * @return [type]
         */
        public function create () {
            // * Create the Google Event
            $this->event = new GoogleEvent;

            // * Set the attributes
            $this->event->name = $this->name;
            $this->event->description = $this->description;
            $this->event->startDateTime = $this->started_at;
            $this->event->endDateTime = $this->ended_at;

            // // * Loop the Users
            // foreach ($this->users as $user) {
            //     // * Set an Attendee
            //     $this->event->addAttendee([ 'email' => $user->email ]);
            // }
            
            // * Set the testing Attendees
            $this->event->addAttendee([ 'email' => "juancarmentia@gmail.com" ]);
            $this->event->addAttendee([ 'email' => "juan.cruz.armentia@gmail.com" ]);

            // * Save it
            $this->event->save();
        }
    }