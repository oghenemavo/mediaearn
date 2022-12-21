<x-mail::message>
# Earnings

Dear {{ $mailData->name }},\
Congratulations you just earned &#8358;{{$mailData->amount}}, after watching "{{ $mailData->title }}" video\
Your wallet has been credited.

Regards, {{ config('app.name') }}\
Watch more, Earn More
</x-mail::message>
