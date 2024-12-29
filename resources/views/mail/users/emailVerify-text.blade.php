Dear {{ $user_display_name }}

Your validation code is: {{ $code }} .

For your security, please do not share this code with anyone. Valid in {{ config('misc.one_time_password.ttl', 5) }} minutes.

Thanks,
{{ config('app.name') }}
