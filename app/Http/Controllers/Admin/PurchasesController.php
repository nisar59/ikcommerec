<?php

namespace App\Http\Controllers\Admin;

use App\Http\Helpers\FlashMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Helpers\CouponManager;
use App\Models\Coupon;
use App\Models\TransactionalAccounts;
use App\Models\Transactions;
use App\Repositories\CouponRepository;
use Modules\Suppliers\Entities\Suppliers;
use Modules\Users\Entities\User;
use Modules\Products\Entities\Products;
use App\Subscription;
use App\Models\Order;
use App\Models\OrderProduct;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\ProductCatagory;
use Modules\WareHouses\Entities\WareHouses;
use Modules\Products\Entities\ProductsWarehouseStocks;
use App\Exports\PurchaseExport;
use App\Exports\NewsLetterExport;
use Maatwebsite\Excel\Facades\Excel;

class PurchasesController extends Controller {

    private $model;
    private $viewDir;
    private $routeName;
    private $currentUser;
    private $request;
    private $isEdit = false;
    private $media;

    public function __construct(Request $request) {
        
        $this->viewDir = 'admin.purchases.';
        $this->routeName = 'admin.';
    }













public function index(Request $request) {
    if ($request->isMethod('post')){
if($request->input('catagory')!='')
{
        $this->data['catagory']= Category::all();
        $this->data['warehouse']=WareHouses::all();
        $this->data['supplier']=Suppliers::all();
        $data=array();
        $product=array();
        $cataid=ProductCatagory::where('category_id',$request->input('catagory'))->get();
        foreach ($cataid as $value) {
        $data[] = Products::where('id',$value->product_id)->first();}
        foreach ($data as $value) {
            if($value!=''){
            $product[]=$value;}}
        $this->data['orders']=$product;
        return view($this->viewDir.'index')->with('data', $this->data);
}



elseif($request->input('warehouse')!='')
{
        $this->data['catagory']= Category::all();
        $this->data['warehouse']=WareHouses::all();
        $this->data['supplier']=Suppliers::all();
        $data=array();
        $product=array();
        $wareid=ProductsWarehouseStocks::where('ware_house_id',$request->input('warehouse'))->get();
        foreach ($wareid as $value) {
        $data[] = Products::where('id',$value->p_id)->first();}
        foreach ($data as $value) {
            if($value!=''){
            $product[]=$value;}}
        $this->data['orders']=$product;
        return view($this->viewDir.'index')->with('data', $this->data);
}
elseif($request->input('supplier')!='')
{
        $this->data['catagory']= Category::all();
        $this->data['warehouse']=WareHouses::all();
        $this->data['supplier']=Suppliers::all();
        $this->data['orders'] = Products::where('supplier_id',$request->input('supplier'))->get();
        return view($this->viewDir.'index')->with('data', $this->data);
}
else{
        $this->data['catagory']= Category::all();
        $this->data['warehouse']=WareHouses::all();
        $this->data['supplier']=Suppliers::all();
        $this->data['orders'] = Products::orderBy('created_at','desc')->get();
        return view($this->viewDir.'index')->with('data', $this->data);
}
}
else{
        $this->data['catagory']= Category::all();
        $this->data['warehouse']=WareHouses::all();
        $this->data['supplier']=Suppliers::all();
        $this->data['orders'] = Products::orderBy('created_at','desc')->get();
        return view($this->viewDir.'index')->with('data', $this->data);
    }

}






















    public function report() {
        //dd('here');
                $this->data['porder']=Order::all();
        foreach($this->data['porder'] as $pr)
        {
            $this->data['orderproducts']=OrderProduct::where('order_id',$pr->id)->get();

        }
        // dd($this->data['orders']);
        return view($this->viewDir.'financereport')->with('data', $this->data);

    }
    public function newsletter(){
        $this->data['orders'] = Subscription::orderBy('created_at','desc')->get();
        // dd($this->data['orders']);
        return view($this->viewDir.'newsletter')->with('data', $this->data);

    }

    public function create() {
        $this->data['transaction_type'] = getTransactionsType();
        // $this->data['suppliers'] = Suppliers::where('status',1)->get();
        //  $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
        $this->data['accounts'] = TransactionalAccounts :: get();
        return view($this->viewDir.'create')->with('data', $this->data);
    }

    public function store(Request $request) {
//    $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
////        if(!empty($link)){
////            return redirect($link);
////        }
////        $input = $request->all();
////        $this->validate($request, [
////            'name' => 'required',
////            'slug' => 'required|unique:permalinks,slug',
////            'description' => 'required',
////
////        ]);
///
        //dd($request->all());
        $cms = new Transactions();
        $cms->date = $request->input('date');
        $cms->transaction_type = $request->input('transaction_type');
        $cms->account_id = $request->input('account_id');
        $cms->description = $request->input('description');
        $this->data['accounts'] = TransactionalAccounts :: find($cms->account_id);
        $cms->account_title = $this->data['accounts']->account_title;
        $cms->amount =  $request->input('amount');
        $cms->save();


        return redirect('admin/transactions')
            ->with('success','Voucher created successfully');

    }


    public function update(Request $request,$id) {
//    $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
////        if(!empty($link)){
////            return redirect($link);
////        }
////        $input = $request->all();
////        $this->validate($request, [
////            'name' => 'required',
////            'slug' => 'required|unique:permalinks,slug',
////            'description' => 'required',
////
////        ]);
        $cms = Transactions::find($id);
        $cms->date = $request->input('date');
        $cms->transaction_type = $request->input('transaction_type');
        $cms->account_id = $request->input('account_id');
        $cms->description = $request->input('description');
        $this->data['accounts'] = TransactionalAccounts :: find($cms->account_id);
        $cms->account_title = $this->data['accounts']->account_title;
        $cms->amount =  $request->input('amount');
        $cms->save();


        return redirect('admin/transactions')
            ->with('success','Transactions updated successfully');

    }
    public function edit($id) {
        $this->data['user'] = Transactions::find($id);
        $this->data['transaction_type'] = getTransactionsType();
        // $this->data['suppliers'] = Suppliers::where('status',1)->get();
        //  $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
        $this->data['accounts'] = TransactionalAccounts :: get();
        // dd($this->data);
        return view($this->viewDir.'edit')->with('data', $this->data);
    }





    public function save(Request $request) {
        $redirectUrl = route('admin.coupon.create');
        $this->request = $request;
        $this->model = new Coupon();
        $this->currentUser = Auth::user();
        $validator = $this->validator($request);
        if ($validator->fails()) {
            Session::flash('error', FlashMessage::getValidationMessages($validator->errors()->getMessages()));
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if ($this->setData()) {
                Session::flash('success', 'Coupon created successfully.');
                return redirect($redirectUrl);
            } else {
                Session::flash('error', 'Coupon created not be successfully.');
                return redirect($redirectUrl)->withInput();
            }
        }
    }

    public function edidt($id) {
        $actionTxt = 'Update';
        $action = route('admin.coupon.update', ['id' => $id]);
        $vendor = $this->getDomainId();
        $products = $brands = null;
        $repo = new CouponRepository();
        $this->model = $repo->getById($id);
        $this->isEdit = true;

        return view($this->viewDir . 'create-edit')->with(array(
            'model' => $this->model,
            'brands' => $brands,
            'discountType' => CouponManager::getDiscountType(),
            'discountFor' => CouponManager::getDiscountFor(),
            'products' => $products,
            'actionTxt' => $actionTxt,
            'isEdit' => $this->isEdit,
            'action' => $action,
        ));
    }

    public function updates(Request $request, $id) {
        $redirectUrl = route('admin.coupon.edit', ['id' => $id]);
        $this->request = $request;
        $repo = new CouponRepository();
        $this->model = $repo->getById($id);
        $this->currentUser = Auth::user();
        $validator = $this->validator($request);
        if ($validator->fails()) {
            Session::flash('error', FlashMessage::getValidationMessages($validator->errors()->getMessages()));
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            if ($this->setData()) {
                Session::flash('success', 'Coupon updated successfully.');
                return redirect($redirectUrl);
            } else {
                Session::flash('error', 'Coupon updated not be successfully.');
                return redirect($redirectUrl)->withInput();
            }
        }
    }

    public function delete(Request $request, $id) {
        $redirectUrl = route('admin.coupon.index');
        $repo = new CouponRepository();
        $this->model = $repo->delete($id);
        if ($this->model) {
            Session::flash('success', 'Coupon delete successfully.');
            return redirect($redirectUrl);
        }
        Session::flash('error', 'Coupon delete not be successfully.');
        return redirect($redirectUrl)->withInput();
    }
    public function destroy($id){
        $model = TransactionalAccounts::find($id)->delete();
        return redirect()->back()
            ->with('success','Account updated successfully');

    }

    public function statusUpdate($id)
    {
        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
        if(!empty($link)){
            return redirect($link);
        }
        $user = TransactionalAccounts::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect()->back()
            ->with('success','Account updated successfully');
    }


    public function getData(Request $request) {
        $columns = array('id', 'name', 'code', 'discount_type', 'discount_for', 'discount', 'start_date', 'end_date', 'status', 'created_at');
        $this->currentUser = Auth::user();
        $vendor = $this->currentUser->id;
        $totalData = Coupon::where(['vendor_id' => $vendor])->count();
        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $models = Coupon::where(['vendor_id' => $vendor])->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get($columns);
        } else {
            $search = $request->input('search.value');

            $models = Coupon::where(['vendor_id' => $vendor])->where(function($query) use($search) {
                $query->orWhere('id', 'LIKE', "%{$search}%");
                $query->orWhere('name', 'LIKE', "%{$search}%");
                $query->orWhere('code', 'LIKE', "%{$search}%");
                $query->orWhere('start_date', 'LIKE', "%{$search}%");
                $query->orWhere('end_date', 'LIKE', "%{$search}%");
                $query->orWhere('status', 'LIKE', "%{$search}%");
            })
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get($columns);

            $totalFiltered = Coupon::where(['vendor_id' => $vendor])->where(function($query) use($search) {
                $query->orWhere('id', 'LIKE', "%{$search}%");
                $query->orWhere('name', 'LIKE', "%{$search}%");
                $query->orWhere('code', 'LIKE', "%{$search}%");
                $query->orWhere('start_date', 'LIKE', "%{$search}%");
                $query->orWhere('end_date', 'LIKE', "%{$search}%");
                $query->orWhere('status', 'LIKE', "%{$search}%");
            })
                ->count();
        }

        $data = array();
        if (!empty($models)) {
            foreach ($models as $model) {
                $nestedData['id'] = $model->id;
                $nestedData['name'] = $model->name;
                $nestedData['code'] = $model->code;
                $nestedData['discount_type'] = CouponManager::getDiscountTypeById($model->discount_type);
                $nestedData['discount_for'] = CouponManager::getDiscountForById($model->discount_for);
                $nestedData['discount'] = $model->discount;
                $nestedData['start_date'] = $model->start_date;
                $nestedData['end_date'] = $model->end_date;
                $nestedData['status'] = $model->getStatus();
                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    private function validator($data, $isEdit = false) {
        return Validator::make($data->all(), [
            'name' => 'required|max:100',
            'code' => 'required|max:100',
            'discount_type' => 'required',
            'discount' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required',
        ]);
    }

    private function setData() {
        $vendor = $this->getDomainId();
        $this->model->creator_id = $this->currentUser->id;
        $this->model->vendor_id = $vendor;
        $this->model->product_id = ($this->request->input('product') != 0) ? $this->request->input('product') : NULL;
        //$this->model->brand_id = ($this->request->input('brand') != 0) ? $this->request->input('brand') : NULL;
        $this->model->name = $this->request->input('name');
        $this->model->code = $this->request->input('code');
        /*if (!$this->isEdit) {
            $this->model->code = CouponManager::getCode();
        }*/
        $this->model->discount_type = $this->request->input('discount_type');
        $this->model->discount_for = $this->request->input('discount_for');
        $this->model->discount = $this->request->input('discount');
        $this->model->start_date = $this->request->input('start_date');
        $this->model->end_date = $this->request->input('end_date');
        $this->model->description = $this->request->input('description');
        if ($this->isEdit) {
            $model = $this->model->update();
        }
        $model = $this->model->save();
        return $model;
    }

    private function getDomainId(){
        return 1;
    }
    
    
public function purchaseexport()
{
 
     return Excel::download(new PurchaseExport, 'Purchase.xlsx');
}

    public function newsletterexport(){
        
       return Excel::download(new NewsLetterExport, 'newsletter.xlsx');

    }

}
