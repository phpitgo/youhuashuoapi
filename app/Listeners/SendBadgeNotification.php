<?php

namespace App\Listeners;

use App\Model\UserBadge;
use App\Events\BadgeShipped;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendBadgeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BadgeShipped  $event
     * @return void
     */
    public function handle(BadgeShipped $event)
    {
        //
        $user = $event->user;
        $badge = $event->badge;
        $user->userBadges()->save($badge);
    }
}
