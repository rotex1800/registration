<?php

namespace App\Livewire;

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

    public ?string $amount = null;

    /**
     * @var array|string[]
     */
    protected array $rules = [
        'amount' => 'nullable|numeric',
    ];

    public function render(): Factory|View|Application
    {
        $paymentSum = $this->payer->sumPaidFor($this->event);

        return view('livewire.add-payment', [
            'payer' => $this->payer,
            'event' => $this->event,
            'sum' => $paymentSum,
        ]);
    }

    public function updatedAmount(): void
    {
        $this->amount = str_replace(',', '.', $this->amount ?? '');
        $this->validateOnly('amount');
    }

    public function addPayment(PaymentPolicy $policy): void
    {
        // Ensure only certain users can create a new payment.
        if ($policy->createPayment(Auth::user())->denied()) {
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
