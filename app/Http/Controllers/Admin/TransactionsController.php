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
use Modules\Settings\Entities\Settings;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use Config;
use App\Exports\UsersExport;
use App\Exports\DailyCashVoucher;
use Maatwebsite\Excel\Facades\Excel;
//$this->settings();


class TransactionsController extends Controller {

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
       $this->settings();
        $this->viewDir = 'admin.transactions.';
        $this->routeName = 'admin.';
    }

    public function index() {
        //dd('here');
        $cur_date =date('Y-m-d');
        $this->data['orders'] = Transactions::where('date',$cur_date)->orderBy('id','desc')->get();
        // dd($this->data['orders']);
        $this->data['accounts'] = TransactionalAccounts:: get();

        return view($this->viewDir.'index')->with('data', $this->data);

    }
    public function report() {
        //dd('here');
        $cur_date =date('Y-m-d');
        $this->data['orders'] = Transactions::where('date',$cur_date)->orderBy('id','desc')->get();
        // dd($this->data['orders']);
        $this->data['accounts'] = TransactionalAccounts:: get();
        return view($this->viewDir.'report')->with('data', $this->data);

    }
    
    public function accountsreport(Request $request) {
        $vl=$request->input('acnt');
        if($request->post() and $vl!=''){
        $vl=$request->input('acnt');
        $this->data['orders'] = Transactions::where('jamah_account_id',$vl)->orwhere('banam_account_id',$vl)->get();
        $this->data['accounts'] = TransactionalAccounts:: get();
         return view($this->viewDir.'accountvoucher')->with('data', $this->data);
        }
 else{
        $cur_date =date('Y-m-d');
        $this->data['orders'] = Transactions::where('date',$cur_date)->orderBy('id','desc')->get();

        $this->data['accounts'] = TransactionalAccounts:: get();      
        
        return view($this->viewDir.'accountvoucher')->with('data', $this->data);
 }
 

    }
    
    public function individualaccountreport(Request $request) {
    
        $vl=$request->input('acnt');
        $this->data['account_title'] = TransactionalAccounts:: where('id',$vl)->pluck('account_title')->first();
        $this->data['orders'] = Transactions::where('jamah_account_id',$vl)->orwhere('banam_account_id',$vl)->get();
        $this->data['accounts'] = TransactionalAccounts:: get();
         return view($this->viewDir.'seperateaccount')->with('data', $this->data);
        
    }
    public function create() {
        $this->data['transaction_type'] = getTransactionsType();
       // $this->data['suppliers'] = Suppliers::where('status',1)->get();
      //  $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
        $this->data['accounts'] = TransactionalAccounts:: get();
       //dd($this->data);
        return view($this->viewDir.'create')->with('data', $this->data);
    }
    public function ajaxpost(Request $request){
       // dd($request->all());
       if($request->input('jamah')!=$request->input('banam')){
        try {
          // dd($request->input('date'));
            $cms = new Transactions();
            $cms->date = $request->input('date');
            $cms->voucher_code = maxcashVoucer();//$request->input('voucher_code');

            $cms->jamah =  TransactionalAccounts::where('id',$request->input('jamah'))->pluck('account_title')->first();
           $cms->jamah_account_id=$request->input('jamah');
            $cms->banam = TransactionalAccounts::where('id',$request->input('banam'))->pluck('account_title')->first();
            $cms->banam_account_id=$request->input('banam');
            $cms->description = $request->input('description');

            $cms->amount=$request->input('amount');
            $cms->save();
            
            $resutlArray = array(
                'status' => true,

                'message' => ' Daily Cash Voucer Added.'
            );
            return json_encode($resutlArray);

        }catch (\Exception $e){

            return json_encode(array('status' => false, 'message' => $e->getMessage()));
        }
            }
            else{
                      $resutlArray = array(
                'status' => false,

                'message' => ' Sorry Invalid Transcation, You are Attempting Same Account Transcation.'
            );
             return json_encode($resutlArray);
            }

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
        $cms->voucher_code = $request->input('voucher_code');
        $cms->transaction_type = $request->input('transaction_type');
        $cms->account_id = $request->input('account_id');
        $cms->description = $request->input('description');
        $this->data['accounts'] = TransactionalAccounts:: find($cms->account_id);
        $cms->account_title = $this->data['accounts']->account_title;
        $cms->amount =  $request->input('amount');
        $cms->save();


        return redirect('admin/transactions')
            ->with('success','Voucher created successfully');

    }


    public function update(Request $request,$id) {
        
        if($request->input('jamah')!=$request->input('banam')){
            
            $cms =Transactions::find($id);
            $cms->date = $request->input('date');
            $cms->jamah =  TransactionalAccounts::where('id',$request->input('jamah'))->pluck('account_title')->first();
           $cms->jamah_account_id=$request->input('jamah');
            $cms->banam = TransactionalAccounts::where('id',$request->input('banam'))->pluck('account_title')->first();
            $cms->banam_account_id=$request->input('banam');
            $cms->description = $request->input('description');

            $cms->amount=$request->input('amount');
            $cms->save();

        return redirect('admin/transactions')
            ->with('success','Transactions updated successfully');
    }
    else{
      return redirect('admin/transactions')
            ->with('success','Sorry Invalid Transcation, You are Attempting Same Account Transcation');
        }
    }
    public function edit($id) {
        $this->data['user'] = Transactions::find($id);
        $this->data['transaction_type'] = getTransactionsType();
        // $this->data['suppliers'] = Suppliers::where('status',1)->get();
        //  $this->data['customers'] = User::where('status',1)->where('user_type','customer')->get();
        $this->data['accounts'] = TransactionalAccounts:: get();
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
        $model = Transactions::find($id)->delete();
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
    
    
    
    
    public function export(Request $request) 
{
    $name= TransactionalAccounts::where('id',$request->input('acnt'))->pluck('account_title')->first();
    $acnt=$request->input('acnt');
    return Excel::download(new UsersExport($acnt), $name.'.xlsx');
}
 
 
     public function dailycashvoucherexport(Request $request) 
{
     return Excel::download(new DailyCashVoucher, 'DailyCashvoucher.xlsx');
}   
}
