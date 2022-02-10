<?php
    namespace App\Notifications;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;

    class FriendshipAccepted extends Notification {
        use Queueable;

        /**
         * * Create a new notification instance.
         * @param array $data
         * @return void
         */
        public function __construct (array $data = []) {
            $this->data = $data;
        }

        /**
         * * Get the notification's delivery channels.
         * @param  mixed  $notifiable
         * @return array
         */
        public function via ($notifiable) {
            return ['database'];
        }

        /**
         * * Get the mail representation of the notification.
         * @param  mixed  $notifiable
         * @return \Illuminate\Notifications\Messages\MailMessage
         */
        public function toMail ($notifiable) {
            return (new MailMessage)
                ->line('The introduction to the notification.')
                ->action('Notification Action', url('/'))
                ->line('Thank you for using our application!');
        }

        /**
         * * Get the array representation of the notification.
         * @param  mixed  $notifiable
         * @return array
         */
        public function toArray ($notifiable) {
            return [
                'id_friend' => $this->data['id_friend'],
                'id_user' => $this->data['to']->id_user,
                'link' => '/users/' . $this->data['to']->slug . '/profile',
                'message' => 'Solicitud de amistad aceptada',
            ];
        }
    }