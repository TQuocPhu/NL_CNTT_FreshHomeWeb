<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $user = Auth::guard('admin')->user();

        //Kiểm tra quyền hạn của người đăng nhập
        if(!$user || !$user->role->permissions->contains('name', $permission)) {
            abort(403, 'Bạn không có quyền hạn này.');
        }
        return $next($request);
    }
}
