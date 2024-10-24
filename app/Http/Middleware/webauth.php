<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class webauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
            // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('login'); // Redirect to login if not authenticated
        }


        checkingUserAccount(Auth::user()->id);


        // Get the authenticated user's type
        $user_type = Auth::user()->user_type;

        // Check if the user is a customer (user_type == 4)
        if ($user_type == 4) {
            return $next($request); // Allow the request to proceed
        } else {
            return redirect('admin/dashboard'); // Redirect to admin dashboard if not a customer
        }
    }
}
