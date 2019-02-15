<?php

namespace Liliom\Notifications\Channels;

use Illuminate\Notifications\Notification;
use Liliom\Notifications\Messages\UnifonicMessage;
use Liliom\Unifonic\UnifonicClient;
use Liliom\Unifonic\UnifonicManager;

class UnifonicSmsChannel
{
    /**
     * The Unifonic client instance.
     *
     * @var unifonicClient
     */
    protected $unifonic;

    /**
     * The sender Id notifications should be sent from.
     *
     * @var string
     */
    protected $senderID;

    /**
     * Create a new Unifonic channel instance.
     *
     * @param UnifonicManager $unifonic
     *
     */
    public function __construct(UnifonicManager $unifonic)
    {
        $this->senderID = config('services.unifonic.sender_id');
        $this->unifonic = $unifonic;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     *
     * @return object
     */
    public function send($notifiable, Notification $notification)
    {
        if ( ! $to = $notifiable->routeNotificationFor('unifonic', $notification)) {
            return;
        }

        $message = $notification->toUnifonic($notifiable);

        if (is_string($message)) {
            $message = new UnifonicMessage($message);
        }

        $senderID = $message->senderID ?: $this->senderID;

        return $this->unifonic->send($to, trim($message->content), $senderID);
    }
}
