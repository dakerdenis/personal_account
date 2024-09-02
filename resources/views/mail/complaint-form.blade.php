@component('mail::message')

    __First Name__: {{htmlspecialchars(strip_tags($data['firstName']))}}
    <br>
    __Second Name__: {{htmlspecialchars(strip_tags($data['secondName']))}}
    <br>
    __Surname__: {{htmlspecialchars(strip_tags($data['surname']))}}
    <br>
    __Personal Id__: {{htmlspecialchars(strip_tags($data['personalId']))}}
    <br>
    __Email__: {{htmlspecialchars(strip_tags($data['email']))}}
    <br>
    __Phone__: 994{{htmlspecialchars(strip_tags($data['phone']))}}
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
