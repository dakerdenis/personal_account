@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Navigations',
         'breadcrumbs' => [['active' => true, 'title' => 'Navigations']],
          'buttons' => [
              'create' => ['title' => 'Create Navigation', 'route' => route('backend.navigations.create')],
              ],
              ])
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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block row">
                        <div class="col-sm-12 col-lg-12 col-xl-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="table-primary">
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Machine Name</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($navigations as $navigation)
                                        <tr>
                                            <td>{{$navigation->name}}</td>
                                            <td>{{$navigation->machine_name}}</td>
                                            <td>
                                                {{ $navigation->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td class="w-25">

                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.navigations.edit', ['navigation' => $navigation->id])}}">Edit</a>
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.navigations.menu_items.index', ['navigation' => $navigation->machine_name])}}">List Items</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item txt-danger" data-record-action="delete"
                                                       data-record-delete-url="{{route('backend.navigations.destroy', ['navigation' => $navigation->id])}}"
                                                       data-record-name="{{$navigation->name}}"
                                                       data-record-id="{{$navigation->id}}" data-bs-toggle="modal"
                                                       href="javascript:void(0);"
                                                       data-bs-target="#deleteModal">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
