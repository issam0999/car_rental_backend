<?php

namespace App\Listeners;

use App\Events\CenterCreated;
use App\Mail\CenterCreated as MailCenterCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendCenterCreatedEmail implements ShouldQueue
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
     * Run listener only after DB commit
     */
    public bool $afterCommit = true;

    public function handle(CenterCreated $event): void
    {
        Mail::to($event->center->email)->queue(
            new MailCenterCreated(
                $event->center->load('package'),
                $event->user,
                $event->password
            )
        );
    }
}
