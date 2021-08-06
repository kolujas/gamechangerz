<?php
    namespace App\Mail;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Mail\Mailable;
    use Illuminate\Queue\SerializesModels;

    class TeacherRequestMail extends Mailable {
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
            return $this->view('mail.teacher-request')
                ->from($this->data->email_from, $this->data->username)
                ->subject("Nueva solicitud de profesor");
        }
    }