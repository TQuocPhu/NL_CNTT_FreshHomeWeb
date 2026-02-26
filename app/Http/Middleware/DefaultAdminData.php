<?php

namespace App\Http\Middleware;

use App\Models\Contact;
use App\Models\Notification;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class DefaultAdminData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('admin')->user();

        if($user) {
            $messages = Contact::where('is_replied', 0)->latest()->get();
            $notifications = Notification::where('is_read', 0)->latest('created_at')->get();
        } else {
            $messages = [];
            $notifications = [];
        }
        View::share([
            'messages' => $messages,
            'notifications' => $notifications,
            'userAdmin' => $user,
        ]);
        return $next($request);
    }
}
