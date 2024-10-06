<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */

     public function handle(Request $request, Closure $next, string $role): Response
     {
         if (!$request->user()->hasRole($role)) {
             return redirect()->route('home.index')->with('danger', "Can't access page");
         }
  
         return $next($request);
     }
}