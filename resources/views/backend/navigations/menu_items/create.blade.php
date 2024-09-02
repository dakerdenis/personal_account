@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($menu_item) ? 'Update Menu Item' : 'Create Menu Item', 'breadcrumbs' => [
    ['active' => false, 'title' => 'Navigations', 'link' => route('backend.navigations.index')],
    ['active' => false, 'title' => $navigation->name, 'link' => route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])]
    ], 'buttons' => null])
        <form
            action="{{isset($menu_item) ? route('backend.navigations.menu_items.update', ['navigation' => $navigation->machine_name, 'menu_item' => $menu_item->id]) : route('backend.navigations.menu_items.store', ['navigation' => $navigation->machine_name])}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($menu_item) ? 'put' : 'post')
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
                                                            <label for="name" class="col-form-label">Title<sup style="color: red">*</sup></label>
                                                            <input
                                                                class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                type="text" name="title:{{$localeCode}}"
                                                                placeholder="Title"
                                                                value="{{old('title:'.$localeCode, (isset($menu_item) && $menu_item->translate($localeCode)) ? $menu_item->translate($localeCode)->title : '')}}"
                                                                id="name">
                                                            @error('title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="sub_title:{{$localeCode}}" class="col-form-label">Sub Title</label>
                                                            <textarea id="sub_title:{{$localeCode}}" class="@error('sub_title:'.$localeCode)is-invalid @enderror form-control" name="sub_title:{{$localeCode}}" cols="30" rows="3">{{old('sub_title:'.$localeCode, (isset($menu_item) && $menu_item->translate($localeCode)) ? $menu_item->translate($localeCode)->sub_title : '')}}</textarea>
                                                            @error('sub_title:'.$localeCode)
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="seo_keywords:{{$localeCode}}" class="col-form-label">Seo Keywords</label>
                                                            <textarea id="seo_keywords:{{$localeCode}}" class="@error('seo_keywords:'.$localeCode)is-invalid @enderror form-control" name="seo_keywords:{{$localeCode}}" cols="30" rows="3">{{old('seo_keywords:'.$localeCode, (isset($menu_item) && $menu_item->translate($localeCode)) ? $menu_item->translate($localeCode)->seo_keywords : '')}}</textarea>
                                                            @error('seo_keywords:'.$localeCode)
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
                                                        <label for="slug" class="col-form-label">Url<sup style="color: red">*</sup></label>
                                                        <input class="form-control @error('slug')is-invalid @enderror"
                                                               value="{{old('slug', isset($menu_item) ? $menu_item->slug : '')}}"
                                                               type="text" name="slug" placeholder="Link" id="slug">
                                                        @error('slug')
                                                        <div class="invalid-feedback">Please provide a valid Url.
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                            <div class="col-md-6">
                                                    <div class="form-group">
                                                            <label for="parent_id" class="col-form-label">Parent Item</label>
                                                            <select class="form-control form-select" id="parent_id" name="parent_id">
                                                                <option value="">Select parent item</option>
                                                                @foreach($menu_items as $parent)
                                                                    @include('backend.partials.menu_item_parent_option', ['parent' => $parent, 'record' => $menu_item ?? null,'level' => 0])
                                                                @endforeach
                                                            </select>
                                                        @error('slug')
                                                        <div class="invalid-feedback">Please provide a valid Url.
                                                        </div>@enderror
                                                    </div>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="slug" class="col-form-label">Icon</label>
                                                    <input type="hidden" name="delete_images[]" id="deleteImages">
                                                    <input type="hidden" name="preview_url" class="url" id="preview_url">
                                                    <input type="file" data-file-id="{{isset($menu_item) && $menu_item->getFirstMedia('preview') ? $menu_item->getFirstMedia('preview')->id : '' }}" name="preview" id="input-file-now" class="dropify" data-default-file="{{isset($menu_item) && $menu_item->getFirstMediaUrl('preview') ? $menu_item->getFirstMediaUrl('preview') : '' }}"/>
                                                    @error('preview')
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
                                                            <input type="checkbox" value="1"  {{old('active') === "0" ? '' : (isset($menu_item) && !$menu_item->active ? '' : 'checked') }} data-original-title=""
                                                                   name="active" title=""><span
                                                                class="switch-state bg-primary"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button
                                            class="btn btn-primary">{{isset($menu_item) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])}}"
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
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
