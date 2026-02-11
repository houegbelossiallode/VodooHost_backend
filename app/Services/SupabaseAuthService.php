<?php

namespace App\Services;

use Supabase\SupabaseClient;

class SupabaseAuthService
{
    protected $supabase;

    public function __construct()
    {
        $this->supabase = new SupabaseClient(
            config('supabase.url'),
            config('supabase.key'),
            [
                'autoRefreshToken' => true,
                'persistSession' => true,
            ]
        );
    }

    public function signInWithPhone($phone, $countryCode)
    {
        $phoneNumber = $countryCode . $phone;

        return $this->supabase->auth->signInWithOtp([
            'phone' => $phoneNumber,
        ]);
    }

    public function verifyOtp($phone, $token, $countryCode)
    {
        $phoneNumber = $countryCode . $phone;

        return $this->supabase->auth->verifyOtp([
            'phone' => $phoneNumber,
            'token' => $token,
            'type' => 'sms',
        ]);
    }

    public function signInWithOAuth($provider)
    {
        $providers = ['google', 'facebook', 'apple'];

        if (!in_array(strtolower($provider), $providers)) {
            throw new \Exception('Provider not supported');
        }

        return $this->supabase->auth->signInWithOAuth([
            'provider' => $provider,
        ]);
    }

    public function signInWithEmail($email, $password)
    {
        return $this->supabase->auth->signInWithPassword([
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function signUpWithEmail($email, $password, $userData = [])
    {
        return $this->supabase->auth->signUp([
            'email' => $email,
            'password' => $password,
            'options' => [
                'data' => $userData
            ]
        ]);
    }

    public function getUser()
    {
        return $this->supabase->auth->user();
    }

    public function signOut()
    {
        return $this->supabase->auth->signOut();
    }
}
