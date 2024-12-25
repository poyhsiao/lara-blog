<x-mail::message>
# Dear {{ $user_display_name }},

## Hello {{ $user_name }},

Please click the button below to verify your email address.

<x-mail::button :url="$url">
Verify Email
</x-mail::button>

If you cannot click the button, copy and paste the URL below into your web browser: {{ $url }}

## If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
