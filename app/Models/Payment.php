<?php
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = ['user_id', 'amount', 'payment_method', 'transaction_id', 'status'];
}
