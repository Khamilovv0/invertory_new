<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowedUserIds = [646, 359];
        // Проверяем, аутентифицирован ли пользователь и имеет ли он ID 646
        if (Auth::check() && in_array(Auth::user()->TutorID, $allowedUserIds)) {
            return $next($request);
        } else {
            // Если пользователь не аутентифицирован или его ID не содержится в списке разрешенных, перенаправляем на главную страницу или страницу логина
            return redirect('/')->with('error','У вас нет доступа к этой странице.');
        }
    }
}
