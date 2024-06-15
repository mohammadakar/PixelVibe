<?php

namespace App\Listeners;

use App\Events\userSubscribed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class SendSubscriberEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(userSubscribed $event): void
    {
        Mail::raw("thank you for subscribing to our newsletter!",function ($message) use ($event){
            $message->to($event->user->email);
            $message->subject('thankyou!');
        });
    }
}
