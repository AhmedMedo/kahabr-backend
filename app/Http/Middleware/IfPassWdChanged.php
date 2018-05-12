<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;


class IfPassWdChanged {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

	    if(Auth::check())
        {
            if(Auth::user()->updated_at  != Session::get('updated'))
            {
                Auth::logout();
                Session::remove('updated');
                Session::flash('sessionmessage','Your Session Has Been Expired please Login Again');
                return redirect('/');
            }
        }

		return $next($request);
	}

}
