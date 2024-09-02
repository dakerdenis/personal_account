@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => 'Edit Settings', 'breadcrumbs' => [], 'buttons' => null])
        <form
            class="content-form"
            action="{{route('backend.settings.update')}}"
            method="post" enctype='multipart/form-data'>
        @method('put')
        @csrf
        <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        @if (Session::has('message'))
                            <div class="alert alert-{!! strtolower(Session::get('message')['type']) !!} dark alert-dismissible fade show" role="alert">
                                <strong>{!! Session::get('message')['type'] !!}
                                    ! </strong> {!! Session::get('message')['message'] !!}
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                        data-original-title="" title=""><span aria-hidden="true"></span></button>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-footer">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="complaintFormReceivers" class="col-form-label">Complaint form receivers</label>
                                                    <textarea class="form-control" name="complaintFormReceivers" id="complaintFormReceivers" cols="30" rows="4">{{old('complaintFormReceivers', isset($settings) ? $settings->complaintFormReceivers : '')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vacancyFormReceivers" class="col-form-label">Vacancy form receivers</label>
                                                    <textarea class="form-control" name="vacancyFormReceivers" id="vacancyFormReceivers" cols="30" rows="4">{{old('vacancyFormReceivers', isset($settings) ? $settings->vacancyFormReceivers : '')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="contactsFormReceivers" class="col-form-label">Contact form receivers</label>
                                                    <textarea class="form-control" name="contactsFormReceivers" id="contactsFormReceivers" cols="30" rows="4">{{old('contactsFormReceivers', isset($settings) ? $settings->contactsFormReceivers : '')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">Update</button>
                                        <a style="color: white" href="{{route('backend.dashboard')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/slugify.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
    <script src="{{ asset('backend/assets/js/select2/select2.full.min.js') }}"></script>
@endsection
