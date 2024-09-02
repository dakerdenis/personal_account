@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($branch) ? 'Update ' . $branch->title : 'Create Branch', 'breadcrumbs' => [['active' => false, 'title' => 'Branches', 'link' => route('backend.branches.index')],], 'buttons' => null])
        <form
            action="{{isset($branch) ? route('backend.branches.update', $branch) : route('backend.branches.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($branch) ? 'put' : 'post')
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
                                                            <input
                                                                class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                type="text" name="title:{{$localeCode}}"
                                                                placeholder="Title"
                                                                value="{{old('title:'.$localeCode, (isset($branch) && $branch->translate($localeCode)) ? $branch->translate($localeCode)->title : '')}}"
                                                                id="title">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="form-group col-md-6">
                                                            <label for="address:{{$localeCode}}"
                                                                   class="col-form-label">Address</label>
                                                            <textarea id="address:{{$localeCode}}"
                                                                      class="@error('address:'.$localeCode)is-invalid @enderror form-control"
                                                                      name="address:{{$localeCode}}" cols="30"
                                                                      rows="3">{{old('address:'.$localeCode, (isset($branch) && $branch->translate($localeCode)) ? $branch->translate($localeCode)->address : '')}}</textarea>
                                                            @error('address:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="work_hours:{{ $localeCode }}" class="col-form-label">Work Hours</label>
                                                            <textarea id="phone"
                                                                      class="@error('work_hours:' . $localeCode)is-invalid @enderror form-control"
                                                                      name="work_hours:{{ $localeCode }}" cols="30"
                                                                      rows="3">{{old('work_hours:'.$localeCode, (isset($branch) && $branch->translate($localeCode)) ? $branch->translate($localeCode)->work_hours : '')}}</textarea>
                                                            @error('work_hours:' . $localeCode)
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
                                            <div class="form-group col-md-6">
                                                <label for="latitude" class="col-form-label">Latitude</label>
                                                <input class="form-control @error('latitude')is-invalid @enderror"
                                                       value="{{old('latitude', isset($branch) ? $branch->latitude : '')}}"
                                                       type="text" name="latitude" id="latitude">
                                                @error('latitude')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="longitude" class="col-form-label">Longitude</label>
                                                <input class="form-control @error('longitude')is-invalid @enderror"
                                                       value="{{old('longitude', isset($branch) ? $branch->longitude : '')}}"
                                                       type="text" name="longitude" id="longitude">
                                                @error('longitude')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slug" class="col-form-label">Preview</label>
                                                    <input type="hidden" name="delete_images[]" id="deleteImages">
                                                    <input type="hidden" name="preview_url" class="url" id="preview_url">
                                                    <input type="file" data-file-id="{{isset($branch) && $branch->getFirstMedia('preview') ? $branch->getFirstMedia('preview')->id : '' }}" name="preview" id="input-file-now" class="dropify" data-default-file="{{isset($branch) && $branch->getFirstMediaUrl('preview') ? $branch->getFirstMediaUrl('preview') : '' }}"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div style="height: 100%;" class="row d-flex justify-content-between ">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="email" class="col-form-label">Email(comma separated)</label>
                                                            <textarea id="email"
                                                                      class="@error('email')is-invalid @enderror form-control"
                                                                      name="email" cols="30"
                                                                      rows="3">{{old('email', isset($branch) ? $branch->email : '')}}</textarea>
                                                            @error('email')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="phone" class="col-form-label">Phone(comma separated)</label>
                                                            <textarea id="phone"
                                                                      class="@error('phone')is-invalid @enderror form-control"
                                                                      name="phone" cols="30"
                                                                      rows="3">{{old('phone', isset($branch) ? $branch->phone : '')}}</textarea>
                                                            @error('phone')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
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
                                                            <input type="checkbox" value="1" {{old('active') === "0" ? '' : (isset($branch) && !$branch->active ? '' : 'checked') }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($branch) ? 'Update' : 'Create'}}</button>
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
