<?php

namespace App\Listeners;

use App\Events\userSubscribed;
use Illuminate\Support\Facades\DB;
class UpdateSubTable
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
        DB::insert('insert into subscribers (email) values (?)',[$event->user->email]);
    }
}
