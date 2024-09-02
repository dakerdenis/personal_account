<option {{(isset($record) && $record->parent_id == $parent->id) ? 'selected': ''}} value="{{$parent->id}}">@if($level)@foreach(range(1, $level) as $i)-@endforeach @endif{{$parent->title}}</option>
@if($parent->children->count())
    @foreach($parent->children as $child)
        @include('backend.partials.menu_item_parent_option', ['parent' => $child, 'level' => $level + 2])
    @endforeach
@endif
