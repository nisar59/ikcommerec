<?php
namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category as CategoryModel;
use Modules\Products\Entities\Products as Product;

//use App\Repositories\ColorRepository;
//use App\Repositories\MaterialRepository;
use App\Repositories\ProductRepository;
//use App\Repositories\ShapeRepository;
//use App\Repositories\SizeRepository;
//use App\Repositories\StyleRepository;
//use App\Repositories\WeaveRepository;
use Modules\Products\Entities\Products;
use Modules\Brands\Entities\Brands;
use Modules\Variations\Entities\Variation;
use Modules\Variations\Entities\VariationValues;
use Modules\Category\Entities\ProductCatagory;
use Modules\Products\Entities\ProductsWarehouseStocks;
use App\Compare;
use App\URL;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;

class ProductsController extends Controller
{
//    public $weaves;
//    public $sizes;
//    public $colors;
//    public $styles;
//    public $materials;
//    public $shapes;
//    public $product;
//    public $testimonials;
    public function __construct()
    {
       // parent::__construct();
//        $this->weaves = new WeaveRepository();
//        $this->sizes = new SizeRepository();
//        $this->colors = new ColorRepository();
//        $this->styles = new StyleRepository();
//        $this->materials = new MaterialRepository();
//        $this->shapes = new ShapeRepository();
       $this->product = new ProductRepository();
//        $this->testimonials = new TestimonialsRepository();
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->settings();
    }
    public function index(Request $request)
    {
        /*$this->data['sizes'] = $this->sizes->getActiveSizes();
        $this->data['colors'] = $this->colors->getBaseColors();
        $this->data['styles'] = $this->styles->getActiveStyles();
        $this->data['materials'] = $this->materials->getActiveMaterials();
        $this->data['weaves'] = $this->weaves->getActiveWeaves();
        $this->data['shapes'] = $this->shapes->getActiveShapes();*/

        $arguments = array(
            'keyword' => $request->keyword,
            'category' => null,
        );

        $products = $this->product->getListingProducts($arguments, $request);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];
        $this->data['from'] = $products['from'];
        $this->data['to'] = $products['to'];
        $this->data['sizes'] = $products['sizes'];
        $this->data['colors'] = $products['colors'];
        $this->data['styles'] = $products['styles'];
        $this->data['materials'] = $products['materials'];
        $this->data['weaves'] = $products['weaves'];
        $this->data['piles'] = $products['piles'];
        $this->data['designs'] = $products['designs'];
        $this->data['price_from'] = $products['price_from'];
        $this->data['price_to'] = $products['price_to'];
        return view('store.product.index')->withData($this->data);
    }
    public function sale(Request $request)
    {
        $this->data['sizes'] = $this->sizes->getActiveSizes();
        $this->data['colors'] = $this->colors->getActiveColors();
        $this->data['styles'] = $this->styles->getActiveStyles();
        $this->data['materials'] = $this->materials->getActiveMaterials();
        $this->data['weaves'] = $this->weaves->getActiveWeaves();
        $this->data['shapes'] = $this->shapes->getActiveShapes();

        $arguments = array(
            'keyword' => $request->keyword,
            'category' => null,
            'order' => 'new',
            'reload' => 1,
            'limit' => config('variable.PAGINATION_LIMIT'),
            'offset' => 0,
            'price_range' => 0,
            'aSizes' => array(),
            'aColors' => array(),
            'aStyles' => array(),
            'aMaterials' => array(),
            'aWeaves' => array(),
            'aShapes' => array(),
            'sale' => 1,
        );
        $this->data['title'] = "Sale";
        $this->data['by'] = "Sale";
        $this->data['meta'] = array(
            'title' => "Sale",
            'description' => "Sale",
            'keywords' => "Sale",
        );

        $products = $this->product->getListingProducts($arguments);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];
        return view('store.product.index')->withData($this->data);
    }
    public function loadRugs(Request $request)
    {
        $arguments = array(
            'keyword' => $request->keyword,
            'category' => $request->category,
            'order' => $request->sorting_order,
            'reload' => $request->reload,
            'limit' => $request->limit,
            'offset' => $request->offset,
            'price_range' => $request->price_range,
            'aSizes' => $request->sizes,
            'aColors' => $request->colors,
            'aStyles' => $request->styles,
            'aMaterials' => $request->materials,
            'aWeaves' => $request->weaves,
            'aShapes' => array(),
            'sale' => $request->sale,
        );

        $products = $this->product->getListingProducts($arguments);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];

        return json_encode(
            array(
                'total' => $this->data['total_products'],
                'current' => $this->data['products']->count(),
                'data' => view('store.product.blocks.listing_card')->withData($this->data)->render(),
            )
        );
    }



    public function detail($id)
    {
        $product = $this->data['product'] = Product::with('related_products')->where('id', $id)->first();

           $this->data['product']->viewed =$this->data['product']->viewed +1;
        $this->data['product']->save();
        if($this->data['product']){
            if(Session::has('recently_viewed')){
                $index = array_search($id, Session::get('recently_viewed'));
                if($index === false){
                    Session::push('recently_viewed', $id);
                }
            }else{
                Session::put('recently_viewed', array($id));
            }
            $this->data['recently_viewed'] = Product::whereIn('id', Session::get('recently_viewed'))->where('id', '!=', $id)->get();
            $this->data['realted'] = $this->data['product']->related_products();
            $this->data['variation']=Variation::all();
           $this->data['variationvalues']=VariationValues::all();
           $this->data['colorcheck']=ProductsWarehouseStocks::where('p_id',$id)->where('color','!=','')->get();  
           $this->data['sizecheck']=ProductsWarehouseStocks::where('p_id',$id)->where('size','!=','')->get();  
           //dd(count($this->data['sizecheck']));
          $this->data['provariation']=ProductsWarehouseStocks::where('p_id',$id)->get();     
            return view('store.product.detail')->withData($this->data);
        }else{
            return view('store.errors.404')->withData($this->data);
        }

    }


















    public function brandsProducts(Request $request,$id)
    {
        $this->data['brand'] = Brands::find($id);
        $arguments = array(
            'brand_id' => $id,
            'category' => null,
        );

        $products = $this->product->getListingProducts($arguments, $request);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];
        $this->data['from'] = $products['from'];
        $this->data['to'] = $products['to'];
        //$this->data['sizes'] = $products['sizes'];
        //$this->data['colors'] = $products['colors'];
       // $this->data['styles'] = $products['styles'];
       // $this->data['materials'] = $products['materials'];
       // $this->data['weaves'] = $products['weaves'];
       // $this->data['piles'] = $products['piles'];
       // $this->data['designs'] = $products['designs'];
        $this->data['price_from'] = $products['price_from'];
        $this->data['price_to'] = $products['price_to'];
        $this->data['latest_products'] = Products::orderBy('created_at','desc')->get()->take(5);
        return view('store.product.brands_products')->withData($this->data);


    }
    public function compareremoved($id){
    // dd($id);
     $compare =Compare::where('p_id',$id)->delete();
        return redirect()->back();
    }


    public function compare(Request $request)
    {
       $products = $request->slug;
       $pid = URL::with(['product'])->where('slug', $products)->first()['reference'];



       $compare = new Compare();
       $compare ->p_id = $pid;
       $compare->save();
 // dd($compare);


         //dd(session()->get('cpids'));
      //  dd(session()->has('cpids'));
        $pids = Compare::orderBy('created_at','desc')->pluck('p_id')->toArray();
       // dd($pids);
        $this->data['products'] = Products:: whereIn('id',$pids)->get();
       // dd($this->data['products']);
        $products = explode('-vs-', $products);
        $this->data['product_1'] = $this->data['product_2'] = [];
        $this->data['title'] = '';
        if(isset($products[0])){
            $this->data['uri_1'] = URL::with(['product'])->where('slug', $products[0])->first();
            if($this->data['uri_1'])
            {
                $this->data['product_1'] = $this->data['uri_1']->product;
                if ($this->data['product_1']) {
                    $this->data['title'] = $this->data['product_1']->title . ' Vs ';
                }
            }
        }
        if(isset($products[1])){
            $this->data['uri_2'] = URL::with(['product'])->where('slug', $products[1])->first();
            if($this->data['uri_2'])
            {
                $this->data['product_2'] = $this->data['uri_2']->product;
                if ($this->data['product_2']) {
                    $this->data['title'] .= $this->data['product_2']->title;
                }
            }
        }

        return view('store.product.compare')->withData($this->data);
    }
    public function autoFill(Request $request)
    {
        return $this->product->getListingAutoFill($request->keyword);
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
