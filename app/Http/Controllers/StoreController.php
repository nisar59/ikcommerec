<?php
namespace App\Http\Controllers;
use Modules\Slides\Entities\Sliders;
use Modules\Category\Entities\Category;
use Modules\Products\Entities\Products;
use Modules\Brands\Entities\Brands;
use Modules\Settings\Entities\Settings;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;
use Illuminate\Http\Request;
use App\Models\Order;

class StoreController extends Controller
{
//    public $sizes;
//    public $colors;
//    public $styles;
//    public $materials;
//    public $shapes;
//    public $testimonials;
    public function __construct()
    {
        //parent::__construct();
//        $this->sizes = new SizeRepository();
//        $this->colors = new ColorRepository();
//        $this->shapes = new ShapeRepository();
//        $this->testimonials = new TestimonialsRepository();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);
        $this->data['manu_categories'] = Category:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->settings();
    }
    public function index()
    {
        $this->data['sliders'] = Sliders:: where('status',1)->orderBy('sort_order','desc')->get();

        $this->data['home_banner_categories'] = Category:: with(['childs.permalink'])->where(['status'=>1,'featured'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get()->take(4);

  //dd($this->data);
        return view('store.index')->withData($this->data);
    }
    public function orderTracking(){
        return view('store.order-tracking')->withData($this->data);

    }
    public function postorderTracking(Request $request){
        $record = $request->all();
        $this->data['order'] = Order::where(['id'=>$record['orderid'],'billing_email'=>$record['email']])->first();
        if($this->data['order']){
            $this->data['orderStatus'] = 'Dear User ,<br/>    order No.' . $record['orderid'] . '  status is ' . $this->data['order']->order_status;

        }else{
            $this->data['orderStatus'] ='Sorry no record is found against order No.' .$record['orderid'];

        }

        return view('store.postordertrack')->withData($this->data);
       // dd($record);

    }

    public function sitemap()
    {
        $this->data['pages'] = Post::with('uri')->where(['type' => 'page', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['productscategories'] = Category::with('uri')->where(['type' => 'product', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['basecolors'] = BaseColor::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['sizes'] = Size::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['styles'] = Style::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['shapes'] = Shape::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['materials'] = Pile::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['blogcategories'] = Category::with('uri')->where(['type' => 'blog', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['blogs'] = Post::with('uri')->where(['type' => 'blog', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['types'] = Type::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['products'] = Product::with('uri')->where(['product_status_id' => 1])->orderBy('created_at', 'desc')->get();
        return view('store.sitemap')->withData($this->data);


    }

    public function sitemapxml()
    {
        $this->data['pages'] = Post::with('uri')->where(['type' => 'page', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['productscategories'] = Category::with('uri')->where(['type' => 'product', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['basecolors'] = BaseColor::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['sizes'] = Size::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['styles'] = Style::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['shapes'] = Shape::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['materials'] = Pile::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['blogcategories'] = Category::with('uri')->where(['type' => 'blog', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['blogs'] = Post::with('uri')->where(['type' => 'blog', 'status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['types'] = Type::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['designs'] = Design::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        $this->data['piles'] = Pile::with('uri')->where(['status' => 1])->orderBy('created_at', 'desc')->get();
        // $this->data['products'] = Product::with('uri')->where(['product_status_id' => 1])->orderBy('created_at', 'desc')->get();
        // return view('store.sitemapxml')->withData($this->data)->header('Content-Type', 'text/xml');
        $this->data['products'] = URL::where(['model' => 'Product()'])->orderBy('created_at', 'desc')->get();

        // return Response::make($content, 200)->header('Content-Type', 'application/xml');

        return response()->view('store.sitemapxml', ['pages'=>$this->data['pages'],
            'productscategories'=>$this->data['productscategories'],
            'basecolors'=>$this->data['basecolors'],
            'sizes'=>$this->data['sizes'],
            'styles'=>$this->data['styles'],
            'shapes'=>$this->data['shapes'],
            'designs'=>$this->data['designs'],
            'piles'=>$this->data['piles'],
            'materials'=>$this->data['materials'],
            'blogcategories'=>$this->data['blogcategories'],
            'blogs'=>$this->data['blogs'],
            'typess'=>$this->data['types'],
            'products'=>$this->data['products'],
        ])->header('Content-Type', 'text/xml') ;



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
