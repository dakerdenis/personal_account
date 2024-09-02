@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Customers',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Customers'],
             ],
          'buttons' => [
              'create' => ['title' => 'Create User', 'route' => route('backend.users.create')],
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
                            <input type="text" id="title" name="filter[like][name]" value="{{ request()->get('filter')['like']['name'] ?? '' }}" class="form-control" placeholder="Search">
                        </div>
                        <div class="col-md-3">
                            <label for="title">E-mail</label>
                            <input type="text" id="title" name="filter[like][email]" value="{{ request()->get('filter')['like']['email'] ?? '' }}" class="form-control" placeholder="Search">
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
                                        <th scope="col">Picture</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Registered at</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                       <tr>
                                           <td><img src="{{$user->getFirstMediaUrl('preview')}}" height="75"></td>
                                           <td>{{ $user->name }}</td>
                                           <td>{{ $user->email }} <br>
                                                  <small style="color: {{ $user->email_verified_at ? 'green' : 'red' }}">{{ $user->email_verified_at ? 'Verified' : 'Not verified' }}</small>
                                           </td>
                                           <td>{{ $user->phone }}</td>
                                           <td>{{ $user->created_at }}</td>
                                           <td>
                                               <button class="btn btn-primary dropdown-toggle" type="button"
                                                       data-bs-toggle="dropdown"
                                                       aria-haspopup="true"
                                                       aria-expanded="false">Actions
                                               </button>
                                               <div class="dropdown-menu">
                                                   <a class="dropdown-item"
                                                      href="{{route('backend.users.edit', ['user' => $user->id])}}">Edit</a>
                                                   <div class="dropdown-divider"></div>
                                                   <a class="dropdown-item txt-danger" data-record-action="delete"
                                                      data-record-delete-url="{{route('backend.users.destroy', ['user' => $user->id])}}"
                                                      data-record-name="{{$user->title}}"
                                                      data-record-id="{{$user->id}}" data-bs-toggle="modal"
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
