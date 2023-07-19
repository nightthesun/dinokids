<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificacionEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $dat;
    public $users;
    public function __construct($dat, $users)
    {
        $this->dat = $dat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('public-notificacion-channel');
    }
    public function broadcastAs()
    {
        return 'MessageEvent';
    }

    public function broadcastWith()
    {
        //$dat = $this->dat;
        return [
            'text' =>$this->dat['text'],
            'url' => $this->dat['url'],
            "user_id" => $this->dat['user_id'],
            "cotizacion_id" => $this->dat['cotizacion_id'],
            "permiso" => $this->dat['permiso'],
        ];
    }
}
