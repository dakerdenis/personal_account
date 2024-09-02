<tr>
    <td>@if($level)@foreach(range(0, $level) as $i)-@endforeach @endif{{$menu_item->title}}</td>
    <td>{{$menu_item->slug}}</td>
    <td><input name="active" class="activation"
               data-record-id="{{$menu_item->id}}"
               data-record-url="{{route('backend.navigations.menu_items.toggle_activate', ['navigation' => $navigation->machine_name, 'menu_item' => $menu_item->id])}}"
               type="checkbox" {{ $menu_item->active ? 'checked' : '' }}></td>
    <td class="w-25">

        <button class="btn btn-primary dropdown-toggle" type="button"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">Actions
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item"
               href="{{route('backend.navigations.menu_items.edit', ['navigation' => $navigation->machine_name, 'menu_item' => $menu_item->id])}}">Edit</a>
            <div class="dropdown-divider"></div>
                                                                <a class="dropdown-item txt-danger" data-record-action="delete"
                                                                   data-record-delete-url="{{route('backend.navigations.menu_items.destroy', ['navigation' => $navigation->machine_name, 'menu_item' => $menu_item->id])}}"
                                                                   data-record-name="{{$menu_item->title}}"
                                                                   data-record-id="{{$menu_item->id}}" data-bs-toggle="modal"
                                                                   href="javascript:void(0);"
                                                                   data-bs-target="#deleteModal">Delete</a>
        </div>
    </td>
</tr>
@if($menu_item->children->count())
    @foreach($menu_item->children as $child)
        @include('backend.partials.menu_item_row', ['menu_item' => $child, 'level' => $level + 2])
    @endforeach
@endif
