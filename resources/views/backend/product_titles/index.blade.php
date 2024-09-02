@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Product Titles',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Product Titles'],
             ],
          'buttons' => [
              'create' => ['title' => 'Product Titles', 'route' => route('backend.product_titles.create')],
              ],
              ])
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row pb-3 align-items-end">
                        <div class="col-md-3">
                            <label for="title">Keywords</label>
                            <input type="text" id="title" name="filter[translate][title]" value="{{ request()->get('filter')['translate']['title'] ?? '' }}" class="form-control" placeholder="Search">
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
                                        <th scope="col" class="w-25">Title</th>
                                        <th scope="col" class="w-25">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($titles as $title)
                                       <tr>
                                           <td>{{$title->title}}</td>
                                           <td >

                                               <button class="btn btn-primary dropdown-toggle" type="button"
                                                       data-bs-toggle="dropdown"
                                                       aria-haspopup="true"
                                                       aria-expanded="false">Actions
                                               </button>
                                               <div class="dropdown-menu">
                                                   <a class="dropdown-item"
                                                      href="{{route('backend.product_titles.edit', ['product_title' => $title->id])}}">Edit</a>
                                                   <div class="dropdown-divider"></div>
                                                   <a class="dropdown-item txt-danger" data-record-action="delete"
                                                      data-record-delete-url="{{route('backend.product_titles.destroy', ['product_title' => $title->id])}}"
                                                      data-record-name="{{$title->title}}"
                                                      data-record-id="{{$title->id}}" data-bs-toggle="modal"
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
                            {{$titles->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
