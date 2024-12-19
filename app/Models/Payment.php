<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'id_statuses', 
        'payment_confirmation',
        'date_payment', 
        'proof_payment'
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Status
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_statuses');
    }
}
