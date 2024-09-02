@extends('layouts.backend')
@section('content')

    @include('backend.partials.title_breadcrumbs', ['title' => isset($staff) ? 'Update ' . $staff->name : 'Create Staff user ', 'breadcrumbs' => [['active' => false, 'title' => 'Staff', 'link' => route('backend.staff.index')],], 'buttons' => null])
    <form
        action="{{isset($staff) ? route('backend.staff.update', ['staff' => $staff->id]) : route('backend.staff.store')}}"
        method="post" enctype='multipart/form-data'>
    @method(isset($staff) ? 'put' : 'post')
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
                                    <div class="row mb-0 ">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Name</label>
                                                <input
                                                    class="form-control @error('name')is-invalid @enderror "
                                                    type="text" name="name"
                                                    placeholder="Name"
                                                    value="{{old('name', isset($staff) ? $staff->name : '')}}"
                                                    id="name">
                                                @error('name')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">E-mail</label>
                                                <input
                                                    class="form-control @error('email')is-invalid @enderror "
                                                    type="text" name="email"
                                                    placeholder="Email"
                                                    value="{{old('email', isset($staff) ? $staff->email : '')}}"
                                                    id="email">
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Password</label>
                                                <input
                                                    class="form-control @error('password')is-invalid @enderror "
                                                    type="password" name="password"
                                                    placeholder="Password"
                                                    value=""
                                                    id="password">
                                                @error('password')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3 mt-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="categories_id" class="col-form-label">Roles</label>
                                                <select id="categories_id" name="roles[]"
                                                        class="js-example-placeholder-multiple col-sm-12"
                                                        multiple="multiple">
                                                    <option disabled value="">Select Categories</option>
                                                    @foreach($roles as $role)
                                                        <option {{(old('roles') && in_array($role->id, old('roles')) || (isset($staff) && in_array($role->id, $staff->roles()->get()->pluck('id')->toArray())) ? 'selected' : '')}} value="{{$role->id}}">{{$role->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('roles')
                                                <div class="invalid-feedback">{{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                class="btn btn-primary">{{isset($staff) ? 'Update' : 'Create'}}</button>
                            <a style="color: white" href="{{route('backend.staff.index')}}"
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
@endsection
