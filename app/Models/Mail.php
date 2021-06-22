<?php
    namespace App\Models;

    use App\Mail\ConfirmationMail;
    use Illuminate\Support\Facades\Mail as MailService;
    use Illuminate\Database\Eloquent\Model;

    class Mail extends Model {
        /**
         * * The attributes that are mass assignable.
         * @var array
         */
        protected $fillable = [
            'id_mail', 'name',
        ];
        
        /**
         * * Create a new Mail instance.
         * @param array $attributes
         * @param array $data
         * @return void
         */
        public function __construct ($attributes = [], $data = []) {
            parent::__construct(Mail::parseAttributes($attributes));
            $this->send($data);
        }

        /**
         * * Send the Mail.
         * @param array $data
         * @return [type]
         */
        public function send ($data = []) {
            switch ($this->id_mail) {
                case 1:
                    $mail = new ConfirmationMail((object) [
                        "token" => $data['token'],
                    ]);
                    break;
            }
            MailService::to($data['email'])->send($mail);
        }

       /**
        * * Parse the Mail attributes.
        * @param array $attributes
        * @return array
        */
        static function parseAttributes ($attributes = []) {
            switch ($attributes['id_mail']) {
                case 1:
                    $attributes['name'] = "Confirmation";
                    break;
            }
            return $attributes;
        }
    }