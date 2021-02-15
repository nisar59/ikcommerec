<?php

namespace App\Http\Controllers\Store\Auth;

use App\Http\Controllers\Store\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use DB;

class CustomerResetPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset requests
      | and uses a simple trait to include this behavior. You're free to
      | explore this trait and override any methods you wish to tweak.
      |
     */

use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->middleware('guest:user');
        $this->redirectTo = \App\Http\Helpers\StringHelper::getStoreURI();
    }

    protected function guard() {
        return Auth::guard('user');
    }

    protected function broker() {
        return Password::broker('users');
    }

    public function showResetForm(Request $request, $token = null) {
        return view('store.auth.passwords.reset')->with(
                        ['token' => $token, 'email' => $request->email, 'data' => $this->data]
        );
    }

    public function resetPassword(Request $request)
    {
        //Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'password' => 'required|confirmed'
        ]);

        //check if input is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['email' => 'Please complete the form']);
        }

        $password = $request->password;
        // Validate the token
        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('store.auth.passwords.email');

        $user = User::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        //Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)->delete();

        Session::flash('success', 'Password has been changed successfully.');
        return redirect(route('store-login'));

        /*//Send Email Reset Success Email
        if ($this->sendSuccessEmail($tokenData->email)) {
            return view('store.auth.login');
        } else {
            return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        }*/

    }

}
