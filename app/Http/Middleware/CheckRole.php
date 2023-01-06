<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
// use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
      // Auth::user()->name;
      $user = Auth::user();
      if($request->user() === null) {
        return redirect('admin/permissions')->with('message', 'Not Logged In!');
        return response("Insufficent permissions...No User", 401);
        return $next($request);
      }
      $actions = $request->route()->getAction();

      if($request->user()->hasAnyRole($roles) || !$roles){
        return $next($request);
      }
      // return $next($request);
      return redirect('admin/permissions')->with('message', 'Not Allowed!');
      return response("Insufficent permissions", 401);
    }
}
