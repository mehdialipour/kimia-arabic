<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Session;

class CheckForSession
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

        return (Session::get('logged_in') && User::where('id', Session::get('user_id'))->first()->online == 1) ? $next($request) : redirect(route('login'));
    }
}
