<div class="media">
    <div class="media-body">
        <p>{{ $log->created_at->format('Y-m-d')  }} | <span class="ps-1">{{$log->created_at->diffForHumans()}}</span>
            @if((time() - strtotime($log->created_at)) < 1200)
                <span class="badge badge-secondary">New</span>
            @endif
        </p>
        @if($log->log_name === 'auth')
            <h6>New log in attempt<span style="background-color: #2931B3;border-color: #a9ace0" class="dot-notification"></span></h6><span>{{ $log->causer->name }} logged in</span>
        @endif
        @if($log->log_name === 'content')
            @php
                try {
                    $route = route($log->getExtraProperty('route_name'), [$log->getExtraProperty('parameter') => $log->subject->id,] + ($log->getExtraProperty('parameter_2') ? [$log->getExtraProperty('parameter_2_name') => $log->getExtraProperty('parameter_2')] : []));
                } catch (\Exception $e) {
                    $route = '#';
                }
            @endphp
            <h6>Content moderating<span style="background-color: #00ff40;border-color: #b1ffc4" class="dot-notification"></span></h6>
            <span>{{ $log->causer->name }} {{$log->description}} @if($log->subject)
                    <a href="{{ $route }}">{{ ($log->subject->title ?? $log->subject->name) ?? $log->subject->author ?? $log->getExtraProperty('title') }} </a>
                @else
                    {{ $log->getExtraProperty('title') }}
                @endif </span>
        @endif
    </div>
</div>
