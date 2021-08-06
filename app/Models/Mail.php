<?php
    namespace App\Models;

    use App\Mail\ConfirmationMail;
    use App\Mail\NewAssigmentMail;
    use App\Mail\NewLessonMail;
    use App\Mail\NewMessageMail;
    use App\Mail\NewPresentationMail;
    use App\Mail\FriendshipRequestMail;
    use App\Mail\TeacherRequestMail;
    use Illuminate\Support\Facades\Mail as MailService;
    use Illuminate\Database\Eloquent\Model;

    class Mail extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_mail", "name",
        ];
        
        /**
         * * Create a new Mail instance.
         * @param array $attributes
         * @param array $data
         */
        public function __construct (array $attributes = [], array $data = []) {
            parent::__construct(Mail::parseAttributes($attributes));
            $this->send($data);
        }

        /**
         * * Send the Mail.
         * @param array $data
         */
        public function send (array $data = []) {
            switch ($this->id_mail) {
                case 1:
                    $mail = new ConfirmationMail((object) $data);
                    break;
                case 2:
                    $mail = new NewMessageMail((object) $data);
                    break;
                case 3:
                    $mail = new NewAssigmentMail((object) $data);
                    break;
                case 4:
                    $mail = new NewPresentationMail((object) $data);
                    break;
                case 5:
                    $mail = new NewLessonMail((object) $data);
                    break;
                case 6:
                    $mail = new FriendshipRequestMail((object) $data);
                    break;
                case 7:
                    $mail = new TeacherRequestMail((object) $data);
                    break;
            }
            MailService::to($data["email_to"])->send($mail);
        }

       /**
        * * Parse the Mail attributes.
        * @param array $attributes
        * @return array
        */
        static function parseAttributes (array $attributes = []) {
            switch ($attributes["id_mail"]) {
                case 1:
                    $attributes["name"] = "Confirmation";
                    break;
                case 2:
                    $attributes["name"] = "New message";
                    break;
                case 3:
                    $attributes["name"] = "New assigment";
                    break;
                case 4:
                    $attributes["name"] = "New presentation";
                    break;
                case 5:
                    $attributes["name"] = "New lesson";
                    break;
                case 6:
                    $attributes["name"] = "Friendship request";
                    break;
                case 7:
                    $attributes["name"] = "New teacher request";
                    break;
            }
            return $attributes;
        }
    }