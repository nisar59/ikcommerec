<?php

namespace App\Http\Controllers\Store\Auth;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
//use App\Model\UserRole;
//use App\Model\UserGuard;
//use App\Model\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

use App\Mail\Email;
use Mail;

class CustomerRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */  private $guard;

   // use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/customer/login/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //parent::__construct($request);
        $this->guard ='user';
        $this->middleware('guest');
    }

    public function showRegisterForm() {
        return view('store.auth.register')->withData($this->data);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
       // dd(';');
       // dd($request->all());
       // $this->validator($request->all())->validate();
 //dd('ad');
        //event(new Registered($user = $this->create($request->all())));
        $user = $this->create($request->all());
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'user_type'=>'customer',

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
            return redirect('customer/dashboard');
            //return redirect()->intended($redirect_url);
        }
            return redirect('/');
            //return redirect()->intended($redirect_url);


       // dd($user);
//        return $this->registered($request, $user)
//            ?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       // dd($data);
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            //'display_name' => $data['first_name'].' '.$data['last_name'],
            'first_name'=>$data['first_name'],
            'last_name'=>$data['last_name'],
            'email' => $data['email'],
            'user_type' => 'customer',
            'status' => 1,
            'password' => Hash::make($data['password']),
        ]);
//dd('asd');
        $this->data['user'] = $user;
        $this->data['password'] = $data['password'];
        $this->data['admin'] = false;
        $this->data['subject'] = "Welcome to ".config('app.name')." | ".config('app.name');
        $this->data['view'] = 'store.emails.account_registration';
       // Mail::to($data['email'])->send(new Email($this->data));

        if(config('settings.config_new_account_emails')){
            $this->data['admin'] = true;
            $this->data['subject'] = "New account registration | ".config('app.name');
            $emails = explode(",", preg_replace('/\s+/', '', config('settings.config_new_account_emails')));
           // Mail::to($emails)->send(new Email($this->data));
        }
        Session::flash('success', "Registration successful, please login using the email and password.");
        return $user;
    }
}
