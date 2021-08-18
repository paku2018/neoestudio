<?php

namespace App\Http\Controllers;

use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;
use App\Pay;
use App\Product;
use App\StripeWebhook;
use DB;
use Illuminate\Http\Request;
use App\Plan;
use App\User;
use Illuminate\Support\Facades\Session;
use Stripe\Subscription;

class WebhookController extends CashierController
{
    /**
     * Handle invoice payment succeeded.
     *
     * @param  array  $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
        $data = $payload['data'];
        $object = $data['object'];
        $paid = $object['paid'];
        if(isset($paid) && empty($paid) === false && $paid == true){
            $amount_paid = $object['amount_paid'];
            $customer_email = $object['customer_email'];
            $billing_reason = $object['billing_reason'];
            if(isset($customer_email) && empty($customer_email) === false){
                $user = User::where('email',$customer_email)->first();
                if(isset($user) && empty($user->id) === false){
                    $payUser = \App\User::find($user->id);
                    $payUser->field1x = "Desbloquear";
                    $payUser->save();
                }
            }
        }
    }

    public function handleInvoicePaymentFailed($payload)
    {
        // Handle The Event
        $data = $payload['data'];
        $object = $data['object'];
        $paid = $object['paid'];
        if(isset($paid) && (empty($paid) === true || $paid == false)){
            $amount_paid = $object['amount_paid'];
            $customer_email = $object['customer_email'];
            $billing_reason = $object['billing_reason'];
            if(isset($customer_email) && empty($customer_email) === false){
                $user = User::where('email',$customer_email)->first();
                if(isset($user) && empty($user->id) === false){
                    $payUser = \App\User::find($user->id);
                    $payUser->field1x = "Bloquear";
                    $payUser->save();
                }
            }
        }
    }

}