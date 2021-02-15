<?php

namespace App\Http\Controllers\Store\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Helpers\StringHelper;
use App\Model\UserRole;
use App\UserGuard;
use App\Model\Status;
use Validator, URL;

class CustomerLoginController extends Controller {

    private $guard;

    protected $redirectTo = '/';

    public function __construct(Request $request) {
      //  parent::__construct($request);
        $this->guard ='user';// UserGuard::GUARD_USER;
        $this->middleware('guest:' . $this->guard, ['except' => 'logout']);
    }

    public function showLoginForm() {
        $previous_url = URL::previous();
        if(!strpos($previous_url, 'login')){
            Session::put('from_url', URL::previous());
        }
        return view('store.auth.login')->withData($this->data);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [], []);
//dd('ad');
        if ($validator->passes()) {
            $credentials = [
                'email' => $request->email,
                'password' => $request->password,
                 'user_type'=>'customer',
                // 'role' => UserRole::USER_CUSTOMER,
               // 'status' => Status::STATUS_ACTIVE,
            ];
            if (Auth::guard($this->guard)->attempt($credentials, $request->remember)) {
              // dd('dsa');
                // $redirect_url = route('store-index');
                if(Session::has('from_url')){
                    $previous_url = Session::get('from_url');
                    if(!strpos($previous_url, 'login')){
                        $redirect_url = $previous_url;
                    }
                }
               // return redirect('customer/dashboard');
                return redirect('/');
                //return redirect()->intended($redirect_url);
            }
        }else{
            Session::flash('error', implode('', set_error_delimeter($validator->errors()->all())));
            return redirect()->back()->withInput($request->only('email', 'remember'));
        }

        Session::flash('error', 'Username or password invalid.');
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request) {
        Auth::guard($this->guard)->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
        //return redirect()->intended(route('store-login'));
    }

}
