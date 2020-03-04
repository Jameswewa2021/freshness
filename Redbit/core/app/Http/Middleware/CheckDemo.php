<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\User;

class CheckDemo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (env('IS_DEMO', false)) {
        
        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')) {


          return redirect()->back()->withErrors('You Can Not Change Anything In Demo Version.');

        } else {

          return $next($request);

        }

      } else {

        return $next($request);

      }
    }
}
