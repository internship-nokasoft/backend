@component('mail::message')
    Hello {{ $member->name }}

    We understand it happens
@component("mail::button", ['url' => route('reset',$member->remember_token)])
    Reset Your Password
@endcomponent

@endcomponent