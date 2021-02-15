<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

   // protected $redirectTo = '/admin';

    use AuthenticatesUsers;


    public function __construct(Request $request)
    {
        $this->guard='admin';
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm() {
        return view('auth.login');
    }
    public function login(Request $request) {
      // dd('asd');
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            //'role' => UserRole::USER_SUPPER_ADMIN,
           // 'status' => Status::STATUS_ACTIVE,
        ];
        if (Auth::guard($this->guard)->attempt($credentials, $request->remember)) {
           //dd('ads');
            return redirect('admin/dashboard');
            //return redirect()->intended( '/admin/dashboard');
        }

        Session::flash('Error', 'Username or password invalid.');
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request) {
        Auth::guard($this->guard)->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('admin/login');
        //return redirect()->intended(StringHelper::getAdmimURI() . 'login');
    }

}
