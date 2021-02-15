<?php

namespace App\Http\Controllers\Store\Auth;

use App\Http\Controllers\Store\Controller;
use App\Model\UserRole;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use App\Model\UserGuard;

use Illuminate\Support\Facades\Session;
use Validator, DB, Carbon\Carbon;

use App\Mail\Email;
use Mail;

class CustomerForgotPasswordController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Password Reset Controller
      |--------------------------------------------------------------------------
      |
      | This controller is responsible for handling password reset emails and
      | includes a trait which assists in sending these notifications from
      | your application to your users. Feel free to explore this trait.
      |
     */

use SendsPasswordResetEmails;

    private $guard;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->guard = UserGuard::GUARD_USER;
        $this->middleware('guest:' . $this->guard);
    }

    protected function broker() {
        return Password::broker('users');
    }

    public function showLinkRequestForm() {
        return view('store.auth.passwords.email')->withData($this->data);
    }

    public function sendResetLinkEmail(Request $request) {
        //You can add validation login here
        $user = DB::table('users')->where('role', UserRole::USER_CUSTOMER)->where('email', '=', $request->email)->first();
        //Check if the user exists
        if (is_null($user)) {
            return redirect()->back()->withErrors(['email' => trans('Customer does not exist')]);
        }

        //Create Password Reset Token
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            Session::flash('success', 'A reset link has been sent to your email address.');
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }


        /*$validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [], []);

        if ($validator->passes()) {
            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);
        }else{
            Session::flash('error', implode('', set_error_delimeter($validator->errors()->all())));
            return redirect()->back()->withInput($request->only('email'));
        }*/

         /*$this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
                $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT ? $this->sendResetLinkResponse($response) : $this->sendResetLinkFailedResponse($request, $response);*/
    }

    private function sendResetEmail($email, $token)
    {
        //Retrieve the user from the database
        $user = DB::table('users')->where('role', UserRole::USER_CUSTOMER)->where('email', $email)->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = route('store-reset-form', ['token' => $token, 'email' => urlencode($user->email)]);
        //config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($user->email);

        try {
            $this->data['subject'] = "Reset Password Notification | ".config('app.name');
            $this->data['view'] = 'store.emails.reset_password';
            $this->data['user'] = $user;
            $this->data['link'] = $link;
            Mail::to($email)->send(new Email($this->data));
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
