<?php
namespace App\Http\Controllers\Store\Checkout;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use App\Http\Controllers\Store\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Store\Checkout\Cart;
use Cart as CartController;

use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment as PayPalPayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session, Config;
use URL;

use App\Mail\Email;
use Mail;

class Payment extends Controller
{
    public $cart;
    private $_api_context;
    public function __construct()
    {
        parent::__construct();
        $this->cart = new Cart();
        /** PayPal api context **/
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
    public function index(Request $request){
        if($request->post() && !$request->order){
           //dd($request->all());
            /*if($request->order){
                $order = Order::where('id', $request->order)->first();
            }else{}*/
            $items = $this->cart->getItems();
            if($items->count() && Session::has('shipping_address') && Session::has('shipping_method_applied')) {
                $shippingAddress = ShippingAddress::where('id', Session::get('shipping_address')->id)->first();
                $totalItems = $items->count();
                $subTotal = $this->cart->getCartSubTotal();
                $discount = $this->cart->getCartDiscount();
                $shipping = $this->cart->getCartShippingCost();
                $total = $this->cart->getCartTotal();

                $order = new Order();
                $order->total_items = $totalItems;
                $order->sub_total = $subTotal;
                $order->discount = $discount;
                $order->shipping = $shipping;
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
                $order->save();

                if($order){
                    foreach ($items as $item){
                        //$attributes = $item->attributes; // the attributes
                        $orderProducts = new OrderProduct();
                        $orderProducts->order_id = $order->id;
                        $orderProducts->product_id = $item->id;
                        $orderProducts->quantity = $item->quantity;
                        $orderProducts->total_price = $item->price;
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
                    }
                }
                if($request->payment_method=='stripe'){
                    return redirect('/checkout/stripe/'.$order->id);
                }
                if($request->payment_method=='paypal'){
                    return redirect(route('store-payment-process', $order->id));
                }



            }else{
                Session::flash('error', 'Something went wrong! Please try again.');
                return redirect()->route('store-payment');
            }
        }else{
            $this->data['items'] = $this->cart->getItems();
            if($this->data['items']->count() && Session::has('shipping_address') && Session::has('shipping_method_applied')){
                $this->data['cart'] = [];
                $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
                $this->data['cart_total'] = $this->cart->getCartTotal();
                return view('store.checkout.payment')->withData($this->data);
            }else{
                Session::flash('error', 'Something went wrong! Please try again.');
                return redirect()->route('store-cart-index');
            }
        }
    }
    public function process(Request $request)
    {   //dd($request->order);
        if($request->order){
            $order = Order::where('id', $request->order)->first();
            $orderItems = $order->orderProducts()->get();
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $item_list = new ItemList();
            if($orderItems){
                foreach ($orderItems as $orderItem){
                    $item_1 = new Item();
                    $item_1->setName($orderItem->product()->first()->title)
                        ->setSku($orderItem->product()->first()->sku)
                        ->setCurrency('USD')
                        ->setQuantity($orderItem->quantity)
                        ->setPrice($orderItem->price);

                    $item_list->addItem($item_1);
                }
            }
            /*if(!is_null($order->discount) && $order->discount != 0){
                $item_1 = new Item();
                $item_1->setName('Discount')
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($order->discount);

                $item_list->addItem($item_1);
            }*/

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($order->total)
                ->setDetails(array(
                    "subtotal" => $order->sub_total,
                    "tax" => $order->tax,
                    "shipping" => $order->shipping,
                    "shipping_discount" => $order->discount,
                ));

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setItemList($item_list)
                ->setDescription('Your transaction description');

            $redirect_urls = new RedirectUrls();
            $redirect_urls->setReturnUrl(route('store-payment-status', $request->order)) /** Specify return URL **/
            ->setCancelUrl(route('store-payment', $request->order));
            $payment = new PayPalPayment();
            $payment->setIntent('Sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirect_urls)
                ->setTransactions(array($transaction));

            /** dd($payment->create($this->_api_context));exit; **/
            try {
                $payment->create($this->_api_context);
            } catch (\PayPal\Exception\PPConnectionException $ex) {
                if (Config::get('app.debug')) {
                    Session::flash('error', 'Connection timeout');
                    return redirect(route('store-payment', $request->order));
                } else {
                    Session::flash('error', 'Some error occur, sorry for inconvenient '.$ex->getMessage());
                    return redirect(route('store-payment', $request->order));
                }
            }
            foreach ($payment->getLinks() as $link) {
                if ($link->getRel() == 'approval_url') {
                    $redirect_url = $link->getHref();
                    break;
                }
            }
            /** add payment ID to session **/
            Session::flash('paypal_payment_id', $payment->getId());
            if (isset($redirect_url)) {
                /** redirect to paypal **/
                return Redirect::away($redirect_url);
            }
            Session::flash('error', 'Unknown error occurred');
            return redirect(route('store-payment', $request->order));
        }else{
            Session::flash('error', 'Unknown error occurred');
            return redirect(route('store-payment'));
        }
    }
    public function status(Request $request)
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            Session::flash('error', 'Payment failed');
            return redirect(route('store-payment'));
        }
        $payment = PayPalPayment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            /* Save order in database */
            $order = Order::where('id', $request->order)->first();
            $order->update(['is_paid' => 1]);

            $this->data['order'] = $order;
            if($this->data['order']){
                $this->data['items'] = $this->data['order']->orderProducts()->get();
            }
            $this->data['admin'] = false;
            $this->data['subject'] = "Order Placed | ".config('app.name');
            $this->data['view'] = 'store.emails.order';
            $emails = $this->data['order']->billing_email;
            if(!is_null($this->data['order']->ship_email)){
                $emails .= ','.trim($this->data['order']->ship_email);
            }
            $emails = explode(",", $emails);
            Mail::to($emails)->send(new Email($this->data));

            $this->data['admin'] = true;
            $this->data['subject'] = "A new order is received | ".config('app.name');
            $emails = explode(",", preg_replace('/\s+/', '', config('settings.config_order_emails')));
            Mail::to($emails)->send(new Email($this->data));

            //Clear cart and cart sessions
            CartController::clear();
            CartController::clearCartConditions();
            Session::forget('shipping_address');
            Session::forget('shipping_method_applied');

            Session::flash('success', 'Payment success');
            return redirect(route('store-payment-success', $request->order));
        }
        Session::flash('error', 'Payment failed');
        return redirect(route('store-payment', $request->order));
    }

    public function success(Request $request)
    {
        $this->data['order'] = Order::where('id', $request->order)->first();
        if($this->data['order']){
            $this->data['items'] = $this->data['order']->orderProducts()->get();
            return view('store.checkout.thank-you')->withData($this->data);
        }
        return redirect(route('store-index'));
    }
}
