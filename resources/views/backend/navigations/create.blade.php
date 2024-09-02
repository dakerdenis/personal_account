@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($navigation) ? 'Update Navigation' : 'Create Navigation', 'breadcrumbs' => [['active' => false, 'title' => 'Navigations', 'link' => route('backend.navigations.index')],], 'buttons' => null])
        <form
            action="{{isset($navigation) ? route('backend.navigations.update', ['navigation' => $navigation->id]) : route('backend.navigations.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($navigation) ? 'put' : 'post')
        @csrf
        <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (\Session::has('message'))
                            <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                                <strong>{!! \Session::get('message')['type'] !!}
                                    ! </strong> {!! \Session::get('message')['message'] !!}
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
                                        <div class="tab-content" id="myTabContent">
                                                <div>
                                                    <div class="mb-0 ">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Name</label>
                                                            <input
                                                                class="form-control @error('name')is-invalid @enderror "
                                                                type="text" name="name"
                                                                placeholder="Name"
                                                                value="{{old('name', isset($navigation) ? $navigation->name : '')}}"
                                                                id="name">
                                                            @error('name')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button
                                            class="btn btn-primary">{{isset($navigation) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.navigations.index')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/dropify.min.css')}}">
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
