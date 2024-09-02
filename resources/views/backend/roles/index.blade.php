@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Roles', 'breadcrumbs' => [['active' => true, 'title' => 'Attributes']], 'buttons' => ['create' => ['title' => 'Create Role', 'route' => route('backend.roles.create')]]])
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row pb-3 align-items-end">
                        <div class="col-md-3">
                            <label for="title">Keywords</label>
                            <input type="text" id="title" name="filter[like][name]" value="{{ request()->get('filter')['like']['name'] ?? '' }}" class="form-control" placeholder="Search">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if (Session::has('message'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                        <strong>{!! Session::get('message')['type'] !!}
                            ! </strong> {!! Session::get('message')['message'] !!}
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"
                                data-original-title="" title=""><span aria-hidden="true"></span></button>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-primary">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($roles as $role)
                                        @if($role->id === 2)
                                            @continue
                                        @endif
                                        <tr>
                                            <td>{{$role->name}}</td>
                                            <td>
                                                {{ $role->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td class="w-25">

                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.roles.edit', ['role' => $role->id])}}">Edit & Permissions</a>
{{--                                                        <div class="dropdown-divider"></div>--}}
{{--                                                        <a class="dropdown-item txt-danger" data-record-action="delete"--}}
{{--                                                           data-record-delete-url="{{route('backend.roles.destroy', ['role' => $role->id])}}"--}}
{{--                                                           data-record-name="{{$role->name}}"--}}
{{--                                                           data-record-id="{{$role->id}}" data-bs-toggle="modal"--}}
{{--                                                           href="javascript:void(0);"--}}
{{--                                                           data-bs-target="#deleteModal">Delete</a>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3 pb-3">
                            {{$roles->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
