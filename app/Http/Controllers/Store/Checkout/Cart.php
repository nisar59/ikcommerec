<?php
namespace App\Http\Controllers\Store\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category as CategoryModel;

use Modules\Variations\Entities\Variation;
use Modules\Variations\Entities\VariationValues;

use App\Repositories\ProductRepository;

use Modules\Products\Entities\Products as Product;
use Modules\Brands\Entities\Brands;

use Cart as CartController;
use Darryldecode\Cart\CartCondition;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;

class Cart extends Controller
{
	public function __construct()
	{

	    //parent::__construct();
        $this->product = new ProductRepository();
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Product::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Product::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Product::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->settings();
    }

	public function index(Request $request){
	    
	     $cartItems=$this->data['items'] =CartController::getContent();
        $this->data['cart'] = [];
        $this->data['cart_sub_total'] = $this->getCartSubTotal();
        $this->data['cart_total'] = $this->getCartTotal();
        //dd($this->data);
        return view('store.checkout.cart')->withData($this->data);
    }
	public function add(Request $request)
	{
	    try{
                     //dd($request->all());

            $itemId = $request->product_id;
	        $product = Product::where('id', $itemId)->first();
	      //  dd($itemId);
	        //$stock = WarehouseProductStock::where('product_id', $itemId)->first();
	        if($product->status != 1){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->name.' is not available.'
                );
                return json_encode($resutlArray);
            }

            if($product->quantity < $request->product_quantity){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->name.' is sold out.'
                );
                return json_encode($resutlArray);
            }
          

        $colorname=VariationValues::where('id',$request->product_color_id)->pluck('value')->first();
        $sizename=VariationValues::where('id',$request->product_size_id)->pluck('value')->first();

            $attributes = array(
                'color_id' => $request->product_color_id ,
                'color_name' => $colorname,
                'size_id' => $request->product_size_id,
                'size_name' => $sizename,
            );
            //dd($attributes);
           /* if($request->product_color_id){

                $itemColorCondition = new CartCondition(array(

                    'name' => $request->product_color_name,
                    'value' => 0,
                    'type' => 'additional',
                    'target' => 'item',
                ));
                array_push($conditions, $itemColorCondition);
            }

            if($request->product_size_id){

                $itemSizeCondition = new CartCondition(array(
                    'name' => 'Size x x x',
                    'value' => 0,
                    'type' => 'additional',
                    'target' => 'item',
                ));
                array_push($conditions, $itemSizeCondition);
            }*/
            //==============

            $cartProduct = CartController::get($itemId);
            if($cartProduct && ((int)$cartProduct['quantity'] + (int)$request->product_quantity) > $product->quantity){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->title.' quantity '.((int)$cartProduct['quantity'] + (int)$request->product_quantity).' is not available.'
                );

                return json_encode($resutlArray);
            }
            if($cartProduct){
                CartController::update($itemId, array(
                    'name' => $product->name, // new item name
                    'price' => $request->product_price, // new item price, price can also be a string format like so: '98.67'
                    'quantity' => $request->product_quantity,
                    'attributes' => $attributes
                   // 'conditions' => $conditions
                ));
            }else{

                $item = array(
                    'id' => (int)$request->product_id,
                    'name' => $product->name,
                    'price' => (int)$request->product_price,
                    'quantity' => (int)$request->product_quantity,
                    'attributes' => $attributes,
                   // 'conditions' => $conditions
                );
                CartController::add($item);
            }

            $cartTotalQuantity = $this->getCartTotalItems();
            $cartSubTotalAmount = $this->getCartSubTotal();
            $cartTotalAmount = $this->getCartTotal();

            $resutlArray = array(
                'status' => true,
                'items' => $cartTotalQuantity,
                'sub_total' => $cartSubTotalAmount,
                'total' => $cartTotalAmount,
                'message' => $product->name.' added to cart.'
            );
            return json_encode($resutlArray);
        }catch (\Exception $e){

	        return json_encode(array('status' => false, 'message' => $e->getMessage()));
        }
	}
	public function addById(Request $request)
	{
	    try{
            $itemId = $request->product_id;
	        $product = Product::where('id', $itemId)->first();
	        //$stock = WarehouseProductStock::where('product_id', $itemId)->first();
	        if($product->status != 1){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->name.' is not available.'
                );
                return json_encode($resutlArray);
            }

            //==============
            $attributes = $conditions = [];
            //==============

            //CartController::session($sessionId)->remove($itemId);
            $cartProduct = CartController::get($itemId);
            $quantity = 1;
            if($cartProduct && ((int)$cartProduct['quantity'] + $quantity) > $product->quantity){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->name.' quantity '.((int)$cartProduct['quantity'] + (int)$quantity).' is not available.'
                );
                return json_encode($resutlArray);
            }
            if($cartProduct){
                CartController::update($itemId, array(
                    'name' => $product->name, // new item name
                    'price' => +($product->sale_price ? $product->sale_price : $product->price), // new item price, price can also be a string format like so: '98.67'
                    'quantity' => +$quantity,
                    'attributes' => $attributes,
                    'conditions' => $conditions
                ));
            }else{
                $item = array(
                    'id' => $request->product_id,
                    'name' => $product->name,
                    'price' => ($product->sale_price ? $product->sale_price : $product->price),
                    'quantity' => $quantity,
                    'attributes' => $attributes,
                    'conditions' => $conditions
                );
                //CartController::session($this->sessionId);
                CartController::add($item);
            }

            $cartTotalQuantity = $this->getCartTotalItems();
            $cartSubTotalAmount = $this->getCartSubTotal();
            $cartTotalAmount = $this->getCartTotal();

            $resutlArray = array(
                'status' => true,
                'items' => $cartTotalQuantity,
                'sub_total' => $cartSubTotalAmount,
                'total' => $cartTotalAmount,
                'message' => $product->name.' Added to cart.'
            );

            return json_encode($resutlArray);
        }catch (\Exception $e){
	        return json_encode(array('status' => false, 'message' => $e->getMessage()));
        }
	}

	public function remove(Request $request)
	{
	    try{
            $itemId = $request->product_id;
            $product = Product::where('id', $itemId)->first();
            if($product){
                $cartProduct = CartController::remove($itemId);

                $cartTotalQuantity = $this->getCartTotalItems();
                $cartSubTotalAmount = $this->getCartSubTotal();
                $cartTotalAmount = $this->getCartTotal();

                $resutlArray = array(
                    'status' => true,
                    'items' => $cartTotalQuantity,
                    'sub_total' => $cartSubTotalAmount,
                    'total' => $cartTotalAmount,
                    'message' => $product->title.' removed from cart.'
                );

                return json_encode($resutlArray);
            }
        }catch (\Exception $e){
	        return json_encode(array('status' => false, 'message' => $e->getMessage()));
        }
	}
	public function updateQuantity(Request $request)
	{
	    try{
            $itemId = $request->product_id;
            $quantity = $request->quantity;
            $product = Product::where('id', $itemId)->first();
            //$stock = WarehouseProductStock::where('product_id', $itemId)->first();

            $cartProduct = CartController::get($itemId);
            $existing = $cartProduct['quantity'];
            $diffQty = $quantity-$existing;
            if($cartProduct && (int)$quantity > $product->quantity){
                $resutlArray = array(
                    'status' => false,
                    'message' => $product->title.' quantity '.(int)$quantity.' is not available.'
                );
                return json_encode($resutlArray);
            }else{
                //$price = $product->discounted_price ? $product->discounted_price : $product->sale_price;
                CartController::update($itemId, array(
                    'name' => $product->name, // new item name
                    //'price' => $unitPrice*($existing+$diffQty),
                    'quantity' => $diffQty,
                ));

                $cartTotalQuantity = $this->getCartTotalItems();
                $cartSubTotalAmount = $this->getCartSubTotal();
                $cartTotalAmount = $this->getCartTotal();

                $resutlArray = array(
                    'status' => true,
                    'items' => $cartTotalQuantity,
                    'sub_total' => $cartSubTotalAmount,
                    'total' => $cartTotalAmount,
                    'message' => 'Cart updated successfully.'
                );
                return json_encode($resutlArray);
            }
        }catch (\Exception $e){
	        return json_encode(array('status' => false, 'message' => $e->getMessage()));
        }
	}
	public function getCartTotalItems(){
	    return CartController::getTotalQuantity();
    }
	public function getCartSubTotal(){
	    return CartController::getSubTotal();
    }
	public function getCartTotal(){
	    return CartController::getTotal();// + $this->getCartShippingCost();
    }
    public function getItems(){
        // then you can:
        $cartItems = CartController::getContent();
        if($cartItems){
            foreach ($cartItems as $item){
                $item->product = Product::where('id', $item->id)->first();
            }
        }
        return $cartItems;
    }
    public function getItem($itemID){
        // then you can:
        $cartItems = CartController::getContent();
        return $cartItems[$itemID];
    }
	public function getCartShippingCost(){
	    $shipping =  $this->getCartShipping();
	    $shipping_total = 0;
	    if($shipping){
	        /*foreach ($shippings as $shipping){
                $shipping_total += ($shipping->getValue() ? (float)$shipping->getValue() : 0);
            }*/
            $shipping_total += ($shipping->getValue() ? (float)$shipping->getValue() : 0);
        }
        return $shipping_total;
    }
	public function getCartShipping(){
	    $shipping = new Shipping();
	    $shipping->addShipping(new Request());
        // To get all applied conditions on a cart, use below:
	    return  CartController::getConditionsByType('shipping')->first();
    }
    
	public function getCartCoupon(){
	    return  CartController::getConditionsByType('coupon')->first();
    }
	public function getCartDiscount(){
        // To get all applied conditions on a cart, use below:
	    $discount = CartController::getConditionsByType('coupon')->first();
	    if($discount){
            $discount_value = $discount->getValue();
            if (strpos($discount_value, '%') !== false) {
                $subtotal = $this->getCartSubTotal();
                $discount_value = str_replace('%', '', $discount_value);
                return $subtotal*((float)$discount_value/100);
            }else{
                return $discount_value;
            }
        }else{
	        return 0;
        }
    }
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
