@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($gallery) ? 'Update ' . $gallery->title : 'Create Gallery', 'breadcrumbs' => [['active' => false, 'title' => 'Galleries', 'link' => route('backend.galleries.index')],], 'buttons' => null])
        <form
            action="{{isset($gallery) ? route('backend.galleries.update', ['gallery' => $gallery->id]) : route('backend.galleries.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($gallery) ? 'put' : 'post')
        @csrf
        <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('message'))
                            <div class="alert alert-{!! strtolower(Session::get('message')['type']) !!} dark alert-dismissible fade show" role="alert">
                                <strong>{!! Session::get('message')['type'] !!}
                                    ! </strong> {!! Session::get('message')['message'] !!}
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                        data-original-title="" title=""><span aria-hidden="true"></span></button>
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
                                                <div>
                                                    <div class="mb-0 ">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Title</label>
                                                            <input
                                                                class="form-control @error('title')is-invalid @enderror "
                                                                type="text" name="title"
                                                                placeholder="Title"
                                                                value="{{old('title', isset($gallery) ? $gallery->title : '')}}"
                                                                id="title">
                                                            @error('title')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                                @isset($gallery)
                                <h5>Images</h5>
                                <div class="delete_images">
                                </div>
                                <div id="images">
                                        @foreach($gallery->getMedia() as $image)
                                            @include('backend.partials.gallery_image', ['image' => $image])
                                        @endforeach
                                </div>
                                <div class="row justify-content-center mb-3">
                                    <div class="col-md-2 text-center">
                                        <label for="add_images" class="col-form-label">Add images</label>
                                        <input id="add_images" name="images" type="file" multiple form="addImages">
                                    </div>
                                </div>
                                @endisset
                                <div class="card-footer">
                                    <button
                                        class="btn btn-primary">{{isset($gallery) ? 'Update' : 'Create'}}</button>
                                    <a style="color: white" href="{{route('backend.galleries.index')}}"
                                       class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </form>
    @isset($gallery)
    <form method="post" id="addImages" data-link="{{route('backend.galleries.add_images', ['gallery' => $gallery->id])}}" action="{{route('backend.galleries.add_images', ['gallery' => $gallery->id])}}"  enctype='multipart/form-data'>
        @csrf
    </form>
    @endisset
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('backend/assets/css/dragula.min.css')}}">
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
@endsection
