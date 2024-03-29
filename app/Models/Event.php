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
            "description",
            "ended_at",
            "name",
            "started_at",
            "users",
        ];

        /**
         * * Creates an instance of MercadoPago.
         * @param array $attributes
         */
        public function __construct (array $attributes = []) {
            parent::__construct($attributes);

            $client = new Client();
            $client->setAuthConfig(config("google-calendar.auth_profiles.oauth.credentials_json"));
            $client->setAccessToken(file_get_contents(config("google-calendar.auth_profiles.oauth.token_json")));
            $client->addScope(\Google_Service_Calendar::CALENDAR);
            // * offline access will give you both an access and refresh token so that
            // * your app can refresh the access token without user interaction.
            $client->setAccessType("offline");
            // * Using "consent" ensures that your application always receives a refresh token.
            // * If you are not using offline access, you can omit this.
            $client->setApprovalPrompt("consent");
            $client->setIncludeGrantedScopes(true);

            // ? If there is no previous token or it's expired.
            if ($client->isAccessTokenExpired()) {
                // ? Refresh the token if possible, else fetch a new one.
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                }

                file_put_contents(config("google-calendar.auth_profiles.oauth.token_json"), json_encode($client->getAccessToken()));
            }

            // * Create the GoogleEvent
            $this->create();
        }

        /**
         * * Creates the Google Event.
         * @return \Illuminate\Http\Response
         */
        public function create () {
            // * Create the Google Event
            $this->event = new GoogleEvent;

            // * Set the attributes
            $this->event->name = $this->name;
            $this->event->description = $this->description;
            $this->event->startDateTime = $this->started_at->addHours(3);
            $this->event->endDateTime = $this->ended_at->addHours(3);

            // * Loop the Users
            foreach ($this->users as $user) {
                // * Set an Attendee
                $this->event->addAttendee([ "email" => $user->email ]);
            }
            
            // // * Set the testing Attendees
            // $this->event->addAttendee([ "email" => "ffranbarbier@gmail.com" ]);
            // $this->event->addAttendee([ "email" => "juan.cruz.armentia@gmail.com" ]);

            // * Save it
            $this->event->save();
        }
    }