@extends('layouts.backend')
@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Reorder Menu Items', 'breadcrumbs' => [
        ['active' => false, 'title' => $navigation->name, 'link' => route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])],
        ], 'buttons' => null])
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div id="dragTree" data-reorder-action="{{route('backend.navigations.menu_items.reorder', ['navigation' => $navigation->machine_name])}}">
                                <ul>
                                    @foreach ($menu_items as $menu_item)
                                        @include('backend.partials.reorder_line', ['record' => $menu_item])
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a style="color: white" href="{{route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])}}" class="btn btn-primary">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/tree.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/tree/jstree.min.js')}}"></script>
@endsection
