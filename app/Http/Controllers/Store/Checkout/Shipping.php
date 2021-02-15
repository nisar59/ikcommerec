<?php
namespace App\Http\Controllers\Store\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Store\Checkout\Cart;
use Cart as CartController;
use Darryldecode\Cart\CartCondition;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\Countries;
use App\Models\Order;
use App\Models\OrderProduct;
use Modules\Category\Entities\Category as CategoryModel;

use Modules\PaymentsMethods\Entities\PaymentMethods;
use App\Repositories\ProductRepository;

use Modules\Products\Entities\Products as Product;
use Modules\Brands\Entities\Brands;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Modules\Products\Entities\ProductsWarehouseStocks;

class Shipping extends Controller
{
    use  ValidatesRequests;
    public $cart;
	public function __construct()
	{
		//parent::__construct();
        $this->cart = new Cart();
        $this->product = new ProductRepository();
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Product::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Product::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Product::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->settings();
    }
    public function logincheck(){

        return view('store.checkout.logincheck')->withData($this->data);
    }
    public function shipping(Request $request){
        if($request->post()){
         // dd($request->all());


            $this->validate($request, [
                'email' => 'bail|required|email',
                'first_name' => 'bail|required',
                'country' => 'bail|required',
                'state' => 'bail|required',
                'city' => 'bail|required',
                'address_1' => 'bail|required',
                'post_code' => 'bail|required',
                'phone' => 'bail|required',
                'billing_email' => isset($request->billing_address_check) ? 'bail|required|email' : '',
                'billing_first_name' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_country' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_state' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_city' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_address_1' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_post_code' => isset($request->billing_address_check) ? 'bail|required' : '',
                'billing_phone' => isset($request->billing_address_check) ? 'bail|required' : '',

            ]);

           // if ($validator->passes()){
                try{

                    $shippingAddress = new ShippingAddress();
                    //if(isset($request->shipping_address_id) && $request->shipping_address_id){
                    //    $shippingAddress = ShippingAddress::where('id', $request->shipping_address_id)->first();

                   // }
                   // dd(Auth::guard('user')->user()->id);
                   // dd($shippingAddress);
                    $shippingAddress->customer_id = (Auth::guard('user')->user() ? Auth::guard('user')->user()->id : null);
                    //Shipping Address

                    $shippingAddress->email = $request->email;
                    $shippingAddress->first_name = $request->first_name;
                    $shippingAddress->last_name = $request->last_name;
                    $shippingAddress->company = $request->company;
                    $shippingAddress->address_1 = $request->address_1;
                    $shippingAddress->address_2 = $request->address_2;
                    $shippingAddress->country = $request->country;
                    $shippingAddress->state = $request->state;
                    $shippingAddress->city = $request->city;
                    $shippingAddress->post_code = $request->post_code;
                    $shippingAddress->phone = $request->phone;
                    $shippingAddress->fax = $request->fax;
                    //Billing Address
                    $shippingAddress->billing_email = isset($request->billing_address_check) ? $request->billing_email : $request->email;
                    $shippingAddress->billing_first_name = isset($request->billing_address_check) ? $request->billing_first_name : $request->first_name;
                    $shippingAddress->billing_last_name = isset($request->billing_address_check) ? $request->billing_last_name : $request->last_name;
                    $shippingAddress->billing_company = isset($request->billing_address_check) ? $request->billing_company : $request->company;
                    $shippingAddress->billing_address_1 = isset($request->billing_address_check) ? $request->billing_address_1 : $request->address_1;
                    $shippingAddress->billing_address_2 = isset($request->billing_address_check) ? $request->billing_address_2 : $request->address_2;
                    $shippingAddress->billing_country = isset($request->billing_address_check) ? $request->billing_country : $request->country;
                    $shippingAddress->billing_state = isset($request->billing_address_check) ? $request->billing_state : $request->state;
                    $shippingAddress->billing_city = isset($request->billing_address_check) ? $request->billing_city : $request->city;
                    $shippingAddress->billing_post_code = isset($request->billing_address_check) ? $request->billing_post_code : $request->post_code;
                    $shippingAddress->billing_phone = isset($request->billing_address_check) ? $request->billing_phone : $request->phone;
                    $shippingAddress->billing_fax = isset($request->billing_address_check) ? $request->billing_fax : $request->fax;

                    $shippingAddress->shipping_method = (Session::has('shipping_method_applied') ? Session::get('shipping_method_applied') : null);
                    $shippingAddress->save();

                    Session::forget('shipping_address');
                    Session::put('shipping_address', $shippingAddress);
                }catch (\Exception $e){

                   // dd($e->getMessage());
                    \Session::flash('error', 'Something went wrong! '.$e->getMessage());
                    return redirect()->back()->withInput();
                }
                $inputs = $request->all();
                //Redirect to payment screen
                $this->orderSubmission($inputs,$request->payment_method);

            return view('store.checkout.thank-you')->withData($this->data);
           // }
        }else{
            if(!Auth::guard('user')->user()){
                return redirect('login-check');
            }
            $this->data['items'] = CartController::getContent();
            $this->data['paymentsMethods'] = PaymentMethods::where('status',1)->orderBy('sort_order')->get();
            if($this->data['items']->count()){
                $this->data['cart'] = [];
                $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
                $this->data['cart_total'] = $this->cart->getCartTotal();
              //  $this->data['countries'] = Countries::where('status', 1)->pluck('name', 'id')->toArray();
                /*if(Session::has('shipping_address')){
                    $request->merge(Session::get('shipping_address')->toArray());
                }*/
                if(Auth::guard('user')->user() && !Session::has('shipping_address')){
                    Session::put('shipping_address', Auth::guard('user')->user());
                }
                return view('store.checkout.shipping')->withData($this->data);
            }else{
                return redirect()->route('store-index');
            }
        }
    }

    public function orderSubmission($inputs= [] , $payment_method ='COD'){
//dd($inputs);

	    $items = $this->cart->getItems();
        if($items->count() && Session::has('shipping_address')) {
            $shippingAddress = ShippingAddress::where('id', Session::get('shipping_address')->id)->first();
            $totalItems = $items->count();
            $subTotal = $this->cart->getCartSubTotal();
            $discount = $this->cart->getCartDiscount();
          //  $shipping = $this->cart->getCartShippingCost();
            $total = $this->cart->getCartTotal();

            $order = new Order();
            $order->total_items = $totalItems;
            $order->sub_total = $subTotal;
            $order->discount = $discount;
           // $order->shipping = $shipping;
            $order->total = $total;
            $order->currency = config('variable.DEFAULT_CURRENCY');
            $order->rate = 1;

            //Shipping Address
            $order->ship_full_name = $shippingAddress->first_name.' '.$shippingAddress->last_name;
            $order->ship_address_1 = $shippingAddress->address_1;
            $order->ship_address_2 = $shippingAddress->address_2;
            $order->ship_country = $shippingAddress->country;
            $order->ship_state = $shippingAddress->state;
            $order->ship_city = $shippingAddress->city;
            $order->ship_postal_code = $shippingAddress->post_code;
            $order->ship_phone = $shippingAddress->phone;
            $order->ship_email = $shippingAddress->email;

            //Billing Address
            $order->first_name = $shippingAddress->billing_first_name;
            $order->last_name = $shippingAddress->billing_last_name;
            $order->billing_address_1 = $shippingAddress->billing_address_1;
            $order->billing_address_2 = $shippingAddress->billing_address_2;
            $order->billing_country = $shippingAddress->billing_country;
            $order->billing_state = $shippingAddress->billing_state;
            $order->billing_city = $shippingAddress->billing_city;
            $order->billing_postal_code = $shippingAddress->billing_post_code;
            $order->billing_phone = $shippingAddress->billing_phone;
            $order->billing_email = $shippingAddress->billing_email;
            $order->payment_method = $payment_method;
            $order->customer_id = Auth::guard('user')->user()->id;
            $order->order_note = $inputs['order_note'];
            $order->save();

            if($order){
                foreach ($items as $item){
                    //$attributes = $item->attributes; // the attributes
                    $orderProducts = new OrderProduct();
                    $orderProducts->order_id = $order->id;
                    $orderProducts->product_id = $item->id;
                    $orderProducts->quantity = $item->quantity;
                    $orderProducts->total_price = (($item->sale_price>0)?$item->sale_price: $item->price)*$item->quantity;
                    $orderProducts->price = $item->getPriceSumWithConditions();
                    $orderProducts->tax = 0;
                    $orderProducts->discount = 0;

                    if( $item->attributes->has('color_id') ){
                        $orderProducts->color_id = $item->attributes->color_id;
                    }
                    if( $item->attributes->has('color_name') ){
                        $orderProducts->color_name = $item->attributes->color_name;
                    }
                    if( $item->attributes->has('size_id') ){
                        $orderProducts->size_id = $item->attributes->size_id;
                    }
                    if( $item->attributes->has('size_name') ){
                        $orderProducts->size_name = $item->attributes->size_name;
                    }
                    $orderProducts->save();
                    $products = Product::find($item->id);

                    $products->sold = $products->sold + $item->quantity;
                    $updatedqty = $products->quantity - $item->quantity;
                       if($updatedqty<0){
                           $products->quantity = 0;

                       }else{

                           $products->quantity =$updatedqty;
                       }



                    $products->save();
                    $warehouseStock = ProductsWarehouseStocks::where('p_id',$item->id)->first();
                    $updatedhqty = $warehouseStock['quantity'] - $item->quantity;
                    if($updatedqty<0){
                        $warehouseStock['quantity'] = 0;

                    }else{

                        $warehouseStock['quantity'] =$updatedhqty;
                    }
                    $warehouseStock = ProductsWarehouseStocks::where('p_id',$item->id)->update(['quantity'=>$warehouseStock['quantity']]);
                    //$warehouseStock->save();

                }
            }
            CartController::clear();
//            if($request->payment_method=='stripe'){
//                return redirect('/checkout/stripe/'.$order->id);
//            }
//            if($request->payment_method=='paypal'){
//                return redirect(route('store-payment-process', $order->id));
//            }
            //return redirect(route('store-payment-process', $order->id));
          //  return view('store.checkout.thank-you')->withData($this->data);

        }else{
            Session::flash('error', 'Something went wrong! Please try again.');
            return redirect()->back();
        }

    }

//	public function addShipping(Request $request)
//    {
//        $this->data['shipping_method'] = [];
//        CartController::removeConditionsByType('shipping');
//        if($request->method_id){
//            Session::forget('shipping_method_applied');
//            Session::put('shipping_method_applied', $request->method_id);
//            $this->data['shipping_method'] = ShippingMethod::where('id', $request->method_id)->where('status', 1)->first();
//        }elseif($this->data['shipping_methods'] && $this->data['shipping_methods']->count() == 1){
//            $this->data['shipping_method'] = $this->data['shipping_methods']->first();
//        }elseif (Session::has('shipping_method_applied')){
//            $this->data['shipping_method'] = ShippingMethod::where('id', Session::get('shipping_method_applied'))->where('status', 1)->first();
//        }
//        // add condition to only apply on totals, not in subtotal
//        if ($this->data['shipping_method']){
//            $conditionShipping = new CartCondition(array(
//                'name' => $this->data['shipping_method']->carrier.' - '.$this->data['shipping_method']->title,
//                'type' => 'shipping',
//                'target' => 'total', // this condition will be applied to cart's total when getTotal() is called.
//                'value' => '+'.$this->data['shipping_method']->price,
//                'order' => 1 // the order of calculation of cart base conditions. The bigger the later to be applied.
//            ));
//            CartController::condition($conditionShipping);
//        }
//        //session()->put();
//        if($request->method_id){
//            $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
//            $this->data['cart_total'] = $this->cart->getCartTotal();
//            $this->data['shipping_cost'] = $this->cart->getCartShippingCost();
//            return json_encode(
//                array(
//                    'status' => true,
//                    'html' => view('store.checkout.blocks.total')->withData($this->data)->render()
//                )
//            );
//        }
//    }




    public function settings(){
        /*config setting*/
        $this->data['setting'] = SettingController::getSettings();
        foreach($this->data['setting'] as $key => $value) {
            Config::set('settings.'.$key, $value);
        }

        /**=== SMTP ===**/
        if(Config::get('settings.config_email_host')){
            Config::set('mail.host', Config::get('settings.config_email_host'));
        }
        if(Config::get('settings.config_email_port')){
            Config::set('mail.port', Config::get('settings.config_email_port'));
        }
        if(Config::get('settings.config_email_encryption_type')){
            Config::set('mail.encryption', Config::get('settings.config_email_encryption_type'));
        }
        if(Config::get('settings.config_email_username')){
            Config::set('mail.username', Config::get('settings.config_email_username'));
        }
        if(Config::get('settings.config_email_password')){
            Config::set('mail.password', Config::get('settings.config_email_password'));
        }
        if(Config::get('settings.config_email_from_address')){
            Config::set('mail.from.address', Config::get('settings.config_email_from_address'));
        }
        if(Config::get('settings.config_email_from_name')){
            Config::set('mail.from.name', Config::get('settings.config_email_from_name'));
        }
        /**=== PAYPAL ===**/
        if(Config::get('settings.config_paypal_client_id')){
            Config::set('paypal.client_id', Config::get('settings.config_paypal_client_id'));
        }
        if(Config::get('settings.config_paypal_secret')){
            Config::set('paypal.secret', Config::get('settings.config_paypal_secret'));
        }
        if(Config::get('settings.config_paypal_mode')){
            Config::set('paypal.settings.mode', Config::get('settings.config_paypal_mode'));
        }
    }
}
