<?php
    namespace App\Models;

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
            parent::__construct($attributes);
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
                    $mail = new \App\Mail\ConfirmationMail((object) $data);
                    break;
                case 2:
                    // * When a User sends a Message to another
                    $mail = new \App\Mail\NewMessageMail((object) $data);
                    break;
                case 3:
                    // * When a Teacher sends a new Assignment
                    $mail = new \App\Mail\NewAssignmentMail((object) $data);
                    break;
                case 4:
                    // * When a User completes an Assignment
                    $mail = new \App\Mail\NewPresentationMail((object) $data);
                    break;
                case 5:
                    // * When a User pays for a Lesson, this is an alert for the Teacher
                    $mail = new \App\Mail\NewLessonTeacherMail((object) $data);
                    break;
                case 6:
                    // * When a User sends a friendship request
                    $mail = new \App\Mail\FriendshipRequestMail((object) $data);
                    break;
                case 7:
                    // * When a User sends a Teacher request
                    $mail = new \App\Mail\TeacherRequestMail((object) $data);
                    break;
                case 8:
                    // * When a User pays for a Lesson, this is an alert for the User
                    $mail = new \App\Mail\NewLessonUserMail((object) $data);
                    break;
                case 9:
                    // * When an Admin creates a new Teacher
                    $mail = new \App\Mail\TeacherRequestApprovedMail((object) $data);
                    break;
                case 11:
                    // * When a User tries to contact Gamechangerz
                    $mail = new \App\Mail\ContactMail((object) $data);
                    break;
                case 12:
                    // * When a User tries to contact with Gamechangerz support
                    $mail = new \App\Mail\SupportMail((object) $data);
                    break;
                case 13:
                    // * When a User tries to reset his password
                    $mail = new \App\Mail\ChangePasswordMail((object) $data);
                    break;
            }
            MailService::to($data["email_to"])->send($mail);
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