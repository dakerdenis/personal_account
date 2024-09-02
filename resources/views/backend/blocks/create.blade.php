@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($event) ? 'Update ' . $event->title : 'Create Event', 'breadcrumbs' => [['active' => false, 'title' => 'Events', 'link' => route('backend.events.index')],], 'buttons' => null])
        <form
            action="{{isset($event) ? route('backend.events.update', ['event' => $event->id]) : route('backend.events.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($event) ? 'put' : 'post')
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
                                                                value="{{old('title:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->title : '')}}"
                                                                id="title">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                            <textarea id="description:{{$localeCode}}" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke" name="description:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('description:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->description : '')}}
                                                            </textarea>
                                                            @error('description:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="preview:{{$localeCode}}" class="col-form-label">Preview</label>
                                                            <input type="hidden" name="delete_previews[preview:{{$localeCode}}]" value="0" class="deleteImages">
                                                            <input type="file"  name="previews[preview:{{$localeCode}}]" id="input-file-now" class="dropify_preview" data-default-file="{{isset($event) && $event->translate($localeCode)->preview ? asset('storage/uploads/events/previews').'/'.$event->translate($localeCode)->preview.'.jpg' : ''}}"/>
                                                            @error('preview:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="location:{{$localeCode}}" class="col-form-label">Location</label>
                                                                <textarea id="location:{{$localeCode}}" class="@error('location:'.$localeCode)is-invalid @enderror form-control" name="location:{{$localeCode}}" cols="30" rows="3">{{old('location:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->location : '')}}</textarea>
                                                                @error('location:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="opening:{{$localeCode}}" class="col-form-label">Opening</label>
                                                                <textarea id="opening:{{$localeCode}}" class="@error('opening:'.$localeCode)is-invalid @enderror form-control" name="opening:{{$localeCode}}" cols="30" rows="3">{{old('opening:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->opening : '')}}</textarea>
                                                                @error('opening:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="work_hours:{{$localeCode}}" class="col-form-label">Work Hours</label>
                                                                <textarea id="work_hours:{{$localeCode}}" class="@error('work_hours:'.$localeCode)is-invalid @enderror form-control" name="work_hours:{{$localeCode}}" cols="30" rows="3">{{old('work_hours:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->work_hours : '')}}</textarea>
                                                                @error('work_hours:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="organizers:{{$localeCode}}" class="col-form-label">Organizers</label>
                                                                <textarea id="organizers:{{$localeCode}}" class="@error('organizers:'.$localeCode)is-invalid @enderror form-control" name="organizers:{{$localeCode}}" cols="30" rows="3">{{old('organizers:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->organizers : '')}}</textarea>
                                                                @error('organizers:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="time:{{$localeCode}}" class="col-form-label">Time</label>
                                                                <textarea id="time:{{$localeCode}}" class="@error('time:'.$localeCode)is-invalid @enderror form-control" name="time:{{$localeCode}}" cols="30" rows="3">{{old('time:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->time : '')}}</textarea>
                                                                @error('time:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="seo_keywords:{{$localeCode}}" class="col-form-label">Seo Keywords</label>
                                                                <textarea id="seo_keywords:{{$localeCode}}" class="@error('seo_keywords:'.$localeCode)is-invalid @enderror form-control" name="seo_keywords:{{$localeCode}}" cols="30" rows="3">{{old('seo_keywords:'.$localeCode, (isset($event) && $event->translate($localeCode)) ? $event->translate($localeCode)->seo_keywords : '')}}</textarea>
                                                                @error('seo_keywords:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h5 class="text-center mt-3">Additional Info</h5>
                                        <div id="additional_info" class="p-3">
                                            @foreach(old('additional_info:ru') ?? (isset($event) && $event->additional_info ? $event->additional_info : []) as $id => $info)
                                                @include('backend.partials.additional_info', ['id' => $id, 'info' => $info])
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3">
                                        <div class="col-md-2 text-center">
                                            <button class="btn btn-outline-success" type="button" title="" data-bs-original-title="btn btn-outline-success" data-link="{{route('backend.events.add_additional_info')}}" id="add_additional_info" data-original-title="btn btn-outline-success">Add Additional Info</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <h5 class="text-center mt-3">Youtube Tags</h5>
                                        <div id="youtube_tags" class="p-3">
                                            @foreach(old('youtube_tags') ?? (isset($event) && $event->youtube_tags ? $event->youtube_tags : []) as $id => $tag)
                                                @include('backend.partials.youtube_tag', ['id' => $id, 'tag' => $tag])
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mb-3">
                                        <div class="col-md-2 text-center">
                                            <button class="btn btn-outline-success" type="button" title="" data-bs-original-title="btn btn-outline-success" data-link="{{route('backend.events.add_youtube_tag')}}" id="add_youtube_tag" data-original-title="btn btn-outline-success">Add Youtube Tag</button>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="start_date" class="col-form-label">Start Date</label>
                                                        <input class="form-control datepicker-here @error('start_date')is-invalid @enderror"
                                                               value="{{old('start_date', isset($event) ? $event->start_date->format('d.m.Y') : '')}}"
                                                               type="text" name="start_date" id="start_date">
                                                        @error('start_date')
                                                        <div class="invalid-feedback">{{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="end_date" class="col-form-label">End Date</label>
                                                        <input class="form-control datepicker-here @error('end_date')is-invalid @enderror"
                                                               value="{{old('end_date', isset($event) && $event->end_date ? $event->end_date->format('d.m.Y') : '')}}"
                                                               type="text" name="end_date" id="start_date">
                                                        @error('end_date')
                                                        <div class="invalid-feedback">{{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="slug" class="col-form-label">Url</label>
                                                        <input class="form-control @error('slug')is-invalid @enderror"
                                                               value="{{old('slug', isset($event) ? $event->slug : '')}}"
                                                               type="text" name="slug" placeholder="Link" id="slug">
                                                        @error('slug')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="order_link" class="col-form-label">Order Link</label>
                                                        <input class="form-control @error('order_link')is-invalid @enderror"
                                                               value="{{old('order_link', isset($event) ? $event->order_link : '')}}"
                                                               type="text" name="order_link" placeholder="Order Link" id="slug">
                                                        @error('order_link')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="gallery_id" class="col-form-label">Gallery</label>
                                                    <select class="form-control form-select" id="gallery_id" name="gallery_id">
                                                        <option value="">Select Gallery</option>
                                                        @foreach($galleries as $gallery)
                                                            <option {{old('gallery_id', isset($event) ? $event->gallery_id : '') == $gallery->id ? 'selected' : ''}} value="{{$gallery->id}}">{{$gallery->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('gallery_id')
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
                                                            <input type="checkbox" value="1" {{ old('active', isset($event) && $event->active) ? 'checked' : '' }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="media">
                                                    <label class="col-form-label m-r-10">By MuseumCenter?</label>
                                                    <div class="media-body text-center switch-outline">
                                                        <label class="switch">
                                                            <input type="hidden" name="by_museum_center" value="0">
                                                            <input type="checkbox" value="1" {{ old('by_museum_center', isset($event) && $event->by_museum_center) ? 'checked' : '' }} data-original-title=""
                                                                   name="by_museum_center" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($event) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.events.index')}}"
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
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
