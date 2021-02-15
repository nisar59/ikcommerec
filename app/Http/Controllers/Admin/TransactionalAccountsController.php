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
use App\Repositories\CouponRepository;
use Modules\Suppliers\Entities\Suppliers;
use Modules\Users\Entities\User;


class TransactionalAccountsController extends Controller {

    private $model;
    private $viewDir;
    private $routeName;
    private $currentUser;
    private $request;
    private $isEdit = false;
    private $media;

    public function __construct(Request $request) {
        // dd('asd');
        //  parent::__construct($request);
        $this->viewDir = 'admin.transactional_accounts.';
        $this->routeName = 'admin.';
    }

    public function index() {
        //dd('here');
        $this->data['orders'] = TransactionalAccounts::where('status', '=', 1)->get();
        // dd($this->data['orders']);
        return view($this->viewDir.'index')->with('data', $this->data);

    }

    public function create() {
        
        $this->data['accounts_type'] = getAccountsType();
     
        $this->data['suppliers'] = Suppliers::where('status',1)->get();
        $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
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
        $test=TransactionalAccounts::where('account_type', $request->input('account_type'))->where('account_title',$request->input('account_title'))->get();
       if($test->count()<=0)
        {
        $cms = new TransactionalAccounts();
        $cms->account_title = $request->input('account_title');
        $cms->account_type = $request->input('account_type');
        $cms->address = $request->input('address');

        if($request->input('supplier_id')){
            $supplier = Suppliers::find($request->input('supplier_id'));

            $cms->account_title = $supplier->name;
            $cms->supplier_id =  $request->input('supplier_id');
        }

        if($request->input('customer_id')){
            $supplier = User::find($request->input('customer_id'));

            $cms->account_title = $supplier->first_name. ' '.$supplier->last_name;
            $cms->customer_id =  $request->input('customer_id');
        }

        $cms->status =  1;

        $cms->save();


        return redirect('admin/transactional-accounts')
            ->with('success','Account created successfully');
        }
        else
        {
            return redirect('admin/transactional-accounts')
            ->with('success','This Account Already Existed');
        }

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
        $cms = TransactionalAccounts::find($id);
        $cms->account_title = $request->input('account_title');
        $cms->account_type = $request->input('account_type');
        $cms->address = $request->input('address');

        if($request->input('supplier_id')){
            $supplier = Suppliers::find($request->input('supplier_id'));

            $cms->account_title = $supplier->name;
            $cms->supplier_id =  $request->input('supplier_id');
        }

        if($request->input('customer_id')){
            $supplier = User::find($request->input('customer_id'));

            $cms->account_title = $supplier->first_name. ' '.$supplier->last_name;
            $cms->customer_id =  $request->input('customer_id');
        }


        $cms->save();


        return redirect('admin/transactional-accounts')
            ->with('success','Account updated successfully');

    }
    public function edit($id) {
        $this->data['user'] = TransactionalAccounts::find($id);
        $this->data['accounts_type'] = getAccountsType();
        $this->data['suppliers'] = Suppliers::where('status',1)->get();
        $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
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

}
