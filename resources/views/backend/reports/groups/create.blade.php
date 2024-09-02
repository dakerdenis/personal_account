@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($reportGroup) ? 'Update ' . $reportGroup->title : 'Create Report Group', 'breadcrumbs' => [['active' => false, 'title' => 'Report Groups', 'link' => route('backend.report_groups.index')],], 'buttons' => null])
        <form
            action="{{isset($reportGroup) ? route('backend.report_groups.update', $reportGroup) : route('backend.report_groups.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($reportGroup) ? 'put' : 'post')
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
                                                                placeholder="Title"
                                                                value="{{old('title:'.$localeCode, (isset($reportGroup) && $reportGroup->translate($localeCode)) ? $reportGroup->translate($localeCode)->title : '')}}"
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
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="reports[]" class="col-form-label">Files</label>
                                                    <select id="reports[]" name="reports[]"
                                                            class="js-example-placeholder-multiple-order col-sm-12"
                                                            multiple="multiple">
                                                        <option value="">Select reports</option>
                                                        @foreach($files as $file)
                                                            <option value="{{$file->id}}">{{$file->title}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('reports')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-5">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="report_year_id" class="col-form-label">Report Year<sup style="color: red">*</sup></label>
                                                    <select class="form-control form-select" id="report_year_id" name="report_year_id">
                                                        <option value="">Select Year</option>
                                                        @foreach($years as $year)
                                                            <option {{old('report_year_id', isset($reportGroup) && $reportGroup->reportYear ? $reportGroup->reportYear->id : '') == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->title}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('report_year_id')
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
                                                            <input type="checkbox" value="1" {{old('active') === "0" ? '' : (isset($reportGroup) && !$reportGroup->active ? '' : 'checked') }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($reportGroup) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.report_groups.index')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
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
        var serverRenderData = Array.from({!! json_encode(old('reports', isset($reportGroup) ? $reportGroup->files()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order").append(...options).trigger('change');
    </script>
@endsection
