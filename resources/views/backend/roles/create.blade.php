@extends('layouts.backend')
@section('content')
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Dashboard</h3>
                    </div>
                </div>
            </div>
        </div>
        <form
            action="{{isset($role) ? route('backend.roles.update', ['role' => $role->id]) : route('backend.roles.store')}}"
            method="post" enctype='multipart/form-data'>
        @method(isset($role) ? 'put' : 'post')
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
                                                    <div class="mb-0 m-t-30">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Name</label>
                                                            <input
                                                                class="form-control @error('name')is-invalid @enderror "
                                                                type="text" name="name"
                                                                placeholder="Title"
                                                                value="{{old('name', (isset($role)) ? $role->name : '')}}"
                                                                id="name">
                                                            @error('name')
                                                            <div class="invalid-feedback">
                                                                {{$message}}
                                                            </div>@enderror
                                                        </div>
                                                    </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Permissions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                @foreach($all_permissions->chunk(5) as $permission_set)
                                                    <tr>
                                                        @foreach($permission_set as $permission)
                                                            <th><div class="checkbox checkbox-primary">
                                                                    <input name="permissions[]" id="inline-{{$permission->id}}" type="checkbox" value="{{$permission->id}}" {{in_array($permission->id, $role_permissions) ? 'checked' : ''}} data-bs-original-title="" title="">
                                                                    <label for="inline-{{$permission->id}}">{{ $permission->name }}</label>
                                                                </div></th>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button
                                            class="btn btn-primary">{{isset($role) ? 'Update' : 'Create'}}</button>
                                        <a style="color: white" href="{{route('backend.roles.index')}}"
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
