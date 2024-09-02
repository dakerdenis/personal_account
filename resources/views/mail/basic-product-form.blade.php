@component('mail::message')

    __Full Name__: {{htmlspecialchars(strip_tags($data['fullName']))}}
    <br>
    __Phone__: +994{{htmlspecialchars(strip_tags($data['phone']))}}
    <br>
    __Text__:
    <br>
    {!! nl2br(htmlspecialchars(strip_tags($data['message']))) !!}



    @slot('subcopy')

        @isset($data['title'])
            __Product__: {{ $data['title'] }}
            <br>
        @endisset
        __Date__: {{ \Illuminate\Support\Carbon::now()->format('d.m.Y') }}
        <br>
        __Time__: {{ \Illuminate\Support\Carbon::now()->format('H:i') }}
        <br>
        __Language__: {{ \Illuminate\Support\Facades\App::getLocale() }}
        <br>

    @endslot

@endcomponent
