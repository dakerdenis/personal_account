@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($user) ? 'Update customer' : 'Create customer', 'breadcrumbs' => [
    ['active' => false, 'title' => 'Customers', 'link' => route('backend.users.index')],
    ], 'buttons' => null])
    <form
        action="{{isset($user) ? route('backend.users.update', ['user' => $user->id]) : route('backend.users.store')}}"
        method="post" enctype='multipart/form-data'>
        @method(isset($user) ? 'put' : 'post')
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
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Name</label>
                                                <input
                                                    class="form-control @error('name')is-invalid @enderror "
                                                    type="text" name="name"
                                                    placeholder="Title"
                                                    value="{{old('name', isset($user) ? $user->name : '')}}"
                                                    id="name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">e-mail</label>
                                                <input
                                                    class="form-control @error('email')is-invalid @enderror "
                                                    type="text" name="email"
                                                    value="{{old('email', isset($user) ? $user->email : '')}}"
                                                    id="email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="phone" class="col-form-label">Phone</label>
                                                <input
                                                    class="form-control @error('phone')is-invalid @enderror "
                                                    type="number" name="phone"
                                                    value="{{old('phone', isset($user) ? $user->phone : '')}}"
                                                    id="phone">
                                                @error('phone')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input
                                                    class="form-control @error('password')is-invalid @enderror "
                                                    type="password" name="password"
                                                    id="password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="slug" class="col-form-label">Picture</label>
                                                <input type="hidden" name="delete_images[]" id="deleteImages">
                                                <input type="hidden" class="url" name="preview_url" id="preview_url">
                                                <input type="file"
                                                       data-file-id="{{isset($user) && $user->getFirstMedia('preview') ? $user->getFirstMedia('preview')->id : '' }}"
                                                       name="preview" id="input-file-now" class="dropify"
                                                       data-default-file="{{isset($user) && $user->getFirstMediaUrl('preview') ? $user->getFirstMediaUrl('preview') : '' }}"/>
                                                @error('preview')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button
                                        class="btn btn-primary">{{isset($user) ? 'Update' : 'Create'}}</button>
                                    <a style="color: white" href="{{route('backend.users.index')}}"
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
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
    <script src="{{ asset('backend/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
@endsection
