@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

# Merci pour votre inscription à notre newsletter !

Bonjour,

Nous sommes ravis de vous compter parmi nos abonnés. Vous recevrez désormais nos dernières actualités, offres exclusives et conseils directement dans votre boîte de réception.

@component('mail::button', ['url' => config('app.url')])
Visiter notre site
@endcomponent

Si vous avez des questions ou des suggestions, n'hésitez pas à nous contacter en répondant à cet email.

Cordialement,  
L'équipe {{ config('app.name') }}

{{-- Subcopy --}}
@slot('subcopy')
@component('mail::subcopy')
Si vous ne souhaitez plus recevoir nos emails, vous pouvez vous désabonner en cliquant sur le lien ci-dessous :

[Se désabonner]({{ $unsubscribeUrl }})
@endcomponent
@endslot

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.

[Politique de confidentialité]({{ url('/privacy-policy') }}) | [Conditions d'utilisation]({{ url('/terms') }})
@endcomponent
@endslot
@endcomponent
