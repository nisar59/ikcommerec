<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
//use App\Models\Design;
//use App\Models\Material;
//use App\Models\Pile;
//use App\Models\Shape;
//use App\Models\Size;
//use App\Models\Style;
//use App\Models\Color;
//use App\Models\BaseColor;
//use App\Models\Weave;
use App\URL;
use http\Env\Request;
use Illuminate\Support\Facades\DB;
use Carbon;
use App\Model\Status;
use Modules\Brands\Entities\Brands;
use Modules\Products\Entities\Products as Product;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;

class ProductRepository {

    protected $prefix;

    public function __construct() {
        $this->prefix = DB::getTablePrefix();
        $settingsobj  = new SettingController();
        $this->data['setting'] = $settingsobj->getSettings();
    }

    public static function getProducts() {
        //$data[null] = 'Please Select';
        $data = Product::where('product_status_id', Status::STATUS_ACTIVE)->pluck('title', 'id');
        return collect([null => 'Please Select Product'] + $data->all());
    }

    public static function getRelatedProducts($id) {
        $related_product_ids = Product::where('id', $id)->pluck('related_products')->first();

        if($related_product_ids){
            $products = Product::where('quantity', '>', 0)->whereIn('id', explode(',', $related_product_ids))->get();
            $data = array();
            if (!empty($products)) {

                foreach ($products as $model) {
                    $nestedData['value'] = $model->id;
                    $nestedData['text'] = str_replace("'", "", $model->title);
                    $data[] = $nestedData;
                }
            }
            return json_encode($data);
        }
    }

    public static function getFeaturedProducts($limit = 12) {
        return Product::where('product_status_id', Status::STATUS_ACTIVE)->where('quantity', '>', 0)->where('is_featured', 1)->limit($limit)->get();
    }

    public static function getOnSaleProducts($limit = 12) {
        return Product::where('products.product_status_id', Status::STATUS_ACTIVE)
            ->where('products.quantity', '>', 0)
            ->where('products.discounted_price', '>', 0)
            ->limit($limit)->get();
    }

    public static function getNewProducts($limit = 12) {
        return Product::where('product_status_id', Status::STATUS_ACTIVE)->where('quantity', '>', 0)->orderBy('created_at', 'DESC')->limit($limit)->get();
    }

    public function getListingProducts($arguments = array(), $request){

       // dd( $request->get('range'));
        //$keyword = $arguments['keyword'];
        $brand_id = (isset($arguments['brand_id']) ? $arguments['brand_id'] : null);
        $category = (isset($arguments['category']) ? $arguments['category'] : null);
        //$order = $arguments['order'];
        //$reload = $arguments['reload'];
        //$limit = $arguments['limit'];
        //$offset = $arguments['offset'];
        //$price_range = $arguments['price_range'];
        //$aSizes = $arguments['aSizes'];
        //$aColors = $arguments['aColors'];
        //$aStyles = $arguments['aStyles'];
        //$aMaterials = $arguments['aMaterials'];
        //$aWeaves = $arguments['aWeaves'];
        //$aShapes = $arguments['aShapes'];
        $sale = (isset($arguments['sale']) ? $arguments['sale'] : 0);
        //dd( $category);
        $keyword = $request->get('keyword');
        $limit = $request->get('limit') ? $request->get('limit') : config('variable.DEFAULT_PAGINATION_LIMIT');
        $price_range = $request->get('range') ? $request->get('range') : null;
        $brands = $request->get('brands') ? $request->get('brands') : null;
       // $sizes = $request->get('size') ? $request->get('size') : null;
      //  $colors = $request->get('color') ? $request->get('color') : null;
      //  $styles = $request->get('style') ? $request->get('style') : null;
      //  $materials = $request->get('material') ? $request->get('material') : null;
      //  $weaves = $request->get('weave') ? $request->get('weave') : null;
      //  $shapes = $request->get('shape') ? $request->get('shape') : null;
       // $piles = $request->get('pile') ? $request->get('pile') : null;
       // $designs = $request->get('design') ? $request->get('design') : null;
        $order = $request->get('order');

        //Order of the listing
        $orderColumn = 'products.created_at';
        if(isset($this->data['setting']['config_products_random_sort'])){
            $ord=$this->data['setting']['config_products_random_sort'];

        }else{
           $ord='DESC';
        }
        $orderBy = $ord;
       // $orderBy = 'RAND';
        // dd($orderColumn);
        if($order == 'old'){
            $orderBy = 'ASC';
        }elseif($order == 'min'){
            $orderColumn = 'products.price';
            $orderBy = 'ASC';
        }elseif($order == 'max'){
            $orderColumn = 'products.price';
            $orderBy = 'DESC';
        }elseif($order == 'size_s2l'){
            $orderColumn = 'products.actual_size';
            $orderBy = 'ASC';
        }elseif($order == 'size_l2s'){
            $orderColumn = 'products.actual_size';
            $orderBy = 'DESC';
        }

        $products = Product::with('permalink');
        //$products = Product::with('uri');

        //Category
        if(!empty($category)){
            $products->join('product_categories', 'product_categories.product_id', '=', 'products.id');
            $products->where('product_categories.category_id', $category);
        }

        //KeyWord
        if(!empty($keyword)){
            $products->where(function ($query) use ($keyword) {
                $query->where('products.name', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('products.short_description', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('products.description', 'LIKE', '%'.$keyword.'%' );
            } );
        }

        if($brands){

            $aSIDs = Brands::whereIn('name', $this->strToArray($brands))->pluck('id')->toArray();
            $products->whereIn('products.brand_id', $aSIDs);
        }
        if($sale){
            $products->whereNotNull('products.sale_price');
            //$products->where('warehouse_product_stocks.quantity', '>', 0);
        }

//        //Sizes filter
//        if(!is_null($sizes)){
//            $aSIDs = Size::whereIn('name', $this->strToArray($sizes))->pluck('id')->toArray();
//            $products->whereIn('products.size_id', $aSIDs);
//        }
//
//        //Color filter
//        if(!is_null($colors)){
//            $aCIDs = BaseColor::whereIn('name', $this->strToArray($colors))->pluck('id')->toArray();
//            $products->whereIn('products.base_color_id', $aCIDs);
//        }
//
//        //Styles filter
//        if(!is_null($styles)){
//            $aSIDs = Style::whereIn('name', $this->strToArray($styles))->pluck('id')->toArray();
//            $products->whereIn('products.style_id', $aSIDs);
//        }
//
//        //Material Pile filter
//        if(!is_null($materials)){
//            $aMIDs = Material::whereIn('name', $this->strToArray($materials))->pluck('id')->toArray();
//            $products->whereIn('products.material_id', $aMIDs);
//        }
//
//        //Weave filter
//        if(!is_null($weaves)){
//            $aWIDs = Weave::whereIn('name', $this->strToArray($weaves))->pluck('id')->toArray();
//            $products->whereIn('products.weave_id', $aWIDs);
//        }
//
//        //Shape filter
//        if(!is_null($shapes)){
//            $aSHIDs = Shape::whereIn('name', $this->strToArray($shapes))->pluck('id')->toArray();
//            $products->whereIn('products.shape_id', $aSHIDs);
//        }
//
//        //Pile filter
//        if(!is_null($piles)){
//            $aPIIDs = Pile::whereIn('name', $this->strToArray($piles))->pluck('id')->toArray();
//            $products->whereIn('products.pile_id', $aPIIDs);
//        }
//
//        //Design filter
//        if(!is_null($designs)){
//            $aDIDs = Design::whereIn('name', $this->strToArray($designs))->pluck('id')->toArray();
//            $products->whereIn('products.design_id', $aDIDs);
//        }

        //Price range
        if(!is_null($price_range)){
            $rang = explode(';', $price_range);
            //$products->where('products.discounted_price', '>=', $rang[0]);
            $products->where('products.price', '>=', $rang[0]);
            /*$products->where(function ($query) use ($rang) {
                $query->where('products.sale_price', '>=', $rang[0]);
                $query->orWhere('products.discounted_price', '>=', $rang[0]);
            });*/
            if(isset($rang[1])){
                //$products->where('products.discounted_price', '<=', $rang[1]);
                $products->where('products.price', '<=', $rang[1]);
                /*$products->where(function ($query) use ($rang) {
                    $query->where('products.sale_price', '<=', $rang[1]);
                    $query->orWhere('products.discounted_price', '<=', $rang[1]);
                });*/
            }
        }

        //Order by
        if($order == 'max' || $order == 'min'){
            $products->orderBy('products.sale_price', $orderBy);
        }


        //$products->where('products.product_status_id',  Status::STATUS_ACTIVE);
        $products->where('products.status',  1);
        $products->where('quantity', '>', 0);
        $products->where('price','>',0);
        //$products->select('warehouse_product_stocks.*', 'products.*');
        //$products->groupBy('products.sku');
        //dd($orderBy);
       if($orderBy == 'RAND')
       {
           $products->orderByRaw('RAND()');
       }else
       {
           $products->orderBy($orderColumn, $orderBy);
       }


        /*=============*/
        $all_pro_ids = Product::where('quantity', '>', 0)->where('products.status',  1)->pluck('products.id')->toArray();
        /*$sizesObj = Size::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('sizes.id', 'sizes.name')->join('products', 'sizes.id', '=', 'products.size_id')->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1)->where('sizes.status', 1);

        $colorsObj = BaseColor::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('base_colors.id', 'base_colors.name')->join('products', 'base_colors.id', '=', 'products.base_color_id')->whereIn('products.id', $all_pro_ids)->where('base_colors.status', 1);

        $stylesObj = Style::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('styles.id', 'styles.name')->join('products', 'styles.id', '=', 'products.style_id')->whereIn('products.id', $all_pro_ids)->where('styles.status', 1);

        $materialsObj = Material::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('materials.id', 'materials.name')->join('products', 'materials.id', '=', 'products.material_id')->whereIn('products.id', $all_pro_ids)->where('materials.status', 1);

        $pilesObj = Pile::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('piles.id', 'piles.name')->join('products', 'piles.id', '=', 'products.pile_id')->whereIn('products.id', $all_pro_ids)->where('piles.status', 1);

        $designsObj = Design::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('designs.id', 'designs.name')->join('products', 'designs.id', '=', 'products.design_id')->whereIn('products.id', $all_pro_ids)->where('designs.status', 1);

        $weavesObj = Weave::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('weaves.id', 'weaves.name')->join('products', 'weaves.id', '=', 'products.weave_id')->whereIn('products.id', $all_pro_ids)->where('weaves.status', 1);*/

//        $sizesObj = Size::select('sizes.id', 'sizes.name')->join('products', 'sizes.id', '=', 'products.size_id')->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1)->where('sizes.status', 1);
//
//        $colorsObj = BaseColor::select('base_colors.id', 'base_colors.name')->join('products', 'base_colors.id', '=', 'products.base_color_id')->whereIn('products.id', $all_pro_ids)->where('base_colors.status', 1);
//
//        $stylesObj = Style::select('styles.id', 'styles.name')->join('products', 'styles.id', '=', 'products.style_id')->whereIn('products.id', $all_pro_ids)->where('styles.status', 1);
//
//        $materialsObj = Material::select('materials.id', 'materials.name')->join('products', 'materials.id', '=', 'products.material_id')->whereIn('products.id', $all_pro_ids)->where('materials.status', 1);
//
//        $pilesObj = Pile::select('piles.id', 'piles.name')->join('products', 'piles.id', '=', 'products.pile_id')->whereIn('products.id', $all_pro_ids)->where('piles.status', 1);
//
//        $designsObj = Design::select('designs.id', 'designs.name')->join('products', 'designs.id', '=', 'products.design_id')->whereIn('products.id', $all_pro_ids)->where('designs.status', 1);
//
//        $weavesObj = Weave::select('weaves.id', 'weaves.name')->join('products', 'weaves.id', '=', 'products.weave_id')->whereIn('products.id', $all_pro_ids)->where('weaves.status', 1);
        /*=============*/
        $to = $total = $products->count();

        $page = $request->get('page');
        $to = $total > $limit ? $limit : $to;
        $from = $page && $page != 1 ? $limit*($page-1) : 0;
        $to = $from > 1 ? $to+$from : $to;
        return array(
            'total' => $total,
            'page' => $page,
            'from' => $from+1,
            'to' => $to,
           // 'sizes' => $sizesObj->orderByRaw('LENGTH(name)', 'ASC')->orderBy('name', 'ASC')->groupBy('sizes.id')->get(),
           // 'colors' => $colorsObj->orderBy('base_colors.name', 'ASC')->groupBy('base_colors.id')->get(),
           // 'styles' => $stylesObj->orderBy('styles.name', 'ASC')->groupBy('styles.id')->get(),
          //  'materials' => $materialsObj->orderBy('materials.name', 'ASC')->groupBy('materials.id')->get(),
           // 'piles' => $pilesObj->orderBy('piles.name', 'ASC')->groupBy('piles.id')->get(),
           // 'designs' => $designsObj->orderBy('designs.name', 'ASC')->groupBy('designs.id')->get(),
          //  'weaves' => $weavesObj->orderBy('weaves.name', 'ASC')->groupBy('weaves.id')->get(),
            'price_from' => 0, //$all->min('sale_price'),
            'price_to' => 0, //$all->max('sale_price'),
            'items' => $products->paginate($limit),
        );
        //return $products->offset($offset)->limit($limit)->get();
    }

    public function getListingProductsByHeight($arguments = array(), $request){
        // dd('ad');
        //$keyword = $arguments['keyword'];
        $category = (isset($arguments['category']) ? $arguments['category'] : null);
        //$order = $arguments['order'];
        //$reload = $arguments['reload'];
        //$limit = $arguments['limit'];
        //$offset = $arguments['offset'];
        //$price_range = $arguments['price_range'];
        //$aSizes = $arguments['aSizes'];
        //$aColors = $arguments['aColors'];
        //$aStyles = $arguments['aStyles'];
        //$aMaterials = $arguments['aMaterials'];
        //$aWeaves = $arguments['aWeaves'];
        //$aShapes = $arguments['aShapes'];
        $sale = (isset($arguments['sale']) ? $arguments['sale'] : 0);

        $keyword = $request->get('keyword');
        $limit = $request->get('limit') ? $request->get('limit') : config('variable.DEFAULT_PAGINATION_LIMIT');
        $price_range = $request->get('range') ? $request->get('range') : null;
        $sizes = $request->get('size') ? $request->get('size') : null;
        $colors = $request->get('color') ? $request->get('color') : null;
        $styles = $request->get('style') ? $request->get('style') : null;
        $materials = $request->get('material') ? $request->get('material') : null;
        $weaves = $request->get('weave') ? $request->get('weave') : null;
        $shapes = $request->get('shape') ? $request->get('shape') : null;
        $piles = $request->get('pile') ? $request->get('pile') : null;
        $designs = $request->get('design') ? $request->get('design') : null;
        $order = $request->get('order');

        //Order of the listing
        $orderColumn = 'products.created_at';
        if(isset($this->data['setting']['config_products_random_sort'])){
            $ord=$this->data['setting']['config_products_random_sort'];

        }else{
            $ord='DESC';
        }
        $orderBy = $ord;
       // dd($orderBy);
        // $orderBy = 'RAND';
        // dd($orderColumn);
        if($order == 'old'){
            $orderBy = 'ASC';
        }elseif($order == 'min'){
            $orderColumn = 'products.sale_price';
            $orderBy = 'ASC';
        }elseif($order == 'max'){
            $orderColumn = 'products.sale_price';
            $orderBy = 'DESC';
        }elseif($order == 'size_s2l'){
            $orderColumn = 'products.actual_size';
            $orderBy = 'ASC';
        }elseif($order == 'size_l2s'){
            $orderColumn = 'products.actual_size';
            $orderBy = 'DESC';
        }

        $products = Product::with('uri');

        //Category
        if(!empty($category)){
            $products->join('product_categories', 'product_categories.product_id', '=', 'products.id');
            $products->where('product_categories.category_id', $category);
        }

        //KeyWord
        if(!empty($keyword)){
            $products->where(function ($query) use ($keyword) {
                $query->where('products.title', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('products.short_description', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('products.long_description', 'LIKE', '%'.$keyword.'%' );
            } );
        }

        if($sale){
            $products->whereNotNull('products.discounted_price');
            //$products->where('warehouse_product_stocks.quantity', '>', 0);
        }

        //Sizes filter
        if(!is_null($sizes)){
            $aSIDs = Size::whereIn('name', $this->strToArray($sizes))->pluck('id')->toArray();
            $products->whereIn('products.size_id', $aSIDs);
        }

        //Color filter
        if(!is_null($colors)){
            $aCIDs = BaseColor::whereIn('name', $this->strToArray($colors))->pluck('id')->toArray();
            $products->whereIn('products.base_color_id', $aCIDs);
        }

        //Styles filter
        if(!is_null($styles)){
            $aSIDs = Style::whereIn('name', $this->strToArray($styles))->pluck('id')->toArray();
            $products->whereIn('products.style_id', $aSIDs);
        }

        //Material Pile filter
        if(!is_null($materials)){
            $aMIDs = Material::whereIn('name', $this->strToArray($materials))->pluck('id')->toArray();
            $products->whereIn('products.material_id', $aMIDs);
        }

        //Weave filter
        if(!is_null($weaves)){
            $aWIDs = Weave::whereIn('name', $this->strToArray($weaves))->pluck('id')->toArray();
            $products->whereIn('products.weave_id', $aWIDs);
        }

        //Shape filter
        if(!is_null($shapes)){
            $aSHIDs = Shape::whereIn('name', $this->strToArray($shapes))->pluck('id')->toArray();
            $products->whereIn('products.shape_id', $aSHIDs);
        }

        //Pile filter
        if(!is_null($piles)){
            $aPIIDs = Pile::whereIn('name', $this->strToArray($piles))->pluck('id')->toArray();
            $products->whereIn('products.pile_id', $aPIIDs);
        }

        //Design filter
        if(!is_null($designs)){
            $aDIDs = Design::whereIn('name', $this->strToArray($designs))->pluck('id')->toArray();
            $products->whereIn('products.design_id', $aDIDs);
        }

        //Price range
        if(!is_null($price_range)){
            $rang = explode('-', $price_range);
            //$products->where('products.discounted_price', '>=', $rang[0]);
            $products->where('products.sale_price', '>=', $rang[0]);
            /*$products->where(function ($query) use ($rang) {
                $query->where('products.sale_price', '>=', $rang[0]);
                $query->orWhere('products.discounted_price', '>=', $rang[0]);
            });*/
            if(isset($rang[1])){
                //$products->where('products.discounted_price', '<=', $rang[1]);
                $products->where('products.sale_price', '<=', $rang[1]);
                /*$products->where(function ($query) use ($rang) {
                    $query->where('products.sale_price', '<=', $rang[1]);
                    $query->orWhere('products.discounted_price', '<=', $rang[1]);
                });*/
            }
        }

        //Order by
        if($order == 'max' || $order == 'min'){
            $products->orderBy('products.discounted_price', $orderBy);
        }


        $products->where('products.product_status_id',  Status::STATUS_ACTIVE);
        $products->where('quantity', '>', 0);
        //$products->select('warehouse_product_stocks.*', 'products.*');
       // $products->groupBy('products.sku');
        if($orderBy == 'RAND_HEIGHT')
        {
        // dd('here');
           // $products->orderByRaw('RAND()');
              $products->orderBy('sort_order', 'ASC');
        }else
        {
          //  dd('there');
            $products->orderBy($orderColumn, $orderBy);
        }


        /*=============*/
        $all_pro_ids = Product::where('quantity', '>', 0)->where('products.product_status_id',  Status::STATUS_ACTIVE)->pluck('products.id')->toArray();
        /*$sizesObj = Size::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('sizes.id', 'sizes.name')->join('products', 'sizes.id', '=', 'products.size_id')->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1)->where('sizes.status', 1);

        $colorsObj = BaseColor::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('base_colors.id', 'base_colors.name')->join('products', 'base_colors.id', '=', 'products.base_color_id')->whereIn('products.id', $all_pro_ids)->where('base_colors.status', 1);

        $stylesObj = Style::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('styles.id', 'styles.name')->join('products', 'styles.id', '=', 'products.style_id')->whereIn('products.id', $all_pro_ids)->where('styles.status', 1);

        $materialsObj = Material::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('materials.id', 'materials.name')->join('products', 'materials.id', '=', 'products.material_id')->whereIn('products.id', $all_pro_ids)->where('materials.status', 1);

        $pilesObj = Pile::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('piles.id', 'piles.name')->join('products', 'piles.id', '=', 'products.pile_id')->whereIn('products.id', $all_pro_ids)->where('piles.status', 1);

        $designsObj = Design::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('designs.id', 'designs.name')->join('products', 'designs.id', '=', 'products.design_id')->whereIn('products.id', $all_pro_ids)->where('designs.status', 1);

        $weavesObj = Weave::with(array('products' => function($query) use($all_pro_ids){
            $query->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1);
        }))->select('weaves.id', 'weaves.name')->join('products', 'weaves.id', '=', 'products.weave_id')->whereIn('products.id', $all_pro_ids)->where('weaves.status', 1);*/

        $sizesObj = Size::select('sizes.id', 'sizes.name')->join('products', 'sizes.id', '=', 'products.size_id')->whereIn('products.id', $all_pro_ids)->where('products.product_status_id', 1)->where('sizes.status', 1);

        $colorsObj = BaseColor::select('base_colors.id', 'base_colors.name')->join('products', 'base_colors.id', '=', 'products.base_color_id')->whereIn('products.id', $all_pro_ids)->where('base_colors.status', 1);

        $stylesObj = Style::select('styles.id', 'styles.name')->join('products', 'styles.id', '=', 'products.style_id')->whereIn('products.id', $all_pro_ids)->where('styles.status', 1);

        $materialsObj = Material::select('materials.id', 'materials.name')->join('products', 'materials.id', '=', 'products.material_id')->whereIn('products.id', $all_pro_ids)->where('materials.status', 1);

        $pilesObj = Pile::select('piles.id', 'piles.name')->join('products', 'piles.id', '=', 'products.pile_id')->whereIn('products.id', $all_pro_ids)->where('piles.status', 1);

        $designsObj = Design::select('designs.id', 'designs.name')->join('products', 'designs.id', '=', 'products.design_id')->whereIn('products.id', $all_pro_ids)->where('designs.status', 1);

        $weavesObj = Weave::select('weaves.id', 'weaves.name')->join('products', 'weaves.id', '=', 'products.weave_id')->whereIn('products.id', $all_pro_ids)->where('weaves.status', 1);
        /*=============*/
        $to = $total = $products->count();

        $page = $request->get('page');
        $to = $total > $limit ? $limit : $to;
        $from = $page && $page != 1 ? $limit*($page-1) : 0;
        $to = $from > 1 ? $to+$from : $to;
        //dd($limit);
        // dd($products->paginate($limit));
        $pr = $products->paginate($limit);
       // $pr = $products->paginate(40);
       // dd($products->count());
        $spids ='';
//        $pids =[];
//        foreach($pr as $pr)
//        { //dd($pr->rounded_size);
//            $roundedSize = $pr->sqm;
//            $rounded = (int)$roundedSize;
//            if($rounded >= $this->data['setting']['config_products_height'])
//            {
//                $pids[] =$pr->id;
//            }
//        }
        // dd($pids);
        //$str = implode(",",$pids);
//dd('sad');
       // $prr = Product::whereIn('id',$pids)->orderByRaw('RAND()')->get();
      //  $products->whereNotIn('id',$pids);
        // dd($prr);
        $prr=[];
        return array(
            'total' => $total,
            'page' => $page,
            'from' => $from+1,
            'to' => $to,
            'sizes' => $sizesObj->orderByRaw('LENGTH(name)', 'ASC')->orderBy('name', 'ASC')->groupBy('sizes.id')->get(),
            'colors' => $colorsObj->orderBy('base_colors.name', 'ASC')->groupBy('base_colors.id')->get(),
            'styles' => $stylesObj->orderBy('styles.name', 'ASC')->groupBy('styles.id')->get(),
            'materials' => $materialsObj->orderBy('materials.name', 'ASC')->groupBy('materials.id')->get(),
            'piles' => $pilesObj->orderBy('piles.name', 'ASC')->groupBy('piles.id')->get(),
            'designs' => $designsObj->orderBy('designs.name', 'ASC')->groupBy('designs.id')->get(),
            'weaves' => $weavesObj->orderBy('weaves.name', 'ASC')->groupBy('weaves.id')->get(),
            'price_from' => 0, //$all->min('sale_price'),
            'price_to' => 0, //$all->max('sale_price'),
            'items' => $products->paginate($limit),
            //'items' => $products->paginate(40),
            'sitems' => $prr,
        );
        //return $products->offset($offset)->limit($limit)->get();
    }

    public function getWishListProducts(){
        return Product::whereIn('id', getWishListIds())->where('quantity', '>', 0)->orderBy('created_at', 'DESC')->get();
    }

    public function getListingAutoFill($keyword){
        $products = Product::with('uri')
            ->where('product_status_id', Status::STATUS_ACTIVE)
            ->where('quantity', '>', 0)
            ->where(function ($query) use ($keyword) {
                $query->where(DB::raw('LOWER(title)'), 'LIKE', '%'.strtolower($keyword).'%' );
                /*$query->orWhere('short_description', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('long_description', 'LIKE', '%'.$keyword.'%' );
                $query->orWhere('history', 'LIKE', '%'.$keyword.'%' );*/
            } )
            ->select('id', 'title', 'image', 'sku', 'sale_price', 'discounted_price')
            ->get();
        $resultArray = [];
        if($products){
            foreach ($products as $product){
                $resultArray[] = array(
                    'title' => $product->title,
                    'slug' => $product->uri ? $product->uri->slug : "",
                    'image' => asset(config('image.product.small').$product->sku.'/'.$product->image),
                    'price' => formatCurrency(($product->discounted_price ? $product->discounted_price : $product->sale_price), 'USD'),
                );
            }
        }
        return $resultArray;
    }

    public function strToArray($string){
        return specialCharacter($string);
    }

}
