<?php
use Illuminate\Notifications\Notification;

class PaymentSuccessNotification extends Notification {
    private $payment;

    public function __construct($payment) {
        $this->payment = $payment;
    }

    public function via($notifiable) {
        return ['mail', 'database'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Payment Successful')
            ->line('Your payment of $' . $this->payment->amount . ' was successful!')
            ->action('View Transaction', url('/transactions'));
    }

    public function toArray($notifiable) {
        return [
            'message' => 'Payment of $' . $this->payment->amount . ' successful!',
            'transaction_id' => $this->payment->transaction_id
        ];
    }
}
