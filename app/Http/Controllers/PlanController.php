<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Plan;


class PlanController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            $user = \Auth::user();
            if($user)
            {
                $firstcharname = strtoupper(substr($user->name, 0, 1));
                View::share('namefirstchar', $firstcharname);
            }
            return $next($request);
        });
    }

    public function show(Request $request)
    {
        $plan = Plan::first();

        return view('plans.show', compact('plan'));
    }

    public function creditCardPay(Plan $plan, Request $request)
    {
        $intent = $request->user()->createSetupIntent();
        return view('plans.credit-card', compact('plan', 'intent'));
    }
}
