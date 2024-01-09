<?php

namespace App\Listeners;

use App\Events\UserBanned;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BanUserListener
{
    public function __construct()
    {
        //
    }

    public function handle(UserBanned $event)
    {
        // Access the event data and perform actions, like updating the database to reflect the ban
        // $event->userId, $event->reason
        // Here you would update the user's status to 'banned' in the database or perform other actions.
    }
}