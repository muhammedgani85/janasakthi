<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    use HasFactory;

    public function customer()
{
    return $this->belongsTo(Customer::class, 'customer_id');
}

public function subscriptionPlan()
{
    return $this->belongsTo(Sandha::class, 'subscription_plan_id');
}
}
