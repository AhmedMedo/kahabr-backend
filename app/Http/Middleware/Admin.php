<?php namespace App\Http\Middleware;

use Closure;


class Admin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
	    if($request->user()->isAdmin() || $request->user()->SuperAdmin())
        {
            return $next($request);
        }else{

            return redirect('/');
        }

	}

}
