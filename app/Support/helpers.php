<?php

use App\Models\Currencie;
use Illuminate\Support\Facades\Auth;

if (! function_exists('current_currency_code')) {
    function current_currency_code(): string
    {
        $user = Auth::user();

        // 1) Devise dans les préférences utilisateur
        if ($user && $user->preferences && $user->preferences->preferred_currency) {
            return $user->preferences->preferred_currency;
        }

        // 2) Devise stockée en session
        if (session()->has('currency')) {
            return session('currency');
        }

        // 3) Fallback : XOF
        return 'XOF';
    }
}

if (! function_exists('current_currency')) {
    function current_currency(): ?Currencie
    {
        static $cached = null;

        if ($cached !== null) {
            return $cached;
        }

        $code = current_currency_code();

        $cached = Currencie::where('code', $code)->first()
            ?: Currencie::where('code', 'XOF')->first();

        return $cached;
    }
}

if (! function_exists('format_price')) {
    function format_price($amountXof, ?Currencie $currency = null): string
    {
        $amountXof = (float) $amountXof;

        $currency = $currency ?: current_currency();

        if (! $currency) {
            return number_format($amountXof, 0, ',', ' ') . ' F CFA';
        }

        $rate = (float) ($currency->rate_from_xof ?? 1);
        if ($rate <= 0) {
            $rate = 1;
        }

        $converted = $amountXof * $rate;
        $symbol    = $currency->symbol ?: $currency->code;

        return number_format($converted, 0, ',', ' ') . ' ' . $symbol;
    }
}
