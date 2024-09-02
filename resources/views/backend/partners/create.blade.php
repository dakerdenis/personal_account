@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($partner) ? 'Update ' . $partner->title : 'Create Partner', 'breadcrumbs' => [['active' => false, 'title' => 'Partners', 'link' => route('backend.partners.index')],], 'buttons' => null])
        <form
            action="{{isset($partner) ? route('backend.partners.update', $partner) : route('backend.partners.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($partner) ? 'put' : 'post')
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
                                                            <label for="title" class="col-form-label">Title</label>
                                                            <textarea
                                                                class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                name="title:{{$localeCode}}"
                                                                id="title">{{old('title:'.$localeCode, (isset($partner) && $partner->translate($localeCode)) ? $partner->translate($localeCode)->title : '')}}</textarea>
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="form-group col-md-6">
                                                            <label for="link:{{$localeCode}}"
                                                                   class="col-form-label">Link</label>
                                                            <input id="link:{{$localeCode}}"
                                                                      class="@error('link:'.$localeCode)is-invalid @enderror form-control"
                                                                      name="link:{{$localeCode}}" cols="30"
                                                                      value="{{old('link:'.$localeCode, (isset($partner) && $partner->translate($localeCode)) ? $partner->translate($localeCode)->link : '')}}">
                                                            @error('link:'.$localeCode)
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
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slug" class="col-form-label">Preview</label>
                                                    <input type="hidden" name="delete_images[]" id="deleteImages">
                                                    <input type="hidden" name="preview_url" class="url" id="preview_url">
                                                    <input type="file" data-file-id="{{isset($partner) && $partner->getFirstMedia('preview') ? $partner->getFirstMedia('preview')->id : '' }}" name="preview" id="input-file-now" class="dropify" data-default-file="{{isset($partner) && $partner->getFirstMediaUrl('preview') ? $partner->getFirstMediaUrl('preview') : '' }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="formFile" class="form-label">File</label>
                                                <input name="review" class="form-control" type="file" id="formFile">
                                                @if(isset($partner) && $partner->review)
                                                    <p class="mt-1 mb-0">Current</p>
                                                    <p>
                                                        <a href="{{ Storage::disk('public')->url($partner->review) }}">{{ $partner->review }}</a>
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="media">
                                                    <label class="col-form-label m-r-10">Active</label>
                                                    <div class="media-body text-center switch-outline">
                                                        <label class="switch">
                                                            <input type="hidden" name="active" value="0">
                                                            <input type="checkbox" value="1" {{old('active') === "0" ? '' : (isset($partner) && !$partner->active ? '' : 'checked') }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="media">
                                                    <label class="col-form-label m-r-10">Show in block</label>
                                                    <div class="media-body text-center switch-outline">
                                                        <label class="switch">
                                                            <input type="hidden" name="show_in_block" value="0">
                                                            <input type="checkbox" value="1" {{old('show_in_block') === "0" ? '' : (isset($partner) && !$partner->show_in_block ? '' : 'checked') }} data-original-title=""
                                                                   name="show_in_block" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($partner) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.partners.index')}}"
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
