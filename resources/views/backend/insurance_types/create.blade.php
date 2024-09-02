@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($insuranceType) ? 'Update ' . $insuranceType->title : 'Create Insurance Type', 'breadcrumbs' => [['active' => false, 'title' => 'Insurance Types', 'link' => route('backend.insurance_types.index')],], 'buttons' => null])
        <form
            action="{{isset($insuranceType) ? route('backend.insurance_types.update', $insuranceType) : route('backend.insurance_types.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($insuranceType) ? 'put' : 'post')
        @csrf
        <!-- Container-fluid starts-->
            <div class="container-fluid">
{{--                {{dd($errors)}}--}}
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
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                                                <li class="nav-item">
                                                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                                                       id="{{ $localeCode }}-tab" data-bs-toggle="tab"
                                                       href="#{{ $localeCode }}" role="tab"
                                                       aria-controls="{{ $localeCode }}"
                                                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                                                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                                                     id="{{$localeCode}}" role="tabpanel"
                                                     aria-labelledby="{{$localeCode}}-tab">
                                                    <div class="mb-0 m-t-30">
                                                        <div class="form-group">
                                                            <label for="title" class="col-form-label">Title<sup style="color: red">*</sup></label>
                                                            <input
                                                                class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                type="text" name="title:{{$localeCode}}"
                                                                value="{{old('title:'.$localeCode, (isset($insuranceType) && $insuranceType->translate($localeCode)) ? $insuranceType->translate($localeCode)->title : '')}}"
                                                                id="title">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="form_recipients" class="col-form-label">Form Receivers(each new line)</label>
                                                    <textarea class="form-control @error('form_recipients') is-invalid @enderror" name="form_recipients" id="form_recipients" cols="30" rows="4">{{old('form_recipients', isset($insuranceType) ? $insuranceType->form_recipients : '')}}</textarea>
                                                    @error('form_recipients')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="media">
                                                    <label class="col-form-label m-r-10">Active</label>
                                                    <div class="media-body text-center switch-outline">
                                                        <label class="switch">
                                                            <input type="hidden" name="active" value="0">
                                                            <input type="checkbox" value="1" {{old('active') === "0" ? '' : (isset($insuranceType) && !$insuranceType->active ? '' : 'checked') }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($insuranceType) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.managers.index')}}"
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
