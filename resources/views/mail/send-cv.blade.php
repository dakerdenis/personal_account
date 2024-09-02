@component('mail::message')

    __Vacancy__: {{ $vacancy->title }}
    <br>
    __Full Name__: {{htmlspecialchars(strip_tags($data['full_name']))}}
    <br>
    __E-mail__: {{htmlspecialchars(strip_tags($data['email']))}}
    <br>
    __Phone__: +994-{{htmlspecialchars(strip_tags($data['phone']))}}
    <br>
    __Education__:
    <br>
    {!! nl2br(htmlspecialchars(strip_tags($data['education']))) !!}
    <br>

@endcomponent
