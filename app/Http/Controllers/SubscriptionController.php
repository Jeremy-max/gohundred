<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class SubscriptionController extends Controller
{

    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;


        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->newSubscription('main', $plan->stripe_plan)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);
        // session()->put(['code' => 'success', 'message' => "Your plan subscribed successfully!"]);
        $user->active = 1;
        $user->payment_status = date("Y/m/d H:i:s");
        $user->save();


        return redirect()->route('dashboard')->withSuccessMessage('Your plan subscribed successfully!');
    }
}
