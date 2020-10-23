@component('mail::message')
# {{ __('emails/invite-to-family.title') }}

{{ __('emails/invite-to-family.content', ['family' => $family]) }}

<strong>{{ __('emails/invite-to-family.code') }}:</strong> {{ $code }}

@component('mail::button', ['url' => config('app.url').'?email='.$email.'&code='.$code])
{{ __('emails/invite-to-family.button') }}
@endcomponent
@endcomponent
