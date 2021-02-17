<?php

namespace App\Http\Controllers\Admin;

use App\Models\Countries;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Helpers\FlashMessage;
use App\Repositories\Repository;
//use App\Model\StatusOrder;
use App\User;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\VendorRepository;
use App\Repositories\CurrencyRepository;
//use App\Model\StatusOrder;
use App\Models\ShippingAddress;
use App\Models\ShippingMethod;
//use App\Model\OrderStatus;
use Modules\PaymentsMethods\Entities\PaymentMethods;
use Modules\Products\Entities\Products;
use Modules\Products\Entities\ProductsWarehouseStocks;
use Modules\Settings\Entities\Settings;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\ProductCatagory;
use Modules\Settings\Http\Controllers\SettingsController as SettingController;
use App\Models\Transactions;
use Config;
use App\Exports\ProductSalesExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;


class OrderController extends Controller {

    private $moduleURL;
    private $viewDir;
    private $model;
    private $request;
    private $quantity;
    private $total;
    private $discount;
    private $tax;

    public function __construct(Request $request) {

        //parent::__construct($request);
        //$this->moduleURL = $this->adminURI . 'order/';
        $this->viewDir = 'admin.order.';
        $this->settings();
    }

    public function index() {
        $this->data['orders'] = Order::where('status', '=', 1)->where('trashed',0)->get();
        return view($this->viewDir.'index')->with('data', $this->data);

//        return view($this->viewDir . 'list')->with(array(
//                    'publishCount' => Order::where('status', '=', 1)->count(),
//                    'trashCount' => Order::where('status', '=', OrderStatus::STATUS_SOFT_DELETE)->count(),
//        ));
    }

    public function ProductSalesReport(Request $request) {
      if($request->isMethod('get')){
        $this->data['orders'] = OrderProduct::get();
        $this->data['catagory']=Category::where('status', '=', 1)->get();

        return view($this->viewDir.'product-sales-report')->with('data', $this->data);
      }
      elseif($request->input('from')!='' AND $request->input('to')!=''){
         $this->data['orders'] = OrderProduct::where('created_at','>=',$request->input('from'))->where('created_at','<=',$request->input('to'))->get();
         $this->data['catagory']=Category::where('status', '=', 1)->get();
        return view($this->viewDir.'product-sales-report')->with('data', $this->data);
      }
      ///////////////////////////////////////////////////////////////////////////////////////
      elseif($request->input('catagory')!=''){
        $cata=ProductCatagory::where('category_id',$request->input('catagory'))->get();
        if ($cata!='') {
          $proget=array();
          $pro=array();
          foreach ($cata as $value) { 
            $proget[]=OrderProduct::where('product_id', $value->product_id)->get();
          }
          foreach ($proget as $key) {
          for($i=0; $i<count($key); $i++){
            $pro[]=$key[$i];
                }
          }
          $this->data['orders']=$pro;
        }
         $this->data['catagory']=Category::where('status', '=', 1)->get();
         return view($this->viewDir.'product-sales-report')->with('data', $this->data);
       }
      ///////////////////////////////////////////////////////////////////////////////////////
      elseif($request->input('orderstatus')!=''){
        $cata=Order::where('order_status',$request->input('orderstatus'))->get();
        if ($cata!='') {
          $proget=array();
          $pro=array();
          foreach ($cata as $value) { 
            $proget[]=OrderProduct::where('order_id', $value->id)->get();
          }
          foreach ($proget as $key) {
          for($i=0; $i<count($key); $i++){
            $pro[]=$key[$i];
                }
          }
          $this->data['orders']=$pro;
        }
         $this->data['catagory']=Category::where('status', '=', 1)->get();
         return view($this->viewDir.'product-sales-report')->with('data', $this->data);
       }
       //////////////////////////////////////////////////////////////////////////////////////////
      else{
        $this->data['orders'] = OrderProduct::get();
        $this->data['catagory']=Category::where('status', '=', 1)->get();
        return view($this->viewDir.'product-sales-report')->with('data', $this->data);
      }
    }




    public function StockReport(Request $request) {
      if ($request->isMethod('get')) {

        $this->data['orders'] = ProductsWarehouseStocks::get();
        return view($this->viewDir.'stock-report')->with('data', $this->data);
          }

        else{
        if($request->input('warehouse')!=''){
          $this->data['orders'] = ProductsWarehouseStocks::where('ware_house_id', $request->input('warehouse'))->get();
           return view($this->viewDir.'stock-report')->with('data', $this->data);
        }

          elseif($request->input('stock')==0){
          $this->data['orders'] = ProductsWarehouseStocks::where('available_quantity','<',1)->get();
           return view($this->viewDir.'stock-report')->with('data', $this->data);

        }
          elseif($request->input('stock')==1){
          $this->data['orders'] = ProductsWarehouseStocks::where('available_quantity','>',1)->get();
           return view($this->viewDir.'stock-report')->with('data', $this->data);

        }
        else{
          $this->data['orders'] = ProductsWarehouseStocks::where('available_quantity','<',5)->get();
           return view($this->viewDir.'stock-report')->with('data', $this->data);

        }

        }
    }







    public function DeadStockReport() {
    $this->data['orders'] = ProductsWarehouseStocks:: where('available_quantity','<=','5')->get();
    return view($this->viewDir.'stock-report')->with('data', $this->data);
   }

    public function invoices() {
        $this->data['orders'] = Order::where('status', '=', 1)->where('trashed',0)->get();
        return view($this->viewDir.'invoices')->with('data', $this->data);
    }

    
    public function create() {
        $this->model = new Order();
        return view($this->viewDir . 'add-edit')->with(array(
                    'adminURI' => $this->adminURI,
                    'actionTxt' => 'Save',
                    'isEdit' => FALSE,
                    'action' => $this->moduleURL . 'save',
                    'model' => $this->model,
                    'currencies' => CurrencyRepository::getCurrencies('code'),
                    'vendors' => VendorRepository::getVendors(),
                    'countries' => Countries::where('status', 1)->pluck('name', 'id')->toArray()
        ));
    }

    public function store(Request $request) {
        $response = ['Good' => false, 'error' => 'Invaild request'];
        if ($request->ajax()) {
            $this->request = $request;
            $this->model = new Order();
            $validator = $this->model->validate($this->request->all());
            if ($this->model->fails()) {
                $response = ['Good' => false, 'error' => $this->model->JsonErrors()];
                return response()->json($response);
            }
            $this->calOrderVal();
            $model = $this->saveData($this->model);
            if ($model) {
                $this->saveOrderProducts();
                FlashMessage::set('success', 'Order successfully saved.');
                return response()->json(['Good' => true, 'redirectTo' => url($this->moduleURL . 'edit/' . $this->model->id)]);
            } else {
                $response = ['Good' => false, 'error' => 'Order has not been saved.'];
            }
        }
        return response()->json($response);
    }

    public function edit($id) {
      // dd('dsfsdf');
        $this->data['user'] = Order::find($id);
        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        //dd($this->data['user']);
        return view($this->viewDir.'edit')->with('data', $this->data);
    }

    public function leapord($id) {
        // dd($id);
        $this->data['user'] = Order::find($id);
        $order_total = intval($this->data['user']->total);
       // dd($order_total);
        // dd($this->data['user']->orderProducts->count());
        $shipping_city = $this->data['user']->ship_city;
        $order_packet_qty = $this->data['user']->orderProducts->count();
        $order_packet_weight=0;
        foreach($this->data['user']->orderProducts as $product){
            $pro = Products::find($product->product_id);
            $order_packet_weight =$order_packet_weight + $pro->weight;

        }
        //dd($order_packet_weight);
        $weigth_in_grams = ceil($order_packet_weight * 1000);
        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        //dd($this->data['user']);
/////////////  leapord api
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL,
            'http://new.leopardscod.com/webservice/bookPacketTest/format/json/'); // Write

            curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_handle, CURLOPT_POST, 1);
            curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
                'api_key' => '809368491EC48FE5A973000C9F4285D7',
             'api_password' => 'HAMEED@GUL@143',
             'booked_packet_weight' => $weigth_in_grams, // Weight should
           // in 'Grams' e.g. '2000'
             'booked_packet_vol_weight_w' => '', // Optional Field
            //(You can keep it empty), Volumetric Weight Width
             'booked_packet_vol_weight_h' => '', // Optional Field
           // (You can keep it empty), Volumetric Weight Height
             'booked_packet_vol_weight_l' => '', // Optional Field
            //(You can keep it empty), Volumetric Weight Length
             'booked_packet_no_piece' => $order_packet_qty, // No. of Pieces
            //should an Integer Value
             'booked_packet_collect_amount' => $order_total, // Collection
           // Amount on Delivery
             'booked_packet_order_id' => $id, // Optional
          //  Filed, (If any) Order ID of Given Product

             'origin_city' => 'self', /** Params:
                    'self' or 'integer_value' e.g. 'origin_city' => 'self' or 'origin_city' =>
                    789 (where 789 is Lahore ID)
                     * If 'self' is
                    used then Your City ID will be used.
                     *
                    'integer_value' provide integer value (for integer values read 'Get All
                    Cities' api documentation)
                     */

             'destination_city' => $shipping_city, /** Params:
                    'self' or 'integer_value' e.g. 'destination_city' => 'self' or
                    'destination_city' => 789 (where 789 is Lahore ID)
                     * If 'self' is
                    used then Your City ID will be used.
                     *
                    'integer_value' provide integer value (for integer values read 'Get All
                    Cities' api documentation)
                     */

             'shipment_name_eng' => 'self', // Params: 'self'
          //  or 'Type any other Name here', If 'self' will used then Your Company's Name
         //   will be Used here
             'shipment_email' => 'self', // Params: 'self'
           // or 'Type any other Email here', If 'self' will used then Your Company's Email
           // will be Used here
             'shipment_phone' => 'self', // Params: 'self'
          //  or 'Type any other Phone Number here', If 'self' will used then Your
          //  Company's Phone Number will be Used here
             'shipment_address' => 'self', // Params: 'self'
         //   or 'Type any other Address here', If 'self' will used then Your Company's
         //   Address will be Used here
             'consignment_name_eng' => $this->data['user']->first_name .' ' .$this->data['user']->last_name, // Type Consignee
        //    Name here
             'consignment_email' => $this->data['user']->billing_email, // Optional Field
           // (You can keep it empty), Type Consignee Email here
             'consignment_phone' => $this->data['user']->billing_phone, // Type Consignee
           // Phone Number here
             'consignment_phone_two' => '', // Optional Field
         //   (You can keep it empty), Type Consignee Second Phone Number here
             'consignment_phone_three' => '', // Optional Field
           // (You can keep it empty), Type Consignee Third Phone Number here
             'consignment_address' => $this->data['user']->ship_address_1, // Type Consignee
        //    Address here
             'special_instructions' => 'Handle with care', // Type any
          //  instruction here regarding booked packet
             'shipment_type' => '', // Optional Field
           // (You can keep it empty so It will pick default value i.e. "overnight"), Type
          //  Shipment type name here
            ));
            $buffer = curl_exec($curl_handle);
            curl_close($curl_handle);
///         $this->

            $response =json_decode($buffer) ;
            if($response->error==1){
                return redirect()->back()
                    ->with('danger','sorry somthing went wrong');

            }

        $this->data['user']->tracking_number = $response->track_number;
        $this->data['user']->cod_slip = $response->slip_link;

        $this->data['user']->save();
        
        
      $tran=Transactions::where('date','=',date('Y-m-d'))->first();
      $tran->jamah= $this->data['user']->total;
      $tran->save();

        return redirect()->back()
            ->with('success','COD SLip has been updated successfully');
    }


    public function invoicesedit($id) {
        // dd('dsfsdf');
        $this->data['user'] = Order::find($id);
        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        //dd($this->data['user']);
        return view($this->viewDir.'invoiceedit')->with('data', $this->data);
    }




public function invoicepdf($id)
{
         
        $this->data['user'] = Order::find($id);
        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        //dd($this->data);
  
        $pdf = PDF::loadView($this->viewDir.'pdf', ['data' => $this->data]);
      //return $pdf->download('invoice.pdf');
     return $pdf->stream('invoice.pdf');
        //return view($this->viewDir.'invoiceedit')->with('data', $this->data);
}


























    public function invoicesstatus($id) {
        // dd($id);
        $this->data['user'] = Order::find($id);
        if($this->data['user']->invoice_status==0){
            $st=1;

        } else{

            $st= 0;
        }

        $this->data['user']->invoice_status= $st;
        $this->data['user']->save();

        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        //dd($this->data['user']);
        return redirect()->back()
            ->with('success','Invoice has been updated successfully');
    }
    public function refundForm($id){
        $this->data['user'] = Order::find($id);
        $this->data['order_status'] = array(''=>'Select','Payment Pending'=>'Payment Pending','Processing'=>'Processing','On Hold'=>'On Hold','Completed'=>'Completed','Failed'=>'Failed','Cancelled'=>'Cancelled','Refund'=>'Refund');
        return view($this->viewDir.'refundform')->with('data', $this->data);
    }

    public function update(Request $request,$id) {
      // dd($request->all());
        $cms =Order::find($id);
//        $this->validate($request, [
//            'name' => 'required',
//            'slug' => 'required|unique:permalinks,slug'.($cms->permalink && $cms->permalink->id ? ','.$cms->permalink->id : ""),
//            'sku' => 'required',
//            'description' => 'required',
//            'purchase_price' => 'required',
//            'price' => 'required',
//            //'sale_price' => 'required',
//
//        ]);
        $cms->first_name = $request->input('first_name');
        $cms->last_name = $request->input('last_name');
        $cms->billing_email = $request->input('billing_email');
        $cms->billing_phone = $request->input('billing_phone');
        $cms->order_status =  $request->input('order_status');
         if($cms->order_status=='Refund'){
             $cms->refunded = 1;

         }

        // $cms->quantity =  $request->input('quantity');

        $cms->billing_address_1 =  $request->input('billing_address_1');

        //$cms->warehouse_id =  $request->input('warehouse_id');
        $cms->billing_city =  $request->input('billing_city');
        $cms->billing_state =  $request->input('billing_state');
        $cms->billing_postal_code =  $request->input('billing_postal_code');
        $cms->billing_country =  $request->input('billing_country');
        $cms->ship_full_name =  $request->input('ship_full_name');
         $cms->ship_country =  $request->input('ship_country');
        // $cms->instructor_id =  $request->input('instructor_id');
        // $cms->user_id =  auth()->user()->id;

        //$cms->sort_order =  MaxSortorder('courses');
        $cms->ship_address_1 =  $request->input('ship_address_1');
        $cms->ship_city =  $request->input('ship_city');
        $cms->ship_state =  $request->input('ship_state');
        $cms->ship_postal_code =  $request->input('ship_postal_code');
        //$cms->status =  1;

        $cms->save();




        return redirect('admin/order/list')
            ->with('success','Order Updated successfully');
    }

    public function updateperforma(Request $request,$id) {
        // dd($request->all());
        $cms =Order::find($id);

        $cms->refund_reason =  $request->input('refund_reason');
        $cms->restock =  $request->input('restock');
        $cms->save();
        if($cms->restock ==1){
            //dd($cms->orderProducts);
            foreach($cms->orderProducts as $item){
               // dd($item);
              $product = Products::find($item->product_id);
              $product->quantity = $product->quantity + $item->quantity;
              $product->save();
              $wProducts = ProductsWarehouseStocks :: where('p_id',$item->product_id)->first();
             // dd($wProducts->id);
                $wProducts->quantity =  $wProducts->quantity + $item->quantity;
                $wProducts->save();
            }

        }




        return redirect('admin/order/list')
            ->with('success','Order Updated successfully');
    }



    public function delete(Request $request, $id) {
        Order::find($id)->delete();
        return redirect()->back()
            ->with('success','Order Deleted successfully');
    }

    private function calOrderVal() {
        $products = $this->request->get('product');
        $this->quantity = $this->total = $this->tax = $this->discount = 0;
        if ($products) {
            $collection = collect($products);
            $this->quantity = $collection->sum('quantity');
            foreach ($products as $product) {
                $this->total += ($product['price'] * $product['quantity']);
                //$this->discount += $product['discount'];
            }
        }

        if ($this->request->get('discount')) {
            $this->discount = $this->discount + $this->request->get('discount');
        }
    }

    public function destroy($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        Order::find($id)->delete();
        return redirect()->back()
            ->with('success','Order Image updated successfully');

    }
    private function saveOrderProducts() {
        $products = $this->request->get('product');
        $items = [];
        if ($products) {
            foreach ($products as $product) {
                array_push($items, [
                    'order_id' => $this->model->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total_price' => $product['price'] * $product['quantity'],
                    //'tax' => $product['tax'],
                    'discount' => $product['discount'],
                    'quantity_unit' => $product['quantity_unit'],
                ]);
            }
            if (!empty($items)) {
                Repository::insert(new OrderProduct(), $items);
            }
        }
    }

    private function deleteOrderProducts() {
        $this->model->orderProducts()->delete();
    }

    private function saveData($model, $isNew = true) {
        $currentUser = Auth::user();
        $currentUser = $currentUser->id;
        $model->creator_id = $currentUser;
        $model->vendor_id = $this->request->get('vendor_id');
        $model->customer_id = $this->request->get('customer_id');
        $model->order_no = $this->request->get('order_no');
        $model->quantity = $this->quantity;
        $model->total = $this->total;
        $model->tax = $this->request->get('tax');
        $model->discount = $this->discount;
        $model->currency = $this->request->get('currency');
        $model->currency_rate = $this->request->get('currency_rate');
        $model->customer_name = $this->request->get('customer_name');
        $model->billing_address_1 = $this->request->get('billing_address_1');
        $model->billing_address_2 = $this->request->get('billing_address_2');
        $model->billing_city = $this->request->get('billing_city');
        $model->billing_state = $this->request->get('billing_state');
        $model->billing_postal_code = $this->request->get('billing_postal_code');
        $model->billing_country = $this->request->get('billing_country');
        $model->billing_email = $this->request->get('billing_email');
        $model->billing_phone = $this->request->get('billing_phone');
        $model->ship_address_1 = $this->request->get('ship_address_1');
        $model->ship_address_2 = $this->request->get('ship_address_2');
        $model->ship_city = $this->request->get('ship_city');
        $model->ship_state = $this->request->get('ship_state');
        $model->ship_country = $this->request->get('ship_country');
//        $model->ship_email = $this->request->get('billing_country');
//        $model->ship_phone = $this->request->get('billing_country');
        $model->ship_full_name = $this->request->get('ship_name');
        $model->ship_postal_code = $this->request->get('ship_postal_code');
        $model->status = $this->request->get('status');
        if ($isNew) {
            $saved = $model->save();
        } else {
            $saved = $model->update();
        }

        if ($saved) {
            return true;
        }
        return false;
    }

    public function getData(Request $request) {

        $columns = array('id',
            'id',
            'first_name',
            'last_name',
            'billing_email',
            'billing_phone',
            'total',
            'status',
            'created_at'
        );

        $recordType = $request->get('record_type');
        $codition = '!=';

        if ($recordType == 'trashed') {
            $codition = '=';
        }

        $totalData = Order::where('status', $codition, OrderStatus::STATUS_SOFT_DELETE)->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $models = Order::where('status', $codition, OrderStatus::STATUS_SOFT_DELETE)->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get($columns);
        } else {
            $search = $request->input('search.value');
            $models = Order::where('status', $codition, OrderStatus::STATUS_SOFT_DELETE)->where(function($query) use($search) {
                        $query->orWhere('id', 'LIKE', "%{$search}%");
                        $query->orWhere('sku', 'LIKE', "%{$search}%");
                        $query->orWhere('title', 'LIKE', "%{$search}%");
                        $query->orWhere('slug', 'LIKE', "%{$search}%");
                        $query->orWhere('type', 'LIKE', "%{$search}%");
                        $query->orWhere('status', 'LIKE', "%{$search}%");
                    })
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get($columns);

            $totalFiltered = Order::where('status', $codition, OrderStatus::STATUS_SOFT_DELETE)->where(function($query) use($search) {
                        $query->orWhere('id', 'LIKE', "%{$search}%");
                        $query->orWhere('sku', 'LIKE', "%{$search}%");
                        $query->orWhere('title', 'LIKE', "%{$search}%");
                        $query->orWhere('slug', 'LIKE', "%{$search}%");
                        $query->orWhere('type', 'LIKE', "%{$search}%");
                        $query->orWhere('status', 'LIKE', "%{$search}%");
                    })
                    ->count();
        }

        $data = array();
        if (!empty($models)) {

            foreach ($models as $model) {
                $nestedData['id'] = $model->id;
                $nestedData['order_no'] = $model->id;
                $nestedData['customer_name'] = $model->first_name.' '.$model->last_name;
                $nestedData['email'] = $model->billing_email;
                $nestedData['phone'] = $model->billing_phone;
                $nestedData['total'] = $model->total;
                $nestedData['quantity'] = $model->getOrderTotalItems();
                $nestedData['status'] = $model->getStatus(false);
                $nestedData['date'] = $model->getCreatedAt();
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
    ///////////////////  by nisar
    public function generate()
    {
        $this->data['customers']= User::all();
        $this->data['products']= Products::all();
        $this->data['paymentsMethods'] = PaymentMethods::where('status',1)->orderBy('sort_order')->get();


        // dd($this->data['orders']);
        return view($this->viewDir.'create-order')->with('data', $this->data);
    }





    public function GenerateOrder(Request $request){
        if($request->post()){
            try{

                $shippingAddress = new ShippingAddress();

                $shippingAddress->customer_id = $request->input('customer_id');
                $shippingAddress->email = $request->input('billing_email');
                $shippingAddress->first_name = $request->input('first_name');
                $shippingAddress->last_name = $request->input('last_name');
                $shippingAddress->company = $request->input('company_name');
                $shippingAddress->address_1 = $request->input('billing_address_1');
                $shippingAddress->address_2 = $request->input('billing_address_2');
                $shippingAddress->country = $request->input('billing_country');
                $shippingAddress->state = $request->input('billing_state');
                $shippingAddress->city = $request->input('billing_city');
                $shippingAddress->post_code = $request->input('billing_postal_code');
                $shippingAddress->phone = $request->input('billing_phone');
                //Billing Address

                $shippingAddress->billing_email = $request->input('shipping_email');
                $shippingAddress->billing_first_name = $request->input('shipping_first_name');
                $shippingAddress->billing_last_name = $request->input('shipping_last_name');
                $shippingAddress->billing_company = $request->input('shipping_company_name');
                $shippingAddress->billing_address_1 = $request->input('shipping_address_1');
                $shippingAddress->billing_address_2 = $request->input('shipping_address_2');
                $shippingAddress->billing_country = $request->input('shipping_country');
                $shippingAddress->billing_state = $request->input('shipping_state');
                $shippingAddress->billing_city = $request->input('shipping_city');
                $shippingAddress->billing_post_code = $request->input('shipping_postal_code');
                $shippingAddress->billing_phone = $request->input('shipping_phone');
                $shippingAddress->save();

            }
            catch (\Exception $e){

                // dd($e->getMessage());
                \Session::flash('error', 'Something went wrong! '.$e->getMessage());
                return redirect()->back()->withInput();
            }
            $inputs = $request->all();
            //Redirect to payment screen
            if(!Session::has('shippingAddress')){
                Session::put('shippingAddress');
            }
            $this->orderSubmission($inputs,$request->payment_method);
            return redirect('admin/order/list')
                ->with('success','Oder Placed successfully');

            // }
        }
        else{
            $this->data['paymentsMethods'] = PaymentMethods::where('status',1)->orderBy('sort_order')->get();
            if($this->data['items']->count()){
                $this->data['cart'] = [];
                $this->data['cart_sub_total'] = $this->cart->getCartSubTotal();
                $this->data['cart_total'] = $this->cart->getCartTotal();
                //  $this->data['countries'] = Countries::where('status', 1)->pluck('name', 'id')->toArray();
                /*if(Session::has('shipping_address')){
                    $request->merge(Session::get('shipping_address')->toArray());
                }*/

                return view('store.checkout.shipping')->withData($this->data);
            }
            else{
                return redirect()->route('store-index');
            }
        }
    }



    public function orderSubmission($inputs= [] , $payment_method ='COD'){
            $subTotal=0;
            $items=$inputs['groupstocks'];        
            $totalItems =count($items);
            foreach ($inputs['groupstocks'] as $value) {
            $price=Products::where('id', $value['product_id'])->pluck('sale_price')->first();
            $qty=$value['quantity'];
            $subTotal=$subTotal+($price*$qty);
            }

            $subTotal = $subTotal;
            $discount = $inputs['discount'];
            $charges=$inputs['charges'];
          //  $shipping = $this->cart->getCartShippingCost();
            $total = $subTotal-$discount;
            $total=$total+$charges;
            $order = new Order();
            $order->total_items = $totalItems;
            $order->sub_total = $subTotal;
            $order->discount = $discount;
            $order->shipping=$charges;
           // $order->shipping = $shipping;
            $order->total = $total;
            $order->currency = config('variable.DEFAULT_CURRENCY');
            $order->rate = 1;

            //Shipping Address
            $order->ship_full_name = $inputs['shipping_first_name'].' '.$inputs['shipping_last_name'];
            $order->ship_address_1 = $inputs['shipping_address_1'];
            $order->ship_address_2 =$inputs['shipping_address_2'];
            $order->ship_country = $inputs['shipping_country'];
            $order->ship_state = $inputs['shipping_state'];
            $order->ship_city = $inputs['shipping_city'];
            $order->ship_postal_code =$inputs['shipping_postal_code'];
            $order->ship_phone = $inputs['shipping_phone'];
            $order->ship_email = $inputs['shipping_email'];

            //Billing Address
            $order->first_name = $inputs['first_name'];
            $order->last_name = $inputs['last_name'];
            $order->billing_address_1 = $inputs['billing_address_1'];
            $order->billing_address_2 = $inputs['billing_address_2'];
            $order->billing_country = $inputs['billing_country'];
            $order->billing_state = $inputs['billing_state'];
            $order->billing_city = $inputs['billing_city'];
            $order->billing_postal_code = $inputs['billing_postal_code'];
            $order->billing_phone = $inputs['billing_phone'];
            $order->billing_email = $inputs['billing_email'];
            $order->payment_method = $inputs['payment_method'];
            $order->customer_id = $inputs['customer_id'];
            $order->order_note = $inputs['order_note'];
            $order->order_status=$inputs['order_status'];
            $order->shipping_from_address=$inputs['shipping_from_address'];
            $order->shipping_from_mbl=$inputs['shipping_from_mbl'];
            $order->save();

            if($order){
                foreach ($inputs['groupstocks'] as $item){
                    //$attributes = $item->attributes; // the attributes
                    $orderProducts = new OrderProduct();
                    $orderProducts->order_id = $order->id;
                    $orderProducts->product_id = $item['product_id'];
                    $orderProducts->quantity = $item['quantity'];
                    $price=Products::where('id', $item['product_id'])->pluck('sale_price')->first();
                    $qty=$item['quantity'];
                    $orderProducts->total_price = $price*$qty;
                    $orderProducts->price = $price;
                    $orderProducts->tax = 0;
                    $orderProducts->discount = 0;
                    $orderProducts->save();

                }
            }
           

    }



    public function ProductSalesReportExport() {
      return Excel::download(new ProductSalesExport, 'ProductSalesReport.xlsx');
    }
}
