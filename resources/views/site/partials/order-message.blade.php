@php
    /**
     * @var \App\Models\OrderMessage $message
     */
@endphp
<tr>
    <td>{{ $message->created_at->formatLocalized('%d %b %Y') }}</td>
    <td>{{ $message->created_at->format('H:i') }}</td>
    <td>
        @if($message->user)
            {{ $message->user->full_name }}
        @else
            {{ $message->staff->name }}
        @endif
    </td>
    <td>{!! nl2br($message->message) !!}</td>
</tr>
