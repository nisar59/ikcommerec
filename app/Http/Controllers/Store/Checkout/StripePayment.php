<?php
namespace App\Http\Controllers\Store\Checkout;


use Illuminate\Http\Request;
use Session;
use Stripe;
use App\Http\Controllers\Store\Controller;
use Config;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Store\Checkout\Cart;
use Cart as CartController;

class StripePayment  extends Controller
{
    public $cart;
    private $_api_context;
    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart();
        /** PayPal api context **/
       // $paypal_conf = Config::get('paypal');

    }
    public function stripe(Request $request,$id)
    { //dd('asd');
        $this->data['order'] =Order::find($id);
        $this->data['orderAmount'] = $this->data['order']->total;
        $this->data['items'] = $this->cart->getItems();

            $this->data['cart'] = [];
            $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
            $this->data['cart_total'] = $this->cart->getCartTotal();
        return view('store.checkout.stripe')->with('data',$this->data);
    }
    public function stripePost(Request $request)
    { //dd(config('settings.config_stripe_publishable_key'));

      // dd($request->order_amount);
        Stripe\Stripe::setApiKey(config('settings.config_stripe_secret_key'));
        Stripe\Charge::create ([
            "amount" => $request->order_amount * 100,
            "currency" => "usd",
            "source" => $request->stripeToken,
            "description" =>  $request->order_des
        ]);

        Session::flash('success', 'Payment successful!');
        CartController::clear();
        CartController::clearCartConditions();
        return back();
    }

    public function index(Request $request){
       dd('here');
        \Stripe\Stripe::setApiKey(env('sk_test_51HWCLBBAuPZwiNwRX7i9XBaiRCDa9KyDLD2MEFiKWqM22kWgLHCeo3v2X7ZLJDdyPqhXi0xWGbRMWd8xNpXKiUEv00QL69RPMC'));
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' =>10000,
            'currency'=>'usd',
            'description'=>'example',
            'source' =>$token,

        ]);

//        if($request->post() && !$request->order){
//            /*if($request->order){
//                $order = Order::where('id', $request->order)->first();
//            }else{}*/
//            $items = $this->cart->getItems();
//            if($items->count() && Session::has('shipping_address') && Session::has('shipping_method_applied')) {
//                $shippingAddress = ShippingAddress::where('id', Session::get('shipping_address')->id)->first();
//                $totalItems = $items->count();
//                $subTotal = $this->cart->getCartSubTotal();
//                $discount = $this->cart->getCartDiscount();
//                $shipping = $this->cart->getCartShippingCost();
//                $total = $this->cart->getCartTotal();
//
//                $order = new Order();
//                $order->total_items = $totalItems;
//                $order->sub_total = $subTotal;
//                $order->discount = $discount;
//                $order->shipping = $shipping;
//                $order->total = $total;
//                $order->currency = config('variable.DEFAULT_CURRENCY');
//                $order->rate = 1;
//
//                //Shipping Address
//                $order->ship_full_name = $shippingAddress->first_name.' '.$shippingAddress->last_name;
//                $order->ship_address_1 = $shippingAddress->address_1;
//                $order->ship_address_2 = $shippingAddress->address_2;
//                $order->ship_country = $shippingAddress->country;
//                $order->ship_state = $shippingAddress->state;
//                $order->ship_city = $shippingAddress->city;
//                $order->ship_postal_code = $shippingAddress->post_code;
//                $order->ship_phone = $shippingAddress->phone;
//                $order->ship_email = $shippingAddress->email;
//
//                //Billing Address
//                $order->first_name = $shippingAddress->billing_first_name;
//                $order->last_name = $shippingAddress->billing_last_name;
//                $order->billing_address_1 = $shippingAddress->billing_address_1;
//                $order->billing_address_2 = $shippingAddress->billing_address_2;
//                $order->billing_country = $shippingAddress->billing_country;
//                $order->billing_state = $shippingAddress->billing_state;
//                $order->billing_city = $shippingAddress->billing_city;
//                $order->billing_postal_code = $shippingAddress->billing_post_code;
//                $order->billing_phone = $shippingAddress->billing_phone;
//                $order->billing_email = $shippingAddress->billing_email;
//                $order->save();
//
//                if($order){
//                    foreach ($items as $item){
//                        //$attributes = $item->attributes; // the attributes
//                        $orderProducts = new OrderProduct();
//                        $orderProducts->order_id = $order->id;
//                        $orderProducts->product_id = $item->id;
//                        $orderProducts->quantity = $item->quantity;
//                        $orderProducts->total_price = $item->price;
//                        $orderProducts->price = $item->getPriceSumWithConditions();
//                        $orderProducts->tax = 0;
//                        $orderProducts->discount = 0;
//
//                        if( $item->attributes->has('color_id') ){
//                            $orderProducts->color_id = $item->attributes->color_id;
//                        }
//                        if( $item->attributes->has('color_name') ){
//                            $orderProducts->color_name = $item->attributes->color_name;
//                        }
//                        if( $item->attributes->has('size_id') ){
//                            $orderProducts->size_id = $item->attributes->size_id;
//                        }
//                        if( $item->attributes->has('size_name') ){
//                            $orderProducts->size_name = $item->attributes->size_name;
//                        }
//
//                        $orderProducts->save();
//                    }
//                }
//                return redirect(route('store-payment-process', $order->id));
//            }else{
//                Session::flash('error', 'Something went wrong! Please try again.');
//                return redirect()->route('store-payment');
//            }
//        }else{
//            $this->data['items'] = $this->cart->getItems();
//            if($this->data['items']->count() && Session::has('shipping_address') && Session::has('shipping_method_applied')){
//                $this->data['cart'] = [];
//                $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
//                $this->data['cart_total'] = $this->cart->getCartTotal();
//                return view('store.checkout.payment')->withData($this->data);
//            }else{
//                Session::flash('error', 'Something went wrong! Please try again.');
//                return redirect()->route('store-cart-index');
//            }
//        }
    }

}
