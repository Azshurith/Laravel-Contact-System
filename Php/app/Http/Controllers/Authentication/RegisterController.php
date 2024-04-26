<?php

namespace App\Http\Controllers\Authentication;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): View
    {
        return view('authentication.register');
    }

    /**
     * Show the success page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function success(): View
    {
        return view('authentication.success');
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validate user input
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:8|same:confirmPassword',
        ]);

        // Create a new user record
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // Authenticate the user
        Auth::login($user);

        // Redirect user after registration
        return response()->json([
            'route' => route('register.success')
        ], 200);
    }
}
