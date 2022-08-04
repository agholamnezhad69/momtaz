<?php

namespace ali\Payment\Events;

use ali\Payment\Models\Payment;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentWasSuccessfull
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
