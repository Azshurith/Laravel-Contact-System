<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('authentication.login');
    }

    /**
     * Authenticate user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // Validate user input
        $credentials = $request->validate([
            'email'     => 'required|string|email|max:255',
            'password'  => 'required|string',
        ]);

        // Attempt to authenticate user
        if (Auth::attempt($credentials)) {
            return response()->json([
                'route' => route('contact.index')
            ], 200);
        }

        // Authentication failed
        throw ValidationException::withMessages([
            "password" => "Email and Password is incorrect"
        ]);
    }
}
