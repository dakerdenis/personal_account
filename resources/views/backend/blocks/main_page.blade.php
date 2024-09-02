@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => $title , 'breadcrumbs' => [['active' => false, 'title' => 'Blocks', 'link' => route('backend.blocks.index')],], 'buttons' => null])
    <form
        action="{{route($route)}}"
        method="post" enctype='multipart/form-data'>
    @csrf
    <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (Session::has('message'))
                        <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                            <strong>{!! Session::get('message')['type'] !!}
                                ! </strong> {!! Session::get('message')['message'] !!}
                            <button class="close" type="button" data-dismiss="alert" aria-label="Close"
                                    data-original-title="" title=""><span aria-hidden="true">×</span></button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" name="data" value="">
                                        <div class="col-sm-12" id="blocks">
                                            @foreach($blocks as $block)
                                                @include('backend.partials.select_block', ['id' => $block])
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3">
                                        <div class="col-md-2 text-center">
                                            <button class="btn btn-outline-success" type="button" title="" data-bs-original-title="btn btn-outline-success" data-link="{{route('backend.blocks.select_block_line')}}" id="add_select_block_line" data-original-title="btn btn-outline-success">Add Block</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button
                                        class="btn btn-primary">Save</button>
                                    <a style="color: white" href="{{route('backend.blocks.index')}}"
                                       class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </form>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('backend/assets/css/dragula.min.css')}}">
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/typeahead/handlebars.js"></script>
    <script src="{{ asset('backend/assets') }}/js/typeahead/typeahead.bundle.js"></script>
    <script>
        var bestPictures = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: '{{route('backend.blocks.search_block')}}?search=%QUERY',
                wildcard: '%QUERY'
            },
            transform: function (response) {
                console.log(response);
            },
            identify: function(obj) { return obj.value }
        });
    </script>
@endsection
