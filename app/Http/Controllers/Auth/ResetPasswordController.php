<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use BlackBits\LaravelCognitoAuth\CognitoClient;
use BlackBits\LaravelCognitoAuth\Auth\ResetsPasswords;


class ResetPasswordController extends Controller
{
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
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $client = app()->make(CognitoClient::class);

        $user = $client->getUser($request->email);

        if ($user['UserStatus'] == CognitoClient::FORCE_PASSWORD_STATUS) {
            $response = $this->forceNewPassword($request);
        } else {
            $response = $client->resetPassword($request->token, $request->email, $request->password);
        }

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($request,$response)
            : $this->sendResetFailedResponse($request, $response);
    }
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
