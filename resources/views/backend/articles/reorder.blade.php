@extends('layouts.backend')
@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Reorder Articles', 'breadcrumbs' => [
        ['active' => true, 'title' => 'Articles', 'link' => null],
        ], 'buttons' => null])
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div id="dragTree" data-reorder-action="{{route('backend.articles.reorder')}}">
                                <ul>
                                    @foreach ($articles as $page)
                                        @include('backend.partials.reorder_line', ['record' => $page])
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a style="color: white" href="{{route('backend.articles.index')}}" class="btn btn-primary">Apply</a>
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
