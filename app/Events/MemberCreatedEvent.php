<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Member $member;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return Member
     */
    public function getMember(): Member
    {
        return $this->member;
    }
}
