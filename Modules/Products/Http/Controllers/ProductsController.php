<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;
use DB;
use Hash;
use Modules\Products\Entities\Products;
use Modules\WareHouses\Entities\WareHouses;
use Modules\Suppliers\Entities\Suppliers;
use Modules\Category\Entities\Category;
use App\Models\ProductCategory;
use Modules\CMS\Entities\Permalink;
use Modules\Brands\Entities\Brands;
use Modules\Products\Entities\ProductsWarehouseStocks;
use Modules\Products\Entities\ProductImages;
use Modules\Stores\Entities\Stores;
use App\Review;
use App\Models\TransactionalAccounts;
use App\Models\Transactions;
use Modules\Variations\Entities\Variation;
use Modules\Variations\Entities\VariationValues;

class ProductsController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $this->data['user'] = Products::orderBy('sort_order','DESC')->get();
        return view('products::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {   //$this->data['warehouses']=['Select'=>''];
        $this->data['categories']=Category::with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','asc')->get();
        $this->data['brands']=Brands::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['suppliers']=Suppliers::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['warehouses']=WareHouses::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['Variation']=Variation::all();
        $this->data['VariationValues']=VariationValues::all();

        $this->data['related_products']=Products::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        return view('products::backend.create')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug',
            'sku' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'price' => 'required',
            //'sale_price' => 'required',

        ]);

        $variat=Variation::all();



        $cms = new Products();
        if(isset($request->product_doc)){
            $cms->product_doc = uploadFile($request->all(),'public/uploads/products_doc');
          //dd($cms->product_doc);
        }

        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->short_description = $request->input('short_description');
        $cms->slug = make_permalink($request->input('slug'),'permalinks');
        $cms->brand_id =  $request->input('brand_id');
       // $cms->quantity =  $request->input('quantity');

        $cms->supplier_id =  $request->input('supplier_id');

       // $cms->warehouse_id =  $request->input('warehouse_id');
        $cms->purchase_price =  $request->input('purchase_price');
        $cms->sku =  $request->input('sku');
        $cms->weight =  $request->input('weight');
        $cms->price =  $request->input('price');
        $cms->sale_price =  $request->input('sale_price');
        $cms->product_handling_chrages =  $request->input('product_handling_chrages');
        $cms->internal_notes =  $request->input('internal_notes');
       // $cms->required_enroll =  $request->input('required_enroll');
       // $cms->instructor_id =  $request->input('instructor_id');
        $cms->user_id =  auth()->user()->id;

        $cms->sort_order =  MaxSortorder('courses');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        $cms->meta_schema =  $request->input('schema');
         $cms->expiry=$request->input('expiry');
        $cms->status =  1;

        $cms->save();
        $cms->categories()->sync($request->categories);
        $cms->related_products()->sync($request->rel_pro);
        $permalink = new Permalink;
        $permalink->slug = make_permalink($request->input('slug'),'permalinks');
        $permalink->reference = $cms->id;
        $permalink->model = 'PRODUCT';
        $permalink->save();


        if(isset($request->groupstocks) AND $request->input('protype')=='variable'){
            $qty =0;
            foreach($request->groupstocks  as $stocks){

              $qty=$qty+$stocks['quantity'];
               $pws=new ProductsWarehouseStocks;
                     $pws->p_id=$cms->id;
                     $pws->ware_house_id=$stocks['warehouse_id'];
                     $pws->quantity=$stocks['quantity'];
                     $pws->available_quantity=$stocks['quantity'];
                     foreach ($variat as $vari) {
                      $name=$vari->name;
                      $pws->$name=$stocks[$name];

                                         }
                     $pws->save();


            }
         $cms->quantity= $qty;
         $cms->save();
      
        }
        else{
           if(isset($request->groupstocks)){
            $qty =0;
            foreach($request->groupstocks  as $stocks){

              $qty=$qty+$stocks['quantitys'];
               $pws=new ProductsWarehouseStocks;
                     $pws->p_id=$cms->id;
                     $pws->ware_house_id=$stocks['warehouse_ids'];
                     $pws->quantity=$stocks['quantitys'];
                     $pws->available_quantity=$stocks['quantitys'];
                    $pws->save();


            }
         $cms->quantity= $qty;
         $cms->save();
        }
      }

      //  $cmss =TransactionalAccounts::where('supplier_id',$request->input('supplier_id'))->first();

      //  if(!$cmss){
//
       // $cmss = new TransactionalAccounts();

       // $cmss->address = 'At the time of product creation';//$request->input('address');

       // if($request->input('supplier_id')){
          //  $supplier = Suppliers::find($request->input('supplier_id'));

       //     $cmss->account_title = $supplier->name;
        //    $cmss->account_type = 1;
       //     $cmss->supplier_id =  $request->input('supplier_id');
      //  }



      //  $cmss->status =  1;

        //$cmss->save();

      //  }

        //$curdate = date('Y-m-d');
        //$cmst = new Transactions();
        //$cmst->date = $curdate;//$request->input('date');
        //$cmst->voucher_code = maxcashVoucer();
      //  $cmst->transaction_type = $request->input('transaction_type');

        //$cmst->description ='Product Purchases';// $request->input('description');
        //$this->data['accounts'] = TransactionalAccounts :: where('supplier_id',$cms->supplier_id)->first();
       // $cmst->jamah = $this->data['accounts']->account_title;
       // $cmst->jamah_account_id = $this->data['accounts']->id;
       // $cmst->banam_account_id = 5;
        // $this->data['accounts'] = TransactionalAccounts :: find(5);
        //$cmst->banam = $this->data['accounts']->account_title;
        //$cmst->amount =  $request->input('purchase_price');
        //$cmst->save();





        //$cmst = new Transactions();
        //$cmst->date = $curdate;//$request->input('date');
        //$cmst->voucher_code = maxcashVoucer();
        //$cmst->transaction_type = $request->input('transaction_type');
        //$cmst->account_id = 6;
        //$cmst->description = 'Product handling charges';//$request->input('description');
        //$this->data['accounts'] = TransactionalAccounts :: find(6);
        //$cmst->account_title = $this->data['accounts']->account_title;
        //$cmst->banam =  $request->input('product_handling_chrages');
        //$cmst->save();



     return redirect('admin/products')
            ->with('success','Product created successfully');

    }

    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Products::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Product updated successfully');
    }

    public function featuredUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Products::find($id);
        if($user->featured ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->featured =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Product updated successfully');
    }
    public function stocksUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Products::find($id);
        if($user->stock_status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->stock_status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Product updated successfully');
    }

    public function reviewsUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Products::find($id);
        if($user->enable_reviews ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->enable_reviews =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Product updated successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $this->data['categories']=Category::with('childs')->where(['status'=>1,'parent_id'=>0])->orderBy('sort_order','asc')->get();
        $this->data['brands']=Brands::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['suppliers']=Suppliers::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['warehouses']=WareHouses::orderBy('sort_order','asc')->get();
        $this->data['user'] = Products::find($id);
        $this->data['related_products']=Products::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['pro_cats']= ProductCategory::where('product_id',$this->data['user']->id)->pluck('id')->toArray();
        $this->data['rel_pro']= $this->data['user']->related_products()->pluck('id')->toArray();
       // dd($this->data['user']->related_products()->first());
        $this->data['pro_stocks'] = ProductsWarehouseStocks::where('p_id',$id)->get();
        $this->data['color']= ProductsWarehouseStocks::where('p_id',$id)->where('color', '!=', '')->pluck('color')->toArray();
        $this->data['size']= ProductsWarehouseStocks::where('p_id',$id)->where('size', '!=', '')->pluck('size')->toArray();
        $this->data['Variation']=Variation::all();
        $this->data['VariationValues']=VariationValues::all();


        return view('products::backend.edit')->with('data',$this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $cms =Products::find($id);
        $supplier = $cms->supplier_id;
        $curdate =  date("Y-m-d", strtotime($cms->created_at));//date('Y-m-d');
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
            'sku' => 'required',
            'description' => 'required',
            'purchase_price' => 'required',
            'price' => 'required',
            //'sale_price' => 'required',

        ]);
                $variat=Variation::all();



        if(isset($request->product_doc)){
            $cms->product_doc = uploadFile($request->all(),'public/uploads/products_doc');
            //dd($cms->product_doc);
        }

        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->short_description = $request->input('short_description');
        $cms->slug = $request->input('slug');
        $cms->brand_id =  $request->input('brand_id');
       // $cms->quantity =  $request->input('quantity');

        $cms->supplier_id =  $request->input('supplier_id');

        //$cms->warehouse_id =  $request->input('warehouse_id');
        $cms->purchase_price =  $request->input('purchase_price');
        $cms->sku =  $request->input('sku');
        $cms->weight =  $request->input('weight');
        $cms->price =  $request->input('price');
        $cms->sale_price =  $request->input('sale_price');
        $cms->product_handling_chrages =  $request->input('product_handling_chrages');
        $cms->internal_notes =  $request->input('internal_notes');
        // $cms->required_enroll =  $request->input('required_enroll');
        // $cms->instructor_id =  $request->input('instructor_id');
       // $cms->user_id =  auth()->user()->id;

        //$cms->sort_order =  MaxSortorder('courses');
        $cms->meta_title =  $request->input('meta_title');
        $cms->meta_description =  $request->input('meta_description');
        $cms->meta_keywords =  $request->input('meta_keywords');
        $cms->meta_schema =  $request->input('schema');
        $cms->expiry=$request->input('expiry');
        //$cms->status =  1;

        $cms->save();
        $cms->categories()->sync($request->categories);
        $cms->related_products()->sync($request->rel_pro);
        $permalink = Permalink::firstOrCreate(['reference' => $id, 'model' =>'PRODUCT']);
        $permalink->slug =$request->input('slug');
        $permalink->reference = $cms->id;
        $permalink->model = 'PRODUCT';
        $permalink->save();
        //dd($request->groupstocks);
        if(isset($request->groupstocks)){
            $qty =0;
            ProductsWarehouseStocks::where('p_id',$id)->delete();
            foreach($request->groupstocks  as $stocks){
              $qty=$qty+$stocks['quantity'];
               $pws=new ProductsWarehouseStocks;
                     $pws->p_id=$cms->id;
                     $pws->ware_house_id=$stocks['warehouse_ids'];
                     $pws->quantity=$stocks['quantity'];
                     $pws->available_quantity=$stocks['quantity'];
                     foreach ($variat as $vari) {
                      $name=$vari->name;
                      if(array_key_exists($name,$stocks)){
                      $pws->$name=$stocks[$name];

                                         }}
                     $pws->save();


            }
            $cms->quantity= $qty;
            $cms->save();
        }

        //$cmss =TransactionalAccounts::where('supplier_id',$request->input('supplier_id'))->first();

      //  if(!$cmss){

         //   $cmss = new TransactionalAccounts();

           // $cmss->address = 'At the time of product creation';//$request->input('address');

           // if($request->input('supplier_id')){
             ///   $supplier = Suppliers::find($request->input('supplier_id'));

               // $cmss->account_title = $supplier->name;
               // $cmss->account_type = 1;
              //  $cmss->supplier_id =  $request->input('supplier_id');
           // }



            //$cmss->status =  1;

           // $cmss->save();

        //}
        //dd($supplier);
   // $old_supplier_account = TransactionalAccounts::where('supplier_id',$supplier)->first();


//dd($old_supplier_account->id);
    //    $cmst = Transactions::where(['account_id'=>$old_supplier_account->id,'date'=>$curdate])->first();//new Transactions();
// dd($cmst);
//        $cmst->date = $curdate;//$request->input('date');
       // $cmst->voucher_code = maxcashVoucer();
        //  $cmst->transaction_type = $request->input('transaction_type');

       // $cmst->description ='Product Purchases ';// $request->input('description');
        //dd($cmss->supplier_id);
     //   $accounts = TransactionalAccounts :: where('supplier_id',$cmss->supplier_id)->first();
        //dd($accounts['account_title']);
      ///  $cmst->account_title = $accounts['account_title'];
      //  $cmst->account_id = $accounts['id'];
       // $cmst->jamah =  $request->input('purchase_price');
        //$cmst->save();

    //    $cmst = Transactions::where(['account_id'=>5,'date'=>$curdate])->first();//new Transactions();;
       // $cmst->date = $curdate;//$request->input('date');
     //   $cmst->voucher_code = maxcashVoucer();
        //$cmst->transaction_type = $request->input('transaction_type');
      //  $cmst->account_id = 5;
       // $cmst->description = 'Product purchases expenses given to supplier';//$request->input('description');
      //  $this->data['accounts'] = TransactionalAccounts :: find(5);
      //  $cmst->account_title = $this->data['accounts']->account_title;
        //$cmst->banam =  $request->input('purchase_price');
        //$cmst->save();

        //$cmst = Transactions::where(['account_id'=>6,'date'=>$curdate])->first();//new Transactions();;;
       // $cmst->date = $curdate;//$request->input('date');
      //  $cmst->voucher_code = maxcashVoucer();
        //$cmst->transaction_type = $request->input('transaction_type');
       // $cmst->account_id = 6;
      //  $cmst->description = 'Product handling charges';//$request->input('description');
      //  $this->data['accounts'] = TransactionalAccounts :: find(6);
      //  $cmst->account_title = $this->data['accounts']->account_title;
       // $cmst->banam =  $request->input('product_handling_chrages');
       // $cmst->save();






        return redirect('admin/products')
            ->with('success','Product Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        Products::find($id)->delete();
        return redirect()->back()
            ->with('success','Prodcut updated successfully');

    }

    public function images($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $this->data['product'] = Products::find($id);
        $this->data['user'] = ProductImages::where('p_id',$id)->orderBy('sort_order','DESC')->get();
        return view('products::backend.images')->with('data', $this->data);
    }

    public function imageCreate($id)
    {   //$this->data['warehouses']=['Select'=>''];
        $this->data['product'] = Products::find($id);
        return view('products::backend.imageCreate')->with('data', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function imageStore(Request $request,$id)
    {
       // dd($request->all());
        $input = $request->all();
        if(isset($input['image'])){
            $input['image'] = upload_product_image($input);
        }

        ProductImages::create([
            'p_id'=>$id,
            'images'=>$input['image'],
            'sort_order'=>MaxSortorder('product_images')

        ]);

        return redirect('admin/products/images/'.$id)
            ->with('success','Product Image created successfully');

    }


    public function imageEdit($id)
    {

        $this->data['user'] = ProductImages::find($id);

        $this->data['product'] = Products::where('id',$this->data['user']->p_id)->first();
        return view('products::backend.imageEdit')->with('data',$this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function imageUpdate(Request $request, $id)
    {

        $input = $request->all();
        $user = ProductImages::find($id);
        if(isset($input['image'])){
            $input['image'] = upload_product_image($input);

        $user->images =  $input['image'];
        $user->save();
        }



        return redirect('admin/products/images/'.$user->p_id)
            ->with('success','Product Image Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function imageDestroy($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        ProductImages::find($id)->delete();
        return redirect()->back()
            ->with('success','Prodcut Image updated successfully');

    }

    public function stores($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $this->data['product'] = Products::find($id);
       // $this->data['warehouses']=WareHouses::orderBy('sort_order','asc')->pluck('name','id')->toArray();
        $this->data['warehouses'] = ProductsWarehouseStocks::where('p_id',$id)->get();
        $this->data['stores'] = Stores::orderBy('sort_order')->pluck('name','id')->toArray();
        return view('products::backend.stores')->with('data', $this->data);
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function assignStore(Request $request,$id)
    {
       //  dd($request->all());
        $record =$request->all();
       $this->data['ware_house'] = ProductsWarehouseStocks::where(['p_id'=>$record['pid'],'ware_house_id'=>$id])->first();
        $this->data['ware_house']->store_id = $record['store_id'];
        $this->data['ware_house']->save();
        return redirect()->back()
            ->with('success','Product assigned to store successfully');

    }


    public function unassignedstores(Request $request,$id)
    {
        //  dd($request->all());
        $record =$request->all();
        $this->data['ware_house'] = ProductsWarehouseStocks::find($id);
        $this->data['ware_house']->store_id = 0;
        $this->data['ware_house']->save();
        return redirect()->back()
            ->with('success','Product unassign to store successfully');

    }

    public function reviews($id)
    {
        $this->data['product'] = Products::find($id);
        $this->data['user'] = Review::where('product_id',$id)->get();
        return view('products::backend.reviews')->with('data', $this->data);
    }

    public function ReviewstatusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = Review::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Review Status updated successfully');
    }


}
