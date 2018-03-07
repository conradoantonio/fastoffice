<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PusherEvent implements ShouldBroadcast
{
	use Dispatchable, SerializesModels;

	/*
	* Public variables are a must to declare!!
	*/
	public $data;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

	/**
	 * Get the channels the event should broadcast on.
	 *
	 * @return Channel|array
	 */
	public function broadcastOn()
	{
		return ['channel-broadcast'];
	}

	/**
	* The event's broadcast name.
	* Si no se agrega toma como nombre el evento App\Events\...
	* @return string
	*/
	public function broadcastAs()
	{
		return 'listen-event';
	}
}
