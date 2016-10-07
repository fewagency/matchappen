<?php

namespace Matchappen\Events;

use Matchappen\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EmailWasRejected extends Event
{
    use SerializesModels;

    public $rejected_email_address;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($rejected_email_address)
    {
        $this->rejected_email_address = $rejected_email_address;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
