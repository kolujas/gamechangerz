<?php
    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class FriendshipRequestMail extends Mailable {
        use Queueable, SerializesModels;

        /** @var array Mail data. */
        public $data;

        /**
         * * Create a new message instance.
         * @return void
         */
        public function __construct ($data) {
            $this->data = $data;
        }

        /**
         * * Build the message.
         * @return $this
         */
        public function build () {
            return $this->view('mail.friendship-request')
                ->from(config("mail.from.address"), config("mail.from.name"))
                ->subject("Nueva solicitud de amistad de " . $this->data->username);
        }
    }