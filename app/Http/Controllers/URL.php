<?php
namespace App\Http\Controllers;
use Modules\Slides\Entities\Sliders;
use Modules\Category\Entities\Category;
use Modules\Products\Entities\Products;
use Illuminate\Http\Request;
use App\URL as URLModel;
use App\Http\Controllers\Store\CategoryController;
use App\Http\Controllers\Store\PageController as Page;
use App\Http\Controllers\Store\ProductsController;
use Modules\Brands\Entities\Brands;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;

class URL extends Controller
{
	public function __construct()
	{
		//parent::__construct();
	//	$this->randomProductsort();
        $this->settings();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);
	}
	public function index(Request $request)
	{
        //dd('ad');
	    $app_url = URLModel::where('slug', $request->slug)->first();
     //dd($app_url->model);
        if($app_url){
            if ($app_url->model == config('variable.BASE_COLOR_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->color($request, $app_url->reference);
                }else{
                    return $variation_obj->colors($request);
                }
            } else if ($app_url->model == config('variable.PRODUCT_MODEL')) {
                //dd('dsa');
                $product_obj = new ProductsController();
                if($app_url->reference){
                    return $product_obj->detail($app_url->reference);
                }else{
                    return $product_obj->index($request);
                }
            }
            else if ($app_url->model == config('variable.BRAND')) {
                //dd('dsa');
                $product_obj = new ProductsController();
                if($app_url->reference){
                    return $product_obj->brandsProducts($request,$app_url->reference);
                }else{
                    return $product_obj->index($request);
                }
            }

            else if ($app_url->model == config('variable.PRODUCT_CAT_MODEL')) {
                $prod_cat_obj = new CategoryController();
                return $prod_cat_obj->detail($request, $app_url->reference);
            }  else if ($app_url->model == config('variable.DESIGN_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->design($request, $app_url->reference);
                }else{
                    return $variation_obj->designs($request);
                }
            }  else if ($app_url->model == config('variable.STYLE_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->style($request, $app_url->reference);
                }else{
                    return $variation_obj->styles($request);
                }
            }  else if ($app_url->model == config('variable.SHAPE_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->shape($request, $app_url->reference);
                }else{
                    return $variation_obj->shapes($request);
                }
            }  else if ($app_url->model == config('variable.SIZE_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->size($request, $app_url->reference);
                }else{
                    return $variation_obj->sizes($request);
                }
            }  else if ($app_url->model == config('variable.TYPE_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->type($request, $app_url->reference);
                }else{
                    return $variation_obj->types($request);
                }
            }  else if ($app_url->model == config('variable.PILE_MODEL')) {
                $variation_obj = new Variations();
                if($app_url->reference){
                    return $variation_obj->pile($request, $app_url->reference);
                }else{
                    return $variation_obj->piles($request);
                }
            }  else if ($app_url->model == config('variable.CATEGORY_MODEL')) {
                $prod_cat_obj = new CategoryController();
               // dd('ad');
                return $prod_cat_obj->detail($request, $app_url->reference);
            } else if ($app_url->model == config('variable.BLOG_MODEL')) {
                $prod_cat_obj = new Post();
                return $prod_cat_obj->detail($request, $app_url->reference);
            } else if ($app_url->model == config('variable.CMS_MODEL')) {
                $prod_cat_obj = new Page();
               // dd($app_url->reference);
                return $prod_cat_obj->detail($request, $app_url->reference);
            }  else {
                // redirect to home
            }
        }else{
           // return view('store.errors.404')->withData($this->data);
            return redirect()->route('store-index');
            
        }
	}
	public function searchindex(Request $request){
	   // dd($request->all());
        $prod_cat_obj = new CategoryController();
        // dd('ad');
        return $prod_cat_obj->searchdetail($request);
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
