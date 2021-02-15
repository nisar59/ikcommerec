<?php
namespace App\Http\Controllers\Store\Checkout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Store\Checkout\Cart;
use Cart as CartController;
use Darryldecode\Cart\CartCondition;
use Carbon\Carbon;
use App\Models\Coupon as CouponModel;

class Coupon extends Controller
{
    public $cart;
    public function __construct()
    {
       // parent::__construct();
        $this->cart = new Cart();
    }

    public function apply(Request $request){
        try {
            //dd(CartController::getSubTotal());
            $date = Carbon::now()->format('Y-m-d');
            $coupon = CouponModel::where('code', $request->code)->whereDate('start_date', '<=', $date)->whereDate('end_date', '>=', $date)->first();
            if ($coupon) {
                $productID = $coupon->product_id;
                $discount = ($coupon->discount_type == 1) ? '-' . $coupon->discount . '%' : '-' . $coupon->discount;
                if ($productID) {
                    $item = $this->cart->getItem($productID);
                    $conditions = $item->getConditions();
                    $applied_condition = '';
                    foreach ($conditions as $condition){
                        if($condition->getType() == 'promo'){
                            $applied_condition = $condition->getName();
                            break;
                        }
                    }
                    if($applied_condition){
                        CartController::removeItemCondition($productID, $applied_condition);
                    }
                    $coupon_apply = new CartCondition(
                        array(
                            'name' => $coupon->name.' ('.$coupon->code.')',
                            'type' => 'promo',
                            'target' => 'item', // this condition will be applied to cart's total when getTotal() is called.
                            'value' => $discount,
                        )
                    );
                    CartController::addItemCondition($productID, $coupon_apply);
                } else {
                    CartController::removeConditionsByType('coupon');
                    $coupon_apply = new CartCondition(
                        array(
                            'name' => $coupon->name.' ('.$coupon->code.')',
                            'type' => 'coupon',
                            'target' => 'subtotal', // this condition will be applied to cart's total when getTotal() is called.
                            'value' => $discount,
                            'order' => 2 // the order of calculation of cart base conditions. The bigger the later to be applied.
                        )
                    );
                    CartController::condition($coupon_apply);
                }
                return json_encode(
                    array(
                        'status' => true,
                        'message' => 'Coupon '.$coupon->name.'('.$request->code.') applied successfully'
                    )
                );
            }else{
                return json_encode(
                    array(
                        'status' => false,
                        'message' => 'Coupon '.$request->code.' not found.'
                    )
                );
            }
        }catch (\Exception $e){
            return json_encode(
                array(
                    'status' => false,
                    'message' => 'Something went wrong! '.$e->getMessage()
                )
            );
        }
    }
}
