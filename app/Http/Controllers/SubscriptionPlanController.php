<?php

namespace App\Http\Controllers;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index(){
    $plans = SubscriptionPlan::where('is_active', true)->get();
    return view('index.subscribe', compact('plans'));
    }

}
