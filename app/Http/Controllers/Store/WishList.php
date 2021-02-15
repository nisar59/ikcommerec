<?php
namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ProductRepository;
use App\Models\WishList as WishListModel;
use Cookie, Response;
use Modules\Category\Entities\Category as CategoryModel;
use Modules\Products\Entities\Products as Product;
use Modules\Products\Entities\Products;
use Modules\Brands\Entities\Brands;

class WishList extends Controller
{
    public $product;

	public function __construct()
	{
		//parent::__construct();
        $this->product = new ProductRepository();
        $this->data['manu_categories'] = CategoryModel:: with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','desc')->get();
        $this->data['brands'] = Brands::where('status',1)->orderBy('sort_order','desc')->get();
        $this->data['footer_featured'] = Products::where(['status'=>1,'featured'=>1])->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_onsalse'] = Products::where('status',1)->where('sale_price','>',0)->orderBy('sort_order','desc')->get()->take(3);
        $this->data['footer_mostviewed'] = Products::where('status',1)->orderBy('viewed','desc')->get()->take(3);
	}
	public function index(Request $request)
    { //dd('ads');
        $this->data['content'] = new \stdClass();
        $this->data['content']->title = "Wishlist";
        $this->data['content']->meta_title = "Wishlist";
        $this->data['content']->meta_description = "Wishlist";
        $this->data['content']->meta_keywords = "Wishlist";
        $this->data['products'] = $this->product->getWishListProducts();
        return view('store.product.wishlist')->withData($this->data);
    }

	public function addRemove(Request $request)
    {

        $resutlArray = [];
        if(!Auth::guard('user')->user()){
            /*$cookies = cookie()->getQueuedCookies();*/
            /*//dd(cookie()->hasQueued('wishlist'));
            if($request->cookie("wishlist")){
                $cookie_data = $request->cookie("wishlist");
                $cookie_data = unserialize($cookie_data);
                array_push($cookie_data, $request->product_id);
                cookie()->forever("wishlist", serialize($cookie_data));
                dd(serialize($cookie_data));
                //Cookie::queue(cookie('wishlist', serialize($cookie_data), 2628000));
            }else{
                $cookie_data = array($request->product_id);
                cookie()->forever("wishlist", serialize($cookie_data));
            }

            dd($request->cookie("wishlist"));*/


            $resutlArray = array(
                'status' => false,
                'message' => 'Please login/register to add products to your wishlist.'
            );

        }else{

            $product_id = $request->product_id;
            $user_id = Auth::guard('user')->user()->id;

           // if($request->type == 0){
                WishListModel::where('product_id', $product_id)->where('user_id', $user_id)->delete();
           // }else{
              //  dd($request->all());
                $wish_list = WishListModel::firstOrNew(['product_id' => $product_id, 'user_id' => $user_id]);
                $wish_list->product_id = $product_id;
                $wish_list->user_id = $user_id;
                $wish_list->save();
           // }
            $resutlArray = array(
                'status' => true,
                'message' => 'Your favourite list updated successfully.'
            );
        }
        return json_encode($resutlArray);
    }
    
    
    
    	public function Removewishlist(Request $request)
    {

        $resutlArray = [];
        if(!Auth::guard('user')->user()){
            /*$cookies = cookie()->getQueuedCookies();*/
            /*//dd(cookie()->hasQueued('wishlist'));
            if($request->cookie("wishlist")){
                $cookie_data = $request->cookie("wishlist");
                $cookie_data = unserialize($cookie_data);
                array_push($cookie_data, $request->product_id);
                cookie()->forever("wishlist", serialize($cookie_data));
                dd(serialize($cookie_data));
                //Cookie::queue(cookie('wishlist', serialize($cookie_data), 2628000));
            }else{
                $cookie_data = array($request->product_id);
                cookie()->forever("wishlist", serialize($cookie_data));
            }

            dd($request->cookie("wishlist"));*/


            $resutlArray = array(
                'status' => false,
                'message' => 'Please login/register to add products to your wishlist.'
            );

        }else{

            $product_id = $request->product_id;
            $user_id = Auth::guard('user')->user()->id;

           // if($request->type == 0){
                WishListModel::where('product_id', $product_id)->where('user_id', $user_id)->delete();
           // }else{
              //  dd($request->all());
                
           // }
            $resutlArray = array(
                'status' => true,
                'message' => 'Your favourite list updated successfully.'
            );
        }
        return json_encode($resutlArray);
    }
}
