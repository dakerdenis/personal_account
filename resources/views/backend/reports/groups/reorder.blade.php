@extends('layouts.backend')
@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Reorder Report Groups', 'breadcrumbs' => [
        ['active' => true, 'title' => 'Report Groups', 'link' => null],
        ], 'buttons' => null])
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            @foreach($years as $year)
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ $year->title }}</h5>
                            </div>
                            <div class="card-body">
                                <div class="dragTree" data-reorder-action="{{route('backend.report_groups.reorder')}}">
                                    <ul>
                                        @foreach ($year->reportGroups()->orderBy('_lft')->get() as $group)
                                            @include('backend.partials.reorder_line', ['record' => $group])
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card-footer">
                <a style="color: white" href="{{route('backend.report_groups.index')}}" class="btn btn-primary">Apply</a>
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
