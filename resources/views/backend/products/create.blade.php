@php use App\Models\Product; @endphp
@extends('layouts.backend')
@section('content')
    @php
        /** @var Product $product */
    @endphp
    @include('backend.partials.title_breadcrumbs', ['title' => isset($product) ? 'Update ' . $product->title : 'Create Product', 'breadcrumbs' => [['active' => false, 'title' => 'Products', 'link' => route('backend.products.index')],], 'buttons' => null])
    <form
        action="{{isset($product) ? route('backend.products.update', ['product' => $product->id]) : route('backend.products.store')}}"
        method="post" enctype='multipart/form-data'>
        @method(isset($product) ? 'put' : 'post')
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
                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">General</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="title" class="col-form-label">Title<sup
                                                                                        style="color: red">*</sup></label>
                                                                                <input
                                                                                    class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="title:{{$localeCode}}"
                                                                                    placeholder="Title"
                                                                                    value="{{old('title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->title : '')}}"
                                                                                    id="title">
                                                                                @error('title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 mt-2">
                                                                            <div class="form-group">
                                                                                <label for="sub_title" class="col-form-label">Sub Title</label>
                                                                                <input
                                                                                    class="form-control @error('sub_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="sub_title:{{$localeCode}}"
                                                                                    placeholder="Title"
                                                                                    value="{{old('sub_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->sub_title : '')}}"
                                                                                    id="sub_title">
                                                                                @error('sub_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <div class="form-group mt-3">
                                                                                <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                                                <textarea id="description:{{$localeCode}}" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke" name="description:{{$localeCode}}" cols="30" rows="5">
                                                                                    {{old('description:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->description : '')}}
                                                                                </textarea>
                                                                                @error('description:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Seo</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label for="meta_title" class="col-form-label">Meta Title</label>
                                                                                <input
                                                                                    class="form-control @error('meta_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="meta_title:{{$localeCode}}"
                                                                                    value="{{old('meta_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->meta_title : '')}}"
                                                                                    id="meta_title">
                                                                                @error('meta_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-md-12 mt-3">
                                                                            <label for="meta_description:{{$localeCode}}"
                                                                                   class="col-form-label">Meta Description</label>
                                                                            <textarea id="meta_description:{{$localeCode}}"
                                                                                      class="@error('meta_description:'.$localeCode)is-invalid @enderror form-control"
                                                                                      name="meta_description:{{$localeCode}}" cols="30"
                                                                                      rows="3">{{old('meta_description:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->meta_description : '')}}</textarea>
                                                                            @error('meta_description:'.$localeCode)
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-12 mt-3">
                                                                            <label for="seo_keywords:{{$localeCode}}"
                                                                                   class="col-form-label">Seo Keywords</label>
                                                                            <textarea id="seo_keywords:{{$localeCode}}"
                                                                                      class="@error('seo_keywords:'.$localeCode)is-invalid @enderror form-control"
                                                                                      name="seo_keywords:{{$localeCode}}" cols="30"
                                                                                      rows="3">{{old('seo_keywords:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->seo_keywords : '')}}</textarea>
                                                                            @error('seo_keywords:'.$localeCode)
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Statistics block</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12 mt-3">
                                                                            <label for="statistics:{{$localeCode}}[text]"
                                                                                   class="col-form-label">Text</label>
                                                                            <textarea id="statistics:{{$localeCode}}[text]"
                                                                                      class="@error('statistics:'.$localeCode . '.text')is-invalid @enderror form-control"
                                                                                      name="statistics:{{$localeCode}}[text]" cols="30"
                                                                                      rows="3">{{old('statistics:'.$localeCode . '.text', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->statistics->text : '')}}</textarea>
                                                                            @error('statistics:'.$localeCode . '.text')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="statistics:{{$localeCode}}[first_line]" class="col-form-label">First line</label>
                                                                            <input
                                                                                class="form-control @error('statistics:'.$localeCode . '.first_line')is-invalid @enderror "
                                                                                type="text" name="statistics:{{$localeCode}}[first_line]"
                                                                                value="{{old('statistics:'.$localeCode . '.first_line', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->statistics->first_line : '')}}"
                                                                                id="statistics:{{$localeCode}}[first_line]">
                                                                            @error('statistics:'.$localeCode . '.first_line')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="statistics:{{$localeCode}}[first_line_red]" class="col-form-label">First line red</label>
                                                                            <input
                                                                                class="form-control @error('statistics:'.$localeCode . '.first_line_red')is-invalid @enderror "
                                                                                type="text" name="statistics:{{$localeCode}}[first_line_red]"
                                                                                value="{{old('statistics:'.$localeCode . '.first_line_red', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->statistics->first_line_red : '')}}"
                                                                                id="statistics:{{$localeCode}}[first_line_red]">
                                                                            @error('statistics:'.$localeCode . '.first_line_red')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="statistics:{{$localeCode}}[second_line]" class="col-form-label">Second line</label>
                                                                            <input
                                                                                class="form-control @error('statistics:'.$localeCode . '.second_line')is-invalid @enderror "
                                                                                type="text" name="statistics:{{$localeCode}}[second_line]"
                                                                                value="{{old('statistics:'.$localeCode . '.second_line', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->statistics->second_line : '')}}"
                                                                                id="statistics:{{$localeCode}}[second_line]">
                                                                            @error('statistics:'.$localeCode . '.second_line')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="statistics:{{$localeCode}}[second_line_red]" class="col-form-label">Second line red</label>
                                                                            <input
                                                                                class="form-control @error('statistics:'.$localeCode . '.second_line_red')is-invalid @enderror "
                                                                                type="text" name="statistics:{{$localeCode}}[second_line_red]"
                                                                                value="{{old('statistics:'.$localeCode . '.second_line_red', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->statistics->second_line_red : '')}}"
                                                                                id="statistics:{{$localeCode}}[second_line_red]">
                                                                            @error('statistics:'.$localeCode . '.second_line_red')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Calculator&Form titles</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="calculator_title" class="col-form-label">Calculator title</label>
                                                                                <input
                                                                                    class="form-control @error('calculator_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="calculator_title:{{$localeCode}}"
                                                                                    value="{{old('calculator_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->calculator_title : '')}}"
                                                                                    id="calculator_title">
                                                                                @error('calculator_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="form_title" class="col-form-label">Form title</label>
                                                                                <input
                                                                                    class="form-control @error('form_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="form_title:{{$localeCode}}"
                                                                                    value="{{old('form_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->form_title : '')}}"
                                                                                    id="form_title">
                                                                                @error('form_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Insurance conditions & Files section title</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="insurance_conditions_title" class="col-form-label">Insurance conditions title</label>
                                                                                <input
                                                                                    class="form-control @error('insurance_conditions_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="insurance_conditions_title:{{$localeCode}}"
                                                                                    value="{{old('insurance_conditions_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->insurance_conditions_title : '')}}"
                                                                                    id="insurance_conditions_title">
                                                                                @error('insurance_conditions_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="files_title" class="col-form-label">Files title</label>
                                                                                <input
                                                                                    class="form-control @error('files_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="files_title:{{$localeCode}}"
                                                                                    value="{{old('files_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->files_title : '')}}"
                                                                                    id="files_title">
                                                                                @error('files_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Packages section</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label for="packages_title" class="col-form-label">Packages Title</label>
                                                                                <input
                                                                                    class="form-control @error('packages_title:'.$localeCode)is-invalid @enderror "
                                                                                    type="text" name="packages_title:{{$localeCode}}"
                                                                                    value="{{old('packages_title:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->packages_title : '')}}"
                                                                                    id="packages_title">
                                                                                @error('packages_title:'.$localeCode)
                                                                                <div class="invalid-feedback">
                                                                                    {{$message}}
                                                                                </div>@enderror
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group col-md-6">
                                                                            <label for="packages_description:{{$localeCode}}"
                                                                                   class="col-form-label">Packages Description</label>
                                                                            <textarea id="packages_description:{{$localeCode}}"
                                                                                      class="@error('packages_description:'.$localeCode)is-invalid @enderror form-control"
                                                                                      name="packages_description:{{$localeCode}}" cols="30"
                                                                                      rows="3">{{old('packages_description:'.$localeCode, (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->packages_description : '')}}</textarea>
                                                                            @error('packages_description:'.$localeCode)
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <div class="card card-absolute">
                                                                <div class="card-header bg-primary">
                                                                    <h5 class="text-white">Banner block</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="form-group col-md-12">
                                                                            <label for="banner:{{$localeCode}}[title]" class="col-form-label">Banner title</label>
                                                                            <input
                                                                                class="form-control @error('banner:'.$localeCode . '.title')is-invalid @enderror "
                                                                                type="text" name="banner:{{$localeCode}}[title]"
                                                                                value="{{old('banner:'.$localeCode . '.title', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner?->title : '')}}"
                                                                                id="banner:{{$localeCode}}[title]">
                                                                            @error('banner:'.$localeCode . '.title')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-12 mt-3">
                                                                            <label for="banner:{{$localeCode}}[text]"
                                                                                   class="col-form-label">Banner Text</label>
                                                                            <textarea id="banner:{{$localeCode}}[text]"
                                                                                      class="@error('banner:'.$localeCode . '.text')is-invalid @enderror form-control"
                                                                                      name="banner:{{$localeCode}}[text]" cols="30"
                                                                                      rows="3">{{old('banner:'.$localeCode . '.text', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner->text : '')}}</textarea>
                                                                            @error('banner:'.$localeCode . '.text')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="banner:{{$localeCode}}[left_button_text]" class="col-form-label">First button text</label>
                                                                            <input
                                                                                class="form-control @error('banner:'.$localeCode . '.left_button_text')is-invalid @enderror "
                                                                                type="text" name="banner:{{$localeCode}}[left_button_text]"
                                                                                value="{{old('banner:'.$localeCode . '.left_button_text', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner->left_button_text : '')}}"
                                                                                id="banner:{{$localeCode}}[left_button_text]">
                                                                            @error('banner:'.$localeCode . '.left_button_text')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="banner:{{$localeCode}}[left_button_link]" class="col-form-label">First button link</label>
                                                                            <input
                                                                                class="form-control @error('banner:'.$localeCode . '.left_button_link')is-invalid @enderror "
                                                                                type="text" name="banner:{{$localeCode}}[left_button_link]"
                                                                                value="{{old('banner:'.$localeCode . '.left_button_link', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner?->left_button_link : '')}}"
                                                                                id="banner:{{$localeCode}}[left_button_link]">
                                                                            @error('banner:'.$localeCode . '.left_button_link')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="banner:{{$localeCode}}[right_button_text]" class="col-form-label">Second button text</label>
                                                                            <input
                                                                                class="form-control @error('banner:'.$localeCode . '.right_button_text')is-invalid @enderror "
                                                                                type="text" name="banner:{{$localeCode}}[right_button_text]"
                                                                                value="{{old('banner:'.$localeCode . '.right_button_text', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner?->right_button_text : '')}}"
                                                                                id="banner:{{$localeCode}}[right_button_text]">
                                                                            @error('banner:'.$localeCode . '.second_line_red')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label for="banner:{{$localeCode}}[right_button_link]" class="col-form-label">Second button link</label>
                                                                            <input
                                                                                class="form-control @error('banner:'.$localeCode . '.right_button_link')is-invalid @enderror "
                                                                                type="text" name="banner:{{$localeCode}}[right_button_link]"
                                                                                value="{{old('banner:'.$localeCode . '.right_button_link', (isset($product) && $product->translate($localeCode)) ? $product->translate($localeCode)->banner?->right_button_link ?? '' : '')}}"
                                                                                id="banner:{{$localeCode}}[right_button_link]">
                                                                            @error('banner:'.$localeCode . '.right_button_link')
                                                                            <div class="invalid-feedback">
                                                                                {{$message}}
                                                                            </div>@enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="card card-absolute">
                                                <div class="card-header bg-primary">
                                                    <h5 class="text-white">Insurance Conditions</h5>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12" id="repeatables35">
                                                            @isset($product)
                                                                @foreach($product->insuranceConditions()->ordered()->get() as $block)
                                                                    @include('backend.partials.specification', ['id' => $block->id, 'insuranceCondition' => $block])
                                                                @endforeach
                                                            @endisset
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3">
                                                        <div class="col-md-2 text-center">
                                                            <button class="btn btn-outline-success" type="button"
                                                                    data-link="{{route('backend.products.get-insurance-block')}}"
                                                                    id="add_descripionText" data-original-title="btn btn-outline-success">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="card card-absolute">
                                                <div class="card-header bg-primary">
                                                    <h5 class="text-white">Product Features</h5>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12" id="repeatables2">
                                                            @isset($product)
                                                                @foreach($product->productFeatures()->ordered()->get() as $block)
                                                                    @include('backend.partials.description', ['id' => $block->id, 'feature' => $block])
                                                                @endforeach
                                                            @endisset
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3">
                                                        <div class="col-md-2 text-center">
                                                            <button class="btn btn-outline-success" type="button"
                                                                    data-link="{{route('backend.products.get-feature-block')}}"
                                                                    id="add_descripion2" data-original-title="btn btn-outline-success">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col">
                                            <div class="card card-absolute">
                                                <div class="card-header bg-primary">
                                                    <h5 class="text-white">FAQ</h5>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-sm-12" id="repeatablesFAQ">
                                                            @isset($product)
                                                                @foreach($product->faqs()->ordered()->get() as $block)
                                                                    @include('backend.partials.faqs', ['id' => $block->id, 'faq' => $block])
                                                                @endforeach
                                                            @endisset
                                                        </div>
                                                    </div>
                                                    <div class="row justify-content-center mb-3">
                                                        <div class="col-md-2 text-center">
                                                            <button class="btn btn-outline-success" type="button"
                                                                    data-link="{{route('backend.products.get-faq-block')}}"
                                                                    id="add_descripionFAQ" data-original-title="btn btn-outline-success">
                                                                Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="card card-absolute">
                                            <div class="card-header bg-primary">
                                                <h5 class="text-white">Product Info</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="slug" class="col-form-label">Url</label>
                                                            <input
                                                                class="form-control @error('slug')is-invalid @enderror "
                                                                type="text" name="slug"
                                                                value="{{old('slug', isset($product) ? $product->slug : '')}}"
                                                                id="slug">
                                                            @error('slug')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">

                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="calculator" class="col-form-label">Calculator</label>
                                                            <select
                                                                class="form-control form-select js-example-basic-single @error('calculator')is-invalid @enderror"
                                                                id="calculator" name="calculator">
                                                                <option value="">Select</option>
                                                                @foreach(Product::CALCULATORS as $key => $label)
                                                                    <option
                                                                        {{old('calculator', (isset($product) && $product->calculator == $key)) ? 'selected' : ''}} value="{{ $key }}">{{ $label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('calculator')
                                                            <div class="invalid-feedback">{{ $message }}
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
                                                                @foreach(Product::FORMS as $key => $label)
                                                                    <option
                                                                        {{old('form', (isset($product) && $product->form == $key)) ? 'selected' : ''}} value="{{ $key }}">{{ $label }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('form')
                                                            <div class="invalid-feedback">{{ $message }}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="form_receivers" class="col-form-label">Form Receivers(each new line)</label>
                                                            <textarea class="form-control" name="form_receivers" id="form_receivers" cols="30" rows="4">{{old('form_receivers', isset($product) ? $product->form_receivers : '')}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="primary_category_id" class="col-form-label">Category<sup style="color: red">*</sup></label>
                                                            <select
                                                                class="form-control form-select js-example-basic-single @error('category_id')is-invalid @enderror"
                                                                id="primary_category_id" name="category_id">
                                                                @foreach($categories as $category)
                                                                    <option
                                                                        {{old('category_id', (isset($product) && $product->categories?->first()?->id == $category->id)) ? 'selected' : ''}} value="{{$category->id}}">{{$category->title}}
                                                                        ({{ $category->slug }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('category_id')
                                                            <div class="invalid-feedback">{{ $message }}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-3">
                                                        <div class="form-group">
                                                            <label for="type" class="col-form-label">Type<sup style="color: red">*</sup></label>
                                                            <select
                                                                class="form-control form-select js-example-basic-single @error('type')is-invalid @enderror"
                                                                id="type" name="type">
                                                                @foreach(Product::TYPES as $key => $type)
                                                                    <option
                                                                        {{old('type', (isset($product) && $product->type == $key)) ? 'selected' : ''}} value="{{ $key }}">{{ $type }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('type')
                                                            <div class="invalid-feedback">{{ $message }}
                                                            </div>@enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 mb-4 mt-3">
                                                        <div class="form-group">
                                                            <label for="packages[]" class="col-form-label">Packages</label>
                                                            <select id="packages[]" name="packages[]"
                                                                    class="js-example-placeholder-multiple-order-packages col-sm-12"
                                                                    multiple="multiple">
                                                                @foreach($packages as $package)
                                                                    <option value="{{$package->id}}">{{$package->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('packages')
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
                                                                <option value="">Select files</option>
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

                                                    <div class="col-md-6 mb-4 mt-3">
                                                        <div class="form-group">
                                                            <label for="special_offers[]" class="col-form-label">Special offers</label>
                                                            <select id="special_offers[]" name="special_offers[]"
                                                                    class="js-example-placeholder-multiple-order-offers col-sm-12"
                                                                    multiple="multiple">
                                                                @foreach($articles as $article)
                                                                    <option value="{{$article->id}}">{{$article->title}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('special_offers')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="deleted-images"></div>
                                    <div class="row">
                                        <div class="col-sm-12 mb-3 mt-3">
                                            <div class="card card-absolute">
                                                <div class="card-header bg-primary">
                                                    <h5 class="text-white">Images</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="preview_url" class="col-form-label">Preview</label>
                                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                                <input type="hidden" name="preview_url" class="url" id="preview_url">
                                                                <input type="file" data-file-id="{{isset($product) && $product->getFirstMedia('preview') ? $product->getFirstMedia('preview')->id : '' }}" name="preview" id="input-file-now" class="dropify" data-default-file="{{isset($product) && $product->getFirstMediaUrl('preview') ? $product->getFirstMediaUrl('preview') : '' }}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="big_preview_url" class="col-form-label">Big Header Image</label>
                                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                                <input type="hidden" name="big_preview_url" class="url" id="big_preview_url">
                                                                <input type="file" data-file-id="{{isset($product) && $product->getFirstMedia('big_preview') ? $product->getFirstMedia('big_preview')->id : '' }}" name="big_preview" id="input-big_preview" class="dropify" data-default-file="{{isset($product) && $product->getFirstMediaUrl('big_preview') ? $product->getFirstMediaUrl('big_preview') : '' }}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="small_preview_url" class="col-form-label">Small Header Image</label>
                                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                                <input type="hidden" name="small_preview_url" class="url" id="small_preview_url">
                                                                <input type="file" data-file-id="{{isset($product) && $product->getFirstMedia('small_preview') ? $product->getFirstMedia('small_preview')->id : '' }}" name="small_preview" id="input-small_preview" class="dropify" data-default-file="{{isset($product) && $product->getFirstMediaUrl('small_preview') ? $product->getFirstMediaUrl('small_preview') : '' }}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="banner_preview_url" class="col-form-label">Banner Image</label>
                                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                                <input type="hidden" name="banner_preview_url" class="url" id="banner_preview_url">
                                                                <input type="file" data-file-id="{{isset($product) && $product->getFirstMedia('banner_preview') ? $product->getFirstMedia('banner_preview')->id : '' }}" name="banner_preview" id="input-banner_preview" class="dropify" data-default-file="{{isset($product) && $product->getFirstMediaUrl('banner_preview') ? $product->getFirstMediaUrl('banner_preview') : '' }}"/>
                                                            </div>
                                                        </div>
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
                                                        <input type="checkbox" value="1"
                                                               {{old('active') === "0" ? '' : (isset($product) && !$product->active ? '' : 'checked') }} data-original-title=""
                                                               name="active" title=""><span
                                                            class="switch-state bg-primary"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button
                                        class="btn btn-primary">{{isset($product) ? 'Update' : 'Create'}}</button>
                                    <a style="color: white" href="{{route('backend.products.index')}}"
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
    <link rel="stylesheet" href="{{ asset('backend/assets/css/vendors/select2.css') }}">
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
        $('.js-example-placeholder-multiple-order-links').select2();
        $(".js-example-placeholder-multiple-order-links").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('useful_links', isset($product) ? $product->usefulLinks()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order-links").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order-links option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order-links").append(...options).trigger('change');


        $('.js-example-placeholder-multiple-order-offers').select2();
        $(".js-example-placeholder-multiple-order-offers").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('special_offers', isset($product) ? $product->articles()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order-offers").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order-offers option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order-offers").append(...options).trigger('change');


        $('.js-example-placeholder-multiple-order-packages').select2();
        $(".js-example-placeholder-multiple-order-packages").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('special_offers', isset($product) ? $product->packages()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order-packages").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order-packages option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order-packages").append(...options).trigger('change');

        $('.js-example-placeholder-multiple-order').select2();

        $(".js-example-placeholder-multiple-order").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            $(this).append($element);
            $(this).trigger("change");
        });
        var serverRenderData = Array.from({!! json_encode(old('files', isset($product) ? $product->files()->get()->pluck('id')->toArray() : [])) !!});
        $(".js-example-placeholder-multiple-order").val(serverRenderData).trigger('change');
        var options = [];
        for (var i = 0; i < serverRenderData.length; i++) {
            options.push($(".js-example-placeholder-multiple-order option[value=" + serverRenderData[i] + "]"));
        }
        $(".js-example-placeholder-multiple-order").append(...options).trigger('change');

        $('.js-example-placeholder-multiple-order-links').select2();
    </script>
@endsection
