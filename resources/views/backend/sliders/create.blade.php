@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($slider) ? 'Update Slider' : 'Create Slider', 'breadcrumbs' => [['active' => false, 'title' => 'Sliders', 'link' => route('backend.sliders.index')],], 'buttons' => null])
        <form
            action="{{isset($slider) ? route('backend.sliders.update', ['slider' => $slider->id]) : route('backend.sliders.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($slider) ? 'put' : 'post')
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
                                                                value="{{old('name', isset($slider) ? $slider->name : '')}}"
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
                                            class="btn btn-primary">{{isset($slider) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.sliders.index')}}"
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
