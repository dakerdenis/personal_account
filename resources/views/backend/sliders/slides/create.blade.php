@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => $slider->name . ' Slides', 'breadcrumbs' => [
    ['active' => false, 'title' => 'Sliders', 'link' => route('backend.sliders.index')],
    ], 'buttons' => null])
        <form
            action="{{ route('backend.sliders.slides.store', ['slider' => $slider->machine_name]) }}"
            method="post" enctype='multipart/form-data'>
        @method('post')
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
                                <div class="delete-slides">

                                </div>
                                <div id="delete-lines">

                                </div>
                                <div class="row" id="slides">
                                    @foreach($slides as $slide)
                                        @include('backend.partials.slide', ['slide' => $slide, 'id' => $slide->id ])
                                    @endforeach
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row justify-content-center mb-3">
                                            <div class="col-md-2 text-center">
                                                <button class="btn btn-outline-success" type="button" title="" data-bs-original-title="btn btn-outline-success" data-link="{{route('backend.sliders.slides.get_empty_slide', ['slider' => $slider->machine_name])}}" id="add_slide" data-original-title="btn btn-outline-success">Add Slide</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button
                                            class="btn btn-primary">Save</button>
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/dragula.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/date-picker.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
