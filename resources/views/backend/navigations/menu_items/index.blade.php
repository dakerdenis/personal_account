@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Menu Items',
         'breadcrumbs' => [
             ['active' => false, 'link' => route('backend.navigations.index', ['navigation' => $navigation->machine_name]), 'title' => $navigation->name],
             ['active' => true, 'title' => 'Menu Items'],
             ],
          'buttons' => [
              'create' => ['title' => 'Create Menu Item', 'route' => route('backend.navigations.menu_items.create', ['navigation' => $navigation->machine_name])],
              'reorder' => ['title' => 'Reorder Menu Items','class' => 'info', 'route' => route('backend.navigations.menu_items.reorder', ['navigation' => $navigation->machine_name])],
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Link</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($menu_items as $menu_item)
                                        @include('backend.partials.menu_item_row', ['menu_item' => $menu_item, 'level' => 0])
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
