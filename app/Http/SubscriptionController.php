<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Plan;
use App\User;
use Illuminate\Support\Facades\Session;
class SubscriptionController extends Controller
{   
    protected $stripe;

    public function __construct() 
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }

    public function create(Request $request, Plan $plan)
    {


    echo   $plan = Plan::findOrFail($request->get('plan'));


   
        $user = Session::get('userData');
        $paymentMethod = $request->paymentMethod;

        $user->createOrGetStripeCustomer();
        $user->hasPaymentMethod();
        $user->newSubscription('default', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
				'name' => 'waqas',
            ]);
			
			
        return redirect()->route('home')->with('success', 'Your plan subscribed successfully');
    }


    public function createPlan()
    {
        return view('plans.create');
    }

    public function storePlan(Request $request)
    {   
        $data = $request->except('_token');

        $data['slug'] = strtolower($data['name']);
        $price = $data['cost'] *100; 

        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);
        
        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'inr',
            'interval' => 'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);

        $data['stripe_plan'] = $stripePlanCreation->id;

        Plan::create($data);

        echo 'plan has been created';
    }
}