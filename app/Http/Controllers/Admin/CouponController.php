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
use App\Repositories\CouponRepository;


class CouponController extends Controller {

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
        $this->viewDir = 'admin.coupon.';
        $this->routeName = 'admin.';
    }

    public function index() {
        $this->data['orders'] = Coupon::where('status', '=', 1)->where('trashed',0)->get();
        // dd($this->data['orders']);
        return view($this->viewDir.'index')->with('data', $this->data);

    }

    public function create() {
        $this->data['discount_type'] = getDiscountType();
        $this->data['discount_for'] = getDiscountFor();
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
        $cms = new Coupon();
        $cms->name = $request->input('name');
        $cms->code = $request->input('code');
        $cms->discount_type = $request->input('discount_type');

        $cms->discount_for =  $request->input('discount_for');

        //$cms->image_id =  $request->input('image_id');
        $cms->discount =  $request->input('discount');
        $cms->description =  $request->input('description');
        $cms->start_date =  $request->input('start_date');
        $cms->end_date =  $request->input('end_date');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();


        return redirect('admin/coupon')
            ->with('success','Coupon created successfully');

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
        $cms = Coupon::find($id);
        $cms->name = $request->input('name');
        $cms->code = $request->input('code');
        $cms->discount_type = $request->input('discount_type');

        $cms->discount_for =  $request->input('discount_for');

        //$cms->image_id =  $request->input('image_id');
        $cms->discount =  $request->input('discount');
        $cms->description =  $request->input('description');
        $cms->start_date =  $request->input('start_date');
        $cms->end_date =  $request->input('end_date');
        // $cms->schema =  $request->input('schema');
        $cms->status =  1;

        $cms->save();


        return redirect('admin/coupon')
            ->with('success','Coupon created successfully');

    }
    public function edit($id) {
        $this->data['user'] = Coupon::find($id);
        $this->data['discount_type'] = getDiscountType();
        $this->data['discount_for'] = getDiscountFor();
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
        $model = Coupon::where('id', $id)->update(['trashed' => 1]);
        return redirect()->back()
            ->with('success','Coupon updated successfully');

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
