@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($block) ? 'Update ' . $block->title : 'Create Block ' . \App\Models\Block::$types[$type ?? $block->type], 'breadcrumbs' => [['active' => false, 'title' => 'Blocks', 'link' => route('backend.blocks.index')],], 'buttons' => null])
    <form
        action="{{isset($block) ? route('backend.blocks.update_cards', ['block' => $block->id]) : route('backend.blocks.store_cards')}}"
        method="post" enctype='multipart/form-data'>
        @method(isset($block) ? 'put' : 'post')
        @csrf
        <input type="hidden" name="type" value="{{$type ?? $block->type}}">
        <input type="hidden" name="media_collection_name" value="preview">
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
                                                <label for="title-no-slug" class="col-form-label">Title</label>
                                                <input
                                                    class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                    type="text" name="title:{{$localeCode}}"
                                                    placeholder="Title"
                                                    value="{{old('title:'.$localeCode, (isset($block) && $block->translate($localeCode)) ? $block->translate($localeCode)->title : '')}}"
                                                    id="title-no-slug">
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
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="row">
                        <h5 class="text-center mb-4">Repeated fields</h5>
                        <div class="col-sm-12">
                            <div class="row">
                                <input type="hidden" name="data" value="">
                                <div class="col-sm-12" id="repeatables">
                                    @foreach(old('repeatable') ?? (isset($block) && $block->repeatables ? $block->repeatables()->ordered()->get() : []) as $id => $repeatable)
                                        @include('backend.partials.card_link', ['id' => $id, 'repeatable' => $repeatable, 'media_collection_name' => 'preview'])
                                    @endforeach
                                </div>
                            </div>
                            <div class="row justify-content-center mb-3">
                                <div class="col-md-2 text-center">
                                    <button class="btn btn-outline-success" type="button" title=""
                                            data-bs-original-title="btn btn-outline-success"
                                            data-type="simple"
                                            data-link="{{route('backend.blocks.add_card_link')}}"
                                            id="add_repeatable" data-original-title="btn btn-outline-success">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="card">
                            <div class="card-footer">
                                <button
                                    class="btn btn-primary">{{isset($block) ? 'Update' : 'Create'}}</button>
                                <a style="color: white" href="{{route('backend.blocks.index')}}"
                                   class="btn btn-secondary">Cancel</a>
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
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
