@extends('layouts.backend')
@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => isset($static_page) ? 'Update ' . $static_page->title : 'Create Article', 'breadcrumbs' => [['active' => false, 'title' => 'Articles', 'link' => route('backend.static_pages.index')],], 'buttons' => null])
        <form
            class="content-form"
            action="{{isset($static_page) ? route('backend.static_pages.update', ['static_page' => $static_page->id]) : route('backend.static_pages.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($static_page) ? 'put' : 'post')
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
                                                                placeholder="Title"
                                                                value="{{old('title:'.$localeCode, (isset($static_page) && $static_page->translate($localeCode)) ? $static_page->translate($localeCode)->title : '')}}"
                                                                id="title">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-2">
                                                            <label for="subtitle" class="col-form-label">Subtitle</label>
                                                            <input
                                                                class="form-control @error('subtitle:'.$localeCode)is-invalid @enderror "
                                                                type="text" name="subtitle:{{$localeCode}}"
                                                                placeholder="Title"
                                                                value="{{old('subtitle:'.$localeCode, (isset($static_page) && $static_page->translate($localeCode)) ? $static_page->translate($localeCode)->subtitle : '')}}"
                                                                id="subtitle">
                                                            @error('subtitle:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                            <textarea id="description:{{$localeCode}}" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke" name="description:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('description:'.$localeCode, (isset($static_page) && $static_page->translate($localeCode)) ? $static_page->translate($localeCode)->description : '')}}
                                                            </textarea>
                                                            @error('description:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-12 mt-3">
                                                                <label for="seo_keywords:{{$localeCode}}" class="col-form-label">Seo Keywords</label>
                                                                <textarea id="seo_keywords:{{$localeCode}}" class="@error('seo_keywords:'.$localeCode)is-invalid @enderror form-control" name="seo_keywords:{{$localeCode}}" cols="30" rows="3">{{old('seo_keywords:'.$localeCode, (isset($static_page) && $static_page->translate($localeCode)) ? $static_page->translate($localeCode)->seo_keywords : '')}}</textarea>
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
                                    <div class="card-footer">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="slug" class="col-form-label">Url<sup style="color: red">*</sup></label>
                                                        <input class="form-control @error('slug')is-invalid @enderror"
                                                               value="{{old('slug', isset($static_page) ? $static_page->slug : '')}}"
                                                               type="text" name="slug" placeholder="Link" id="slug">
                                                        @error('slug')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="youtube_tag" class="col-form-label">YouTube Tags(comma separated)</label>
                                                    <input class="form-control @error('youtube_tag')is-invalid @enderror"
                                                           value="{{old('youtube_tag', isset($static_page) ? $static_page->youtube_tag : '')}}"
                                                           type="text" name="youtube_tag" id="youtube_tag">
                                                    @error('youtube_tag')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4 mt-3">
                                                <div class="form-group">
                                                    <label for="gallery_id" class="col-form-label">Gallery</label>
                                                    <select class="form-control js-example-basic-single form-select" id="gallery_id" name="gallery_id">
                                                        <option value="">Select Gallery</option>
                                                        @foreach($galleries as $gallery)
                                                            <option {{old('gallery_id', isset($static_page) ? $static_page->gallery_id : '') == $gallery->id ? 'selected' : ''}} value="{{$gallery->id}}">{{$gallery->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('gallery_id')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4 mt-3">
                                                <div class="form-group">
                                                    <label for="files[]" class="col-form-label">Files</label>
                                                    <select id="files[]" name="files[]"
                                                            class="js-example-placeholder-multiple-order col-sm-12"
                                                            multiple="multiple">
                                                        <option disabled value="">Select files</option>
                                                        @foreach($files as $file)
                                                            <option value="{{$file->id}}">{{$file->title}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('files')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4 mt-3">
                                                <div class="form-group">
                                                    <label for="useful_links[]" class="col-form-label">Useful Links</label>
                                                    <select id="useful_links[]" name="useful_links[]"
                                                            class="js-example-placeholder-multiple-order-links col-sm-12"
                                                            multiple="multiple">
                                                        <option disabled value="">Select useful links</option>
                                                        @foreach($usefulLinks as $file)
                                                            <option value="{{$file->id}}">{{$file->title}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('useful_links')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="form" class="col-form-label">Form</label>
                                                    <select
                                                        class="form-control form-select js-example-basic-single @error('form')is-invalid @enderror"
                                                        id="form" name="form">
                                                        <option value="">Select</option>
                                                        @foreach(\App\Models\StaticPage::FORMS as $key => $label)
                                                            <option
                                                                {{old('form', (isset($static_page) && $static_page->form == $key)) ? 'selected' : ''}} value="{{ $key }}">{{ $label }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('form')
                                                    <div class="invalid-feedback">{{ $message }}
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
                                                            <input type="checkbox" value="1" {{ old('active', isset($static_page) && !$static_page->active) ? '' : 'checked' }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($static_page) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.static_pages.index')}}"
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
    <script>
        $('.js-example-placeholder-multiple-order').select2();

        $(".js-example-placeholder-multiple-order").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('files', isset($static_page) ? $static_page->files()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order").append(...options).trigger('change');

        $('.js-example-placeholder-multiple-order-links').select2();

        $(".js-example-placeholder-multiple-order-links").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('useful_links', isset($static_page) ? $static_page->usefulLinks()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order-links").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order-links option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order-links").append(...options).trigger('change');
    </script>
@endsection
