<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->user()?->role->name;

        if ($role = 'Writer') {
            return redirect()->route('user.articles', ['user' => $request->user()]);
        } elseif ($role = 'Member') {
            return redirect()->route('articles.index');
        }

        return $next($request);
    }
}
