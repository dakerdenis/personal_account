@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => isset($archive) ? 'Archive' : 'Staff',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Staff'],
             ],
          'buttons' => [
              'create' => ['title' => 'Create Member', 'route' => route('backend.staff.create')],
              ],
              ])
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row pb-3 align-items-end">
                        <div class="col-md-3">
                            <label for="title">Name</label>
                            <input type="text" id="title" name="filter[not_translate][name]" value="{{ request()->get('filter')['not_translate']['name'] ?? '' }}" class="form-control" placeholder="Search">
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
                                        <th scope="col">Roles</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->name}}</td>
                                            <td>
                                                {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                            </td>
                                            <td>
                                                {{ $user->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td >

                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.staff.edit', ['staff' => $user->id])}}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    @isset($archive)
                                                        <a class="dropdown-item txt-success"
                                                           href="{{route('backend.staff.restore', ['staff' => $user->id])}}">Restore</a>
                                                    @else
                                                        <a class="dropdown-item txt-danger" data-record-action="delete"
                                                           data-record-delete-url="{{route('backend.staff.destroy', ['staff' => $user->id])}}"
                                                           data-record-name="{{$user->name}}"
                                                           data-record-id="{{$user->id}}" data-bs-toggle="modal"
                                                           href="javascript:void(0);"
                                                           data-bs-target="#deleteModal">Deactivate</a>
                                                    @endisset
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3 pb-3">
                            {{$users->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
