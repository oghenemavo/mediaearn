<x-mail::message>
# Sign up Successful

Dear {{ $user->last_name }},\
Welcome to Earnerview, thank you for signing up.\
You can start earning everyday by watching videos

<x-mail::button :url="$url">
Start Earning
</x-mail::button>

Watch more, Earn More <br>
{{ config('app.name') }}
</x-mail::message>
