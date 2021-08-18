<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StripeWebhook extends Model
{
    protected $table = 'stripe_webhooks';
    protected $fillable = ['response'];
}
