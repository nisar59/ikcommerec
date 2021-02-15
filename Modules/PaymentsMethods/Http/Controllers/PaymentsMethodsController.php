<?php

namespace Modules\PaymentsMethods\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\PaymentsMethods\Entities\PaymentMethods;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Validator;

class PaymentsMethodsController extends Controller
{
    use  ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $this->data['user'] = PaymentMethods:: orderBy('sort_order')->get();
        return view('paymentsmethods::backend.index')->with('data', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('paymentsmethods::backend.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            //  'slug' => 'required',
            //  'description' => 'required',

        ]);
        $cms = new PaymentMethods();
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
        $cms->user_id = auth()->user()->id;

        $cms->sort_order =  MaxSortorder('stores');
       // $cms->store_type =  $request->input('store_type');

        $cms->status =  1;

        $cms->save();
        return redirect('admin/paymentsmethods')
            ->with('success','Payment method created successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('paymentsmethods::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['user'] = PaymentMethods::find($id);
        //  dd($this->data);
        return view('paymentsmethods::backend.edit')->with('data', $this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
//            'slug' => 'required',
//            'description' => 'required',

        ]);
        $cms =PaymentMethods::find($id);
        $cms->name = $request->input('name');
        $cms->description = $request->input('description');
       // $cms->store_type =  $request->input('store_type');
        $cms->user_id = auth()->user()->id;
        $cms->save();


        return redirect('admin/paymentsmethods')
            ->with('success','Payment method Updated successfully');
    }

    public function statusUpdate($id)
    {
//        $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        $user = PaymentMethods::find($id);
        if($user->status ==1){
            $st= 0;

        }else{
            $st=1;

        }
        $user->status =$st;
        $user->save();
        return redirect('admin/paymentsmethods')
            ->with('success','Paymetn method updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       // $link=userPermissionsss(auth()->user()->id,\Route::current()->getName()) ;
//        if(!empty($link)){
//            return redirect($link);
//        }
        PaymentMethods::find($id)->delete();
        return redirect('admin/paymentsmethods')
            ->with('success','Payment method updated successfully');
    }
}
