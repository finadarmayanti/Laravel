<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Symfony\Component\HttpFoundation\Response;

// class login
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle($request, Closure $next)
//     {
//     if (!Auth::check()) {
//         if ($request->ajax() || $request->wantsJson()) {
//             return response()->json(['message' => 'Unauthorized'], 401);
//         } else {
//             return redirect('/')->with('message', 'You must be logged in to access the home page');
//         }
//     }

//     return $next($request);
//     }

// }
