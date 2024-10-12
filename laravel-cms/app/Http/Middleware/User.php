<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role->name !== 'User') {
            return redirect()->route('home.index')->with('danger', "Can't access page");
        }
 
        return $next($request);
    }
}