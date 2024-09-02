@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($vacancy) ? 'Update ' . $vacancy->title : 'Create Vacancies', 'breadcrumbs' => [['active' => false, 'title' => 'Articles', 'link' => route('backend.vacancies.index')],], 'buttons' => null])
        <form
            class="content-form"
            action="{{isset($vacancy) ? route('backend.vacancies.update', $vacancy) : route('backend.vacancies.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($vacancy) ? 'put' : 'post')
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
                                                                value="{{old('title:'.$localeCode, (isset($vacancy) && $vacancy->translate($localeCode)) ? $vacancy->translate($localeCode)->title : '')}}"
                                                                id="title">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                            <textarea id="description:{{$localeCode}}" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke" name="description:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('description:'.$localeCode, (isset($vacancy) && $vacancy->translate($localeCode)) ? $vacancy->translate($localeCode)->description : '')}}
                                                            </textarea>
                                                            @error('description:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="requirements:{{$localeCode}}" class="col-form-label">Requirements</label>
                                                            <textarea id="requirements:{{$localeCode}}" class="@error('requirements:'.$localeCode)is-invalid @enderror editor-cke" name="requirements:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('requirements:'.$localeCode, (isset($vacancy) && $vacancy->translate($localeCode)) ? $vacancy->translate($localeCode)->requirements : '')}}
                                                            </textarea>
                                                            @error('requirements:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="conditions:{{$localeCode}}" class="col-form-label">Conditions</label>
                                                            <textarea id="conditions:{{$localeCode}}" class="@error('conditions:'.$localeCode)is-invalid @enderror editor-cke" name="conditions:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('conditions:'.$localeCode, (isset($vacancy) && $vacancy->translate($localeCode)) ? $vacancy->translate($localeCode)->conditions : '')}}
                                                            </textarea>
                                                            @error('conditions:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="contacts:{{$localeCode}}" class="col-form-label">Contacts</label>
                                                            <textarea id="contacts:{{$localeCode}}" class="@error('contacts:'.$localeCode)is-invalid @enderror editor-cke" name="contacts:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('contacts:'.$localeCode, (isset($vacancy) && $vacancy->translate($localeCode)) ? $vacancy->translate($localeCode)->contacts : '')}}
                                                            </textarea>
                                                            @error('contacts:'.$localeCode)
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
                                                    <label for="date" class="col-form-label">Date<sup style="color: red">*</sup></label>
                                                    <input class="form-control datepicker-here @error('date')is-invalid @enderror"
                                                           value="{{old('date', isset($vacancy) ? $vacancy->date->format('d.m.Y') : '')}}"
                                                           type="text" name="date" id="date">
                                                    @error('date')
                                                    <div class="invalid-feedback">{{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
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
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="slug" class="col-form-label">Url</label>
                                                        <input class="form-control @error('slug')is-invalid @enderror"
                                                               value="{{old('slug', isset($vacancy) ? $vacancy->slug : '')}}"
                                                               type="text" name="slug" placeholder="Link" id="slug">
                                                        @error('slug')
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="vacancy_place_title_id" class="col-form-label">Place</label>
                                                    <select class="form-control form-select" id="vacancy_place_title_id" name="vacancy_place_title_id">
                                                        @foreach($titles as $title)
                                                            <option {{old('vacancy_place_title_id', isset($vacancy) ? $vacancy->vacancy_place_title_id : '') == $title->id ? 'selected' : ''}} value="{{$title->id}}">{{$title->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('vacancy_place_title_id')
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
                                                            <input type="checkbox" value="1" {{ old('active', isset($vacancy) && !$vacancy->active) ? '' : 'checked' }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($vacancy) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.vacancies.index')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/slugify.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
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
        var serverRenderData = Array.from({!! json_encode(old('files', isset($vacancy) ? $vacancy->files()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order").append(...options).trigger('change');
    </script>
@endsection
