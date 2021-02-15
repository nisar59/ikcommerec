<?php
namespace App\Http\Controllers\Store\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Store\Controller;
use App\Http\Controllers\Store\Checkout\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\WarehouseProductStock;
use Darryldecode\Cart\CartCondition;
use Cart as CartController;
use App\Models\Order;

class Checkout extends Controller
{
    public $cart;
    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart();
    }

    function order($id){
        $order = Order::where('id', $id)->first();
        $this->data['order'] = $order;
        if($this->data['order']){
            $this->data['items'] = $this->data['order']->orderProducts()->get();
        }
        $this->data['admin'] = false;
        $this->data['subject'] = "Order Placed | ".config('app.name');
        return view('store.emails.order')->withData($this->data);
        //Mail::to($this->data['order']->billing_email)->send(new Email($this->data));
    }
}
