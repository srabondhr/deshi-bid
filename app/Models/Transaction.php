<?php
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model {
    protected $fillable = ['user_id', 'payment_id', 'status', 'amount', 'payment_method'];
}
