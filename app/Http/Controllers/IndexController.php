<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::all();


        $userSubscription = null;

        return view('index.index', compact('plans', 'userSubscription'));
    }
}
