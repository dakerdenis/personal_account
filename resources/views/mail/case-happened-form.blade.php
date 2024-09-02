@component('mail::message')

    __First Name__: {{htmlspecialchars(strip_tags($data['name']))}}
    <br>
    __Second Name__: {{htmlspecialchars(strip_tags($data['last_name']))}}
    <br>
    __Surname__: {{htmlspecialchars(strip_tags($data['surname']))}}
    <br>
    __Policy Number__: {{htmlspecialchars(strip_tags($data['policy_number']))}}
    <br>
    __Email__: {{htmlspecialchars(strip_tags($data['email']))}}
    <br>
    __Phone__: +994{{htmlspecialchars(strip_tags($data['phone']))}}
    <br>
    __Insurance Type__: {{htmlspecialchars(strip_tags($data['insurance_type']))}}
    <br>
    __Text__:
    <br>
    {!! nl2br(htmlspecialchars(strip_tags($data['message']))) !!}

    @slot('subcopy')

        __Date__: {{ \Illuminate\Support\Carbon::now()->format('d.m.Y') }}
        <br>
        __Time__: {{ \Illuminate\Support\Carbon::now()->format('H:i') }}
        <br>
        __Language__: {{ \Illuminate\Support\Facades\App::getLocale() }}
        <br>

    @endslot

@endcomponent
