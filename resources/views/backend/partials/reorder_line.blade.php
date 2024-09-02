<li data-record-id="{{$record->id}}" {!! count($record->children) ? 'data-jstree="{&quot;opened&quot;:true}"': '' !!} >{{$record->title}} @if($record->slug)  {{ $record->slug }} @endif()
    @if($record->children->count())
        <ul data-record-parent="{{$record->id}}">
            @foreach($record->children as $child)
                @include('backend.partials.reorder_line', ['record' => $child])
            @endforeach
        </ul>
    @endif
</li>
