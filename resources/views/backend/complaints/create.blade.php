@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => 'Edit complaint #' . $complaint->id, 'breadcrumbs' => [['active' => false, 'title' => 'Complaints', 'link' => route('backend.complaints.index')],], 'buttons' => null])
    <form
        action="{{ route('backend.complaints.update', $complaint) }}"
        method="post" enctype='multipart/form-data'>
        @method('PUT')
        @csrf
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            {{--                {{dd($errors)}}--}}
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
                                    <div class="tab-content" id="myTabContent">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="title" class="col-form-label">First Name</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="id"
                                                        value="{{ $complaint->first_name }}"
                                                        id="title">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="customer"
                                                           class="col-form-label">Last Name</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="customer"
                                                        value="{{ $complaint->last_name }}"
                                                        id="customer">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="customer"
                                                           class="col-form-label">Surname</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="surname"
                                                        value="{{ $complaint->surname }}"
                                                        id="surname">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="personal_id"
                                                           class="col-form-label">Personal ID</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="personal_id"
                                                        value="{{ $complaint->personal_id }}"
                                                        id="personal_id">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="email"
                                                           class="col-form-label">E-mail</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="email"
                                                        value="{{ $complaint->email }}"
                                                        id="email">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="form-group">
                                                    <label for="phone"
                                                           class="col-form-label">Phone</label>
                                                    <input
                                                        disabled
                                                        class="form-control"
                                                        type="text" name="phone"
                                                        value="{{ $complaint->phone }}"
                                                        id="phone">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 mt-3">
                                                    <label for="message" class="col-form-label">Message</label>
                                                    <textarea id="message" readonly
                                                              class="form-control"
                                                              name="message" cols="30" rows="5">{{ $complaint->message }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row mb-5">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="complaint_status_id" class="col-form-label">Status</label>
                                                <select class="form-control form-select" id="complaint_status_id" name="complaint_status_id">
                                                    @foreach($statuses as $status)
                                                        <option {{old('complaint_status_id', $complaint->complaint_status_id) == $status->id ? 'selected' : ''}} value="{{$status->id}}">{{$status->title}}</option>
                                                    @endforeach
                                                </select>
                                                @error('gallery_id')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="change_status_date" class="col-form-label">Status change date</label>
                                                <input class="form-control datepicker-here @error('change_status_date')is-invalid @enderror"
                                                       value="{{old('change_status_date', isset($complaint) ? $complaint->change_status_date?->format('d.m.Y') : '')}}"
                                                       type="text" name="change_status_date" id="change_status_date">
                                                @error('change_status_date')
                                                <div class="invalid-feedback">{{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn-primary">Update</button>
                                    <a style="color: white" href="{{route('backend.complaints.index')}}"
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
    <script src="{{asset('backend/assets/js/slugify.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
