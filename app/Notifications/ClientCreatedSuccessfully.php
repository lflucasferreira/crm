<?php

namespace App\Notifications;

use App\Models\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClientCreatedSuccessfully extends Notification implements ShouldQueue
{
    use Queueable;

    private $client;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Client $request)
    {
        $this->client = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $name = config('app.name');
        return (new MailMessage)
                    ->subject('Your account was created on ' . $name)
                    ->line('Welcome to ' . $name . ' system.')
                    ->action('Click here to login', route('clients.show', $this->client->id))
                    ->line('Feel free to contact us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'A new record was created on Client table',
            'action' => route('clients.show', $this->client->id)
        ];
    }
}
