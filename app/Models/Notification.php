<?php
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $fillable = ['user_id', 'message', 'type', 'read_status'];
}
;