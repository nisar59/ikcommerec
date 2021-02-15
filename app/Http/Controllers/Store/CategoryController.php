<?php
namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Modules\Category\Entities\Category as CategoryModel;

//use App\Repositories\ColorRepository;
//use App\Repositories\MaterialRepository;
use App\Repositories\ProductRepository;
//use App\Repositories\ShapeRepository;
//use App\Repositories\SizeRepository;
//use App\Repositories\StyleRepository;
//use App\Repositories\WeaveRepository;
use Modules\Products\Entities\Products;
use Modules\Brands\Entities\Brands;
class CategoryController extends Controller
{

//    public $weaves;
//    public $sizes;
//    public $colors;
//    public $styles;
//    public $materials;
//    public $shapes;
    public $product;

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
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);


    }
    public function index(Request $request)
    { //dd('hashdsh');
        $this->data['category'] = CategoryModel::where('slug', $request->slug)->first();
       // $this->data['sizes'] = $this->sizes->getActiveSizes();
        //$this->data['colors'] = $this->colors->getActiveColors();
       // $this->data['styles'] = $this->styles->getActiveStyles();
      //  $this->data['materials'] = $this->materials->getActiveMaterials();
       // $this->data['weaves'] = $this->weaves->getActiveWeaves();
       // $this->data['shapes'] = $this->shapes->getActiveShapes();

        $arguments = array(
            'keyword' => null,
            'category' => ($this->data['category'] ? $this->data['category']->id : null),
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
        );

        $this->data['name'] = ($this->data['category'] ? $this->data['category']->title : "Category");
        $this->data['by'] = "Category";

        $products = $this->product->getListingProducts($arguments);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];

        return view('store.product.index')->withData($this->data);
    }
    public function detail(Request $request, $id)
    {

        $this->data['content'] = $this->data['category'] = CategoryModel::where('id', $id)->first();
        $this->data['content']->short_description = $this->data['content']->short_decription;
        $arguments = array(
            'category' => $id,
        );

        $this->data['title'] = ($this->data['category'] ? $this->data['category']->title : "Category");
        $this->data['by'] = "Category";


        $products = $this->product->getListingProducts($arguments, $request);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];
        $this->data['from'] = $products['from'];
        $this->data['to'] = $products['to'];
//        $this->data['sizes'] = $products['sizes'];
//        $this->data['colors'] = $products['colors'];
//        $this->data['styles'] = $products['styles'];
//        $this->data['materials'] = $products['materials'];
//        $this->data['weaves'] = $products['weaves'];
//        $this->data['piles'] = $products['piles'];
//        $this->data['designs'] = $products['designs'];
        $this->data['price_from'] = $products['price_from'];
        $this->data['price_to'] = $products['price_to'];
        $this->data['cat_featured_products'] = $this->data['category']->products()->where('featured',1)->get();
        $this->data['latest_products'] = Products::orderBy('created_at','desc')->get()->take(5);
        //dd($this->data);
        return view('store.product.index')->withData($this->data);
    }
    public function searchdetail(Request $request)
    {
       if(isset($request->category) && !empty($request->category)  ){
        $this->data['content'] = $this->data['category'] = CategoryModel::where('id', $request->category)->first();
        $this->data['content']->short_description = $this->data['content']->short_decription;
        $arguments = array(
            'category' => $request->category,
        );

        $this->data['title'] = ($this->data['category'] ? $this->data['category']->title : "Category");
        $this->data['by'] = "Category";
    }else{

           $arguments = [];
       }

        $products = $this->product->getListingProducts($arguments, $request);
        $this->data['products'] = $products['items'];
        $this->data['total_products'] = $products['total'];
        $this->data['from'] = $products['from'];
        $this->data['to'] = $products['to'];
//        $this->data['sizes'] = $products['sizes'];
//        $this->data['colors'] = $products['colors'];
//        $this->data['styles'] = $products['styles'];
//        $this->data['materials'] = $products['materials'];
//        $this->data['weaves'] = $products['weaves'];
//        $this->data['piles'] = $products['piles'];
//        $this->data['designs'] = $products['designs'];
        $this->data['price_from'] = $products['price_from'];
        $this->data['price_to'] = $products['price_to'];
       // $this->data['cat_featured_products'] = $this->data['category']->products()->where('featured',1)->get();
        $this->data['latest_products'] = Products::orderBy('created_at','desc')->get()->take(5);
        //dd($this->data);
        return view('store.product.searched')->withData($this->data);
    }
}
