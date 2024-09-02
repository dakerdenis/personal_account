@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Faqs',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Faqs'],
             ],
          'buttons' => [
              'create' => ['title' => 'Create Faq', 'route' => route('backend.faq_entities.create')],
              'reorder' => ['title' => 'Reorder Faqs', 'class' => 'info', 'route' => route('backend.faq_entities.reorder')],
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
                        <div class="col-md-3">
                            <label class="form-label" for="validationCustom04">Status</label>
                            <select class="form-select" id="validationCustom04" name="filter[not_translate][active]">
                                <option value="">All</option>
                                <option value="1" {{ isset(request()->get('filter')['not_translate']['active']) && request()->get('filter')['not_translate']['active'] == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{isset(request()->get('filter')['not_translate']['active']) && request()->get('filter')['not_translate']['active'] == 0 ? 'selected' : ''}} >Inactive</option>
                            </select>
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
                                        <th scope="col">Question</th>
                                        <th scope="col">Active</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td>{{$faq->title}}</td>
                                            <td><input name="active" class="activation"
                                                       data-record-id="{{$faq->id}}"
                                                       data-record-url="{{route('backend.faq_entities.toggle_activate', $faq)}}"
                                                       type="checkbox" {{ $faq->active ? 'checked' : '' }}></td>
                                            <td>
                                                {{ $faq->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td >

                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.faq_entities.edit', $faq)}}">Edit</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item txt-danger" data-record-action="delete"
                                                       data-record-delete-url="{{route('backend.faq_entities.destroy', $faq)}}"
                                                       data-record-name="{{$faq->title}}"
                                                       data-record-id="{{$faq->id}}" data-bs-toggle="modal"
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
                            {{$faqs->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
