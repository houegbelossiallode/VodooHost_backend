<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SupabaseAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(SupabaseAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string',
            'phone' => 'required|string',
        ]);

        try {
            $response = $this->authService->signInWithPhone(
                $request->phone,
                $request->country_code
            );

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'data' => $response
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string',
            'phone' => 'required|string',
            'otp' => 'required|string',
        ]);

        try {
            $response = $this->authService->verifyOtp(
                $request->phone,
                $request->otp,
                $request->country_code
            );

            // Connecter l'utilisateur
            $user = $this->authService->getUser();
            Auth::loginUsingId($user->id);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'redirect' => route('hoost.home')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function redirectToProvider($provider)
    {
        $providers = ['google', 'facebook', 'apple'];

        if (!in_array(strtolower($provider), $providers)) {
            abort(404);
        }

        try {
            return $this->authService->signInWithOAuth($provider);
        } catch (\Exception $e) {
            return redirect()->route('hoost.login')
                ->with('error', 'Unable to authenticate with ' . ucfirst($provider));
        }
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        try {
            $user = $this->authService->getUser();

            if ($user) {
                Auth::loginUsingId($user->id);
                return redirect()->intended(route('hoost.home'));
            }

            return redirect()->route('hoost.login')
                ->with('error', 'Unable to authenticate with ' . ucfirst($provider));
        } catch (\Exception $e) {
            return redirect()->route('hoost.login')
                ->with('error', 'An error occurred during authentication');
        }
    }

    public function logout()
    {
        $this->authService->signOut();
        Auth::logout();
        return redirect()->route('hoost.home');
    }
}
