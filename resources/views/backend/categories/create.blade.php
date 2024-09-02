@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($category) ? 'Update Category' : 'Create Category', 'breadcrumbs' => [
    ['active' => false, 'title' => 'Categories', 'link' => route('backend.categories.index')],
    ], 'buttons' => null])
    <form
        action="{{isset($category) ? route('backend.categories.update', ['category' => $category->id]) : route('backend.categories.store')}}"
        method="post" enctype='multipart/form-data'>
    @method(isset($category) ? 'put' : 'post')
    @csrf
    <!-- Container-fluid starts-->
        <div class="container-fluid">
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
                                                            value="{{old('title:'.$localeCode, (isset($category) && $category->translate($localeCode)) ? $category->translate($localeCode)->title : '')}}"
                                                            id="title">
                                                        @error('title:'.$localeCode)
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                        <textarea id="description:{{$localeCode}}"
                                                                  class="@error('description:'.$localeCode)is-invalid @enderror editor-cke"
                                                                  name="description:{{$localeCode}}" cols="30"
                                                                  rows="10">
                                                                {{old('description:'.$localeCode, (isset($category) && $category->translate($localeCode)) ? $category->translate($localeCode)->description : '')}}
                                                            </textarea>
                                                        @error('description:'.$localeCode)
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="seo_keywords:{{$localeCode}}"
                                                               class="col-form-label">Seo Keywords</label>
                                                        <textarea id="seo_keywords:{{$localeCode}}"
                                                                  class="@error('seo_keywords:'.$localeCode)is-invalid @enderror form-control"
                                                                  name="seo_keywords:{{$localeCode}}" cols="30"
                                                                  rows="3">{{old('seo_keywords:'.$localeCode, (isset($category) && $category->translate($localeCode)) ? $category->translate($localeCode)->seo_keywords : '')}}</textarea>
                                                        @error('seo_keywords:'.$localeCode)
                                                        <div class="invalid-feedback">
                                                            {{$message}}
                                                        </div>@enderror
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="meta_description:{{$localeCode}}"
                                                               class="col-form-label">Meta Description</label>
                                                        <textarea id="meta_description:{{$localeCode}}"
                                                                  class="@error('meta_description:'.$localeCode)is-invalid @enderror form-control"
                                                                  name="meta_description:{{$localeCode}}" cols="30"
                                                                  rows="3">{{old('meta_description:'.$localeCode, (isset($category) && $category->translate($localeCode)) ? $category->translate($localeCode)->meta_description : '')}}</textarea>
                                                        @error('meta_description:'.$localeCode)
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
                                                       value="{{old('slug', isset($category) ? $category->slug : '')}}"
                                                       type="text" name="slug" placeholder="Link" id="slug">
                                                @error('slug')
                                                <div class="invalid-feedback">Please provide a valid Url.
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="parent_id" class="col-form-label">Parent Item</label>
                                                <select class="form-control form-select" id="parent_id"
                                                        name="parent_id">
                                                    <option value="">Select parent item</option>
                                                    @foreach($categories as $parent)
                                                        @include('backend.partials.menu_item_parent_option', ['parent' => $parent, 'record' => $category ?? null, 'level' => 0])
                                                    @endforeach
                                                </select>
                                                @error('slug')
                                                <div class="invalid-feedback">Please provide a valid Url.
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="taxonomy" class="col-form-label">Taxonomy<sup style="color: red">*</sup></label>
                                                <select class="form-control form-select" id="taxonomy" name="taxonomy">
                                                    <option value="">Select Taxonomy</option>
                                                    @foreach($taxonomies as $tax => $name)
                                                        <option
                                                            {{old('taxonomy', (isset($category) && $category->taxonomy == $tax)) ? 'selected' : ''}} value="{{$tax}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('taxonomy')
                                                <div class="invalid-feedback">Please provide a taxonomy.
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug" class="col-form-label">Preview</label>
                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                <input type="hidden" class="url" name="preview_url" id="preview_url">
                                                <input type="file"
                                                       data-file-id="{{isset($category) && $category->getFirstMedia('preview') ? $category->getFirstMedia('preview')->id : '' }}"
                                                       name="preview" id="input-file-now" class="dropify"
                                                       data-default-file="{{isset($category) && $category->getFirstMediaUrl('preview') ? $category->getFirstMediaUrl('preview') : '' }}"/>
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
                                                        <input type="checkbox" value="1"
                                                               {{old('active') === "0" ? '' : (isset($category) && !$category->active ? '' : 'checked') }} data-original-title=""
                                                               name="active" title=""><span
                                                            class="switch-state bg-primary"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="media">
                                                <label class="col-form-label m-r-10">Show date on articles</label>
                                                <div class="media-body text-center switch-outline">
                                                    <label class="switch">
                                                        <input type="hidden" name="show_date_on_articles" value="0">
                                                        <input type="checkbox" value="1"
                                                               {{old('show_date_on_articles') === "0" ? '' : (isset($category) && !$category->show_date_on_articles ? '' : 'checked') }} data-original-title=""
                                                               name="show_date_on_articles" title=""><span
                                                            class="switch-state bg-primary"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn-primary">{{isset($category) ? 'Update' : 'Create'}}</button>
                                    <a style="color: white" href="{{route('backend.categories.index')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/slugify.js')}}"></script>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
    <script src="{{ asset('backend/assets/js/select2/select2.full.min.js') }}"></script>
@endsection
