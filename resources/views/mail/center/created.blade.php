<x-mail::message>
# New Center Created

Hello,
A new center has been created by **{{ $center->user?->name ?? 'Squarely' }}**.

## Center Details

- **Name:** {{ $center->name }}
- **Email:** {{ $center->email ?? 'N/A' }}
- **Password:** {{ $password ?? 'N/A' }}
- **Subscription:** {{ $center->package->name ?? 'N/A' }}

<x-mail::button :url="url($url)">
View Center
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
