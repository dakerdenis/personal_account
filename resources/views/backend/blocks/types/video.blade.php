@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($block) ? 'Update ' . $block->title : 'Create Video', 'breadcrumbs' => [['active' => false, 'title' => 'Blocks', 'link' => route('backend.blocks.index')],], 'buttons' => null])
        <form
            action="{{isset($block) ? route('backend.blocks.update', ['block' => $block->id]) : route('backend.blocks.store')}}"
            method="post" enctype='multipart/form-data'>
            <input type="hidden" name="type" value="{{$type ?? $block->type}}">
        @method(isset($block) ? 'put' : 'post')
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
                                                                value="{{old('title:'.$localeCode, (isset($block) && $block->translate($localeCode)) ? $block->translate($localeCode)->title : '')}}"
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
                                    <div class="deleted-images"></div>
                                    <div class="card-footer">
                                        <div class="row mb-5">
                                            <div class="form-group col-md-6">
                                                <div class="mb-3">
                                                    <label for="video" class="form-label">Video file</label>
                                                    <input class="form-control" type="file" name="video" id="video">
                                                </div>
                                                @isset($block)
                                                    <p>
                                                        <a href="{{ asset(Storage::url($block->meta['video'] ?? '')) }}">{{ $block->meta['video'] ?? ''}}</a>
                                                    </p>
                                                @endisset
                                                @error('video')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
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
