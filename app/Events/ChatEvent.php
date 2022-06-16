<?php

namespace App\Events;

use App\Helpers\Helper;
use App\Models\Company;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ChatEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $avatar;

    public function __construct($message)
    {
        $this->message = $message;
        if ($message->to) { // customer message
            $this->avatar = [
                'color' => Helper::generateAvatarColor($message->target),
                'name' => Helper::getInitialName($message->target)
            ];
        } else { // company message
            $company = Company::find($message->company_id);
            $this->avatar = [
                'color' => Helper::generateAvatarColor($company->owner->id),
                'name' => Helper::getInitialNameCompany($message->company_id)
            ];
        }
    }

    public function broadcastOn()
    {
        return ['chat-channel'];
    }

    public function broadcastAs()
    {
        return 'chat-event';
    }
}
