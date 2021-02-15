<?php
namespace App\Http\Controllers;
use App\Subscription;
use Illuminate\Http\Request;


class SubscriptionController extends Controller
{
    public function submit(request $request)
    {
    	$emailfind=Subscription::where('email', $request->input('email'))->pluck('email')->first();
    	$sub=new Subscription;
    	$sub->email=$request->input('email');
    	if($emailfind!=''){
    		return('0');
    	}
    	else
    	{
    		$sub->save();
    		return('1');
    		
    	}
    }
}
