<?php

namespace App\Http\Controllers\Store\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\StringHelper;
use App\Model\UserRole;
use App\UserGuard;
use App\Model\Status;
use Validator, URL;
use App\User;
use App\Repositories\ProductRepository;

use Modules\Products\Entities\Products as Product;
use Modules\Products\Entities\ProductImages;
use Modules\Brands\Entities\Brands;
use Modules\Category\Entities\Category as CategoryModel;
use Cart as CartController;
use Darryldecode\Cart\CartCondition;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;
use Illuminate\Support\Arr;
use DB;
use Hash;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
use App\Models\Countries;
use App\Models\Order;
use App\Models\OrderProduct;

class CustomerDashboard extends Controller {

    private $guard;

   // protected $redirectTo = '/';

    public function __construct(Request $request) {
      // dd('ads');
        $this->middleware('auth');
        //  parent::__construct($request);
        $this->guard ='user';// UserGuard::GUARD_USER;
        $this->product = new ProductRepository();
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Product::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Product::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Product::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->settings();
    }

    public function index() {
       // dd('ads');
        $this->data['user'] = Auth::guard('user')->user();
       // dd($this->data['user']);
        $previous_url = URL::previous();
        if(!strpos($previous_url, 'login')){
            Session::put('from_url', URL::previous());
        }
        return view('store.customer.dashboard')->withData($this->data);
    }
   public function updateprofile(Request $request, $id){
       $input = $request->all();
       if(!empty($input['password'])){
           $input['password'] = Hash::make($input['password']);
       }else{
           $input = Arr::except($input,array('password'));
       }
       if(isset($input['profile_picture'])){
           $input['profile_picture'] = upload_user_image($input);
       }


       $user = User::find($id);
       $user->update($input);
       return redirect('customer/dashboard')
           ->with('success','Profile has been updated successfully');


   }
   public function customerOrders(){
        $customer_id = Auth::guard('user')->user()->id;
        $this->data['order'] = Order::with('orderProducts')->where('customer_id',$customer_id)->get();
       return view('store.customer.orders')->withData($this->data);

   }
   public function customerOrdersDetails($id){
        $this->data['order'] = Order::find($id);
       $this->data['orderProducts'] = OrderProduct::with('product')->where('order_id',$id)->get();
       return view('store.customer.customerOrdersDetails')->withData($this->data);


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
