<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\Payment;
use App\Models\User;
use App\Policies\PaymentPolicy;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AddPayment extends Component
{
    public User $payer;

    public Event $event;

    public ?float $amount = null;

    public function render(): Factory|View|Application
    {
        $paymentSum = Payment::whereEventId($this->event->id)
                           ->whereUserId($this->payer->id)
                           ->sum('amount');

        return view('livewire.add-payment', [
            'payer' => $this->payer,
            'event' => $this->event,
            'sum' => $paymentSum,
        ]);
    }

    public function addPayment(PaymentPolicy $policy): void
    {
        // Ensure only certain users can create a new payment.
        $authenticatable = Auth::user();
        if ($policy->createPayment($authenticatable)->denied()) {
            return;
        }
        $payment = new Payment([
            'amount' => $this->amount,
        ]);

        $payment->user()->associate($this->payer);
        $payment->event()->associate($this->event);
        $payment->save();

        $this->amount = null;
    }
}
