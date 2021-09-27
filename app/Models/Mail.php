<?php
    namespace App\Models;

    use App\Mail\ConfirmationMail;
    use App\Mail\NewAssignmentMail;
    use App\Mail\NewLessonTeacherMail;
    use App\Mail\NewLessonUserMail;
    use App\Mail\NewMessageMail;
    use App\Mail\NewPresentationMail;
    use App\Mail\FriendshipRequestMail;
    use App\Mail\TeacherRequestMail;
    use App\Mail\TeacherRequestApprovedMail;
    use Illuminate\Support\Facades\Mail as MailService;
    use Illuminate\Database\Eloquent\Model;

    class Mail extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            "id_mail",
            "name",
            "slug",
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
                    // * When a User signs in
                    $mail = new ConfirmationMail((object) $data);
                    break;
                case 2:
                    // * When a User sends a Message to another
                    $mail = new NewMessageMail((object) $data);
                    break;
                case 3:
                    // * When a Teacher sends a new Assignment
                    $mail = new NewAssignmentMail((object) $data);
                    break;
                case 4:
                    // * When a User completes an Assignment
                    $mail = new NewPresentationMail((object) $data);
                    break;
                case 5:
                    // * When a User pays for a Lesson, this is an alert for the Teacher
                    $mail = new NewLessonTeacherMail((object) $data);
                    break;
                case 6:
                    // * When a User sends a friendship request
                    $mail = new FriendshipRequestMail((object) $data);
                    break;
                case 7:
                    // * When a User sends a Teacher request
                    $mail = new TeacherRequestMail((object) $data);
                    break;
                case 8:
                    // * When a User pays for a Lesson, this is an alert for the User
                    $mail = new NewLessonUserMail((object) $data);
                    break;
                case 9:
                    // * When an Admin creates a new Teacher
                    $mail = new TeacherRequestApprovedMail((object) $data);
                    break;
                case 11:
                    // * When a User tries to contact GameChangerZ
                    $mail = new ContactMail((object) $data);
                    break;
                case 12:
                    // * When a User tries to contact with GameChangerZ support
                    $mail = new SupportMail((object) $data);
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
                    $attributes["name"] = "New assignment";
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
        /**
         * * Validation rules & messages.
         * @var array
         */
        static $validation = [
            "contact" => [
                "rules" => [
                    "name" => "required",
                    "email" => "required",
                    "details" => "required",
                ], "messages" => [
                    "es" => [
                        "name.required" => "El nombre es obligatorio.",
                        "email.required" => "El correo es obligatorio.",
                        "details.required" => "Los detalles son obligatorios.",
                    ],
                ],
            ], "support" => [
                "rules" => [
                    "name" => "required",
                    "email" => "required",
                    "details" => "required",
                ], "messages" => [
                    "es" => [
                        "name.required" => "El nombre es obligatorio.",
                        "email.required" => "El correo es obligatorio.",
                        "details.required" => "Los detalles son obligatorios.",
                    ],
                ],
            ],
        ];
    }