<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Cache;
use Session;
class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

    protected $redirectTo='/';
    protected $redirectAfterLogout='/';

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'name' => 'required', 'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');
        if($request->name == env('demo_user') && $request->password == env('demo_password') && (User::all()->count() == 0))
        {
            $user=new User;
            $user->name=$request->name;
            $user->password=Hash::make($request->password);
            $user->role='superadmin';
            $user->save();
            $this->auth->login($user);
            return redirect()->intended($this->redirectPath());


        }

        if ($this->auth->attempt($credentials, $request->has('remember')))
        {

           \Session::put('updated',\Auth::user()->updated_at);
            return redirect()->intended($this->redirectPath());
        }


        return redirect($this->loginPath())
            ->withInput($request->only('name', 'remember'))
            ->withErrors([
                'name' => $this->getFailedLoginMessage(),
            ]);
    }
    public function getLogout()
    {
        $this->auth->logout();
        Cache::flush();
        Session::remove('updated');
        return redirect(property_exists($this, 'redirectAfterLogout') ? $this->redirectAfterLogout : '/');
    }

	
}
