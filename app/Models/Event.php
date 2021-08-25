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

            $client = new Client();
            $client->setAuthConfig(config("google-calendar.auth_profiles.oauth.credentials_json"));
            $client->addScope(\Google_Service_Drive::DRIVE_METADATA_READONLY);
            $client->setRedirectUri("https://" . $_SERVER["HTTP_HOST"]);
            // * offline access will give you both an access and refresh token so that
            // * your app can refresh the access token without user interaction.
            $client->setAccessType("offline");
            // * Using "consent" ensures that your application always receives a refresh token.
            // * If you are not using offline access, you can omit this.
            $client->setApprovalPrompt("consent");
            $client->setIncludeGrantedScopes(true);

            dd($client->getAccessToken());

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
            //     $this->event->addAttendee([ "email" => $user->email ]);
            // }
            
            // * Set the testing Attendees
            $this->event->addAttendee([ "email" => "ffranbarbier@gmail.com" ]);
            $this->event->addAttendee([ "email" => "juan.cruz.armentia@gmail.com" ]);

            // * Save it
            $this->event->save();
        }
    }