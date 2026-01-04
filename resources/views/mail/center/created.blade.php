<x-mail::message>
# New Subscription Created

Hello,
A new "{{ $center->package->name }}" subscription **{{ $center->name }}** has been created by Squarely.<br>
The admin user to manage your center is **{{ $user->email }}**.

<x-mail::button :url="url($url)">
Manage Center
</x-mail::button>

If you have any questions or need assistance, feel free to contact us.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
