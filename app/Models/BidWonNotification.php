<?php
use Illuminate\Notifications\Notification;

class BidWonNotification extends Notification {
    private $winningBid;

    public function __construct($winningBid) {
        $this->winningBid = $winningBid;
    }

    public function via($notifiable) {
        return ['mail', 'database'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('You won the auction!')
            ->line('Congratulations! You won the auction with a bid of $' . $this->winningBid->bid_amount)
            ->action('Pay Now', url('/payment/process'));
    }

    public function toArray($notifiable) {
        return [
            'message' => 'You won the auction! Pay now.',
            'auction_id' => $this->winningBid->product_id
        ];
    }
}
