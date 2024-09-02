@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Blocks',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Blocks'],
             ],
          'buttons' => [
              'create' => ['title' => 'Create Block', 'route' => (route('backend.blocks.create') . (isset($type) ? "?type=$type" : '')) ],
              ] + ['assign' => isset($type) ? ['title' => 'Assign Hotline Blocks', 'class' => 'info', 'route' => route('backend.blocks.hotline_blocks') ] : null],
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
                                        <th scope="col">Title</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($blocks as $block)
                                        <tr>
                                            <td>{{$block->title}}</td>
                                            <td>
                                                {{ \App\Models\Block::$types[$block->type] }}
                                            </td>
                                            <td >
                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.blocks.edit', ['block' => $block->id])}}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item txt-danger" data-record-action="delete"
                                                       data-record-delete-url="{{route('backend.blocks.destroy', ['block' => $block->id])}}"
                                                       data-record-name="{{$block->title}}"
                                                       data-record-id="{{$block->id}}" data-bs-toggle="modal"
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
                            {{$blocks->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
