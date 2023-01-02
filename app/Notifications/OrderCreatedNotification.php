<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     * mail, database, broadcast, vonage(sms), slack
     *
     * @param  mixed  $notifiable User
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $notifiable : App\Models\User
        return (new MailMessage)
                    ->from('notifcations@localhost', config('app.name'))
                    ->subject('New Order #' . $this->order->id)
                    ->greeting('Hello ' . $notifiable->name)
                    ->line('A new order has been created in your store.')
                    ->action('View Order', route('dashboard.categories.index'));
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'title' => 'New Order',
            'body' => "A new order #{$this->order->id} created.",
            'link' => route('dashboard.categories.index'),
            'icon' => 'fas fa-envelope',
        ]);
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => 'New Order',
            'body' => "A new order #{$this->order->id} created.",
            'link' => route('dashboard.categories.index'),
            'icon' => 'fas fa-envelope',
        ]);
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
            //
        ];
    }
}
