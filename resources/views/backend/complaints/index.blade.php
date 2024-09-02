@php
    use App\Models\Complaint;
    use App\Models\ComplaintStatus;
        /**
         * @var $complaints Complaint[]
         * @var $complaintStatuses ComplaintStatus[]
         */
@endphp
@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Complaints',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Complaints'],
             ],
          'buttons' => [
              ],
              ])
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="row pb-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label" for="validationCustom04">Status</label>
                            <select class="form-select" id="validationCustom04" name="filter[not_translate][complaint_status_id]">
                                <option value="">All</option>
                                @foreach($complaintStatuses as $complaintStatus)
                                    <option
                                        value="{{ $complaintStatus->id }}" {{ isset(request()->get('filter')['not_translate']['complaint_status_id']) && request()->get('filter')['not_translate']['complaint_status_id'] == $complaintStatus->id ? 'selected' : '' }}>
                                        {{ $complaintStatus->title }}
                                    </option>
                                @endforeach
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
                                        <th scope="col">ID</th>
                                        <th scope="col">Status/Date</th>
                                        <th scope="col">Full Name</th>
                                        <th scope="col">Peronal ID</th>
                                        <th scope="col">E-mail</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($complaints as $complaint)
                                        <tr>
                                            <td>#{{ $complaint->id }}</td>
                                            <td>{{$complaint->complaintStatus->title}}/{{ $complaint->change_status_date->format('d.m.Y') }}</td>
                                            <td>{{$complaint->first_name}} {{ $complaint->last_name }} {{ $complaint->surname }}</td>
                                            <td>{{ $complaint->personal_id }}</td>
                                            <td>{{ $complaint->email }}</td>
                                            <td>{{ $complaint->phone }}</td>
                                            <td>
                                                {{ $complaint->created_at->format('d/m/Y H:i:s') }}
                                            </td>
                                            <td>

                                                <button class="btn btn-primary dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-haspopup="true"
                                                        aria-expanded="false">Actions
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                       href="{{route('backend.complaints.edit', $complaint)}}">Edit</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12 mt-3 pb-3">
                            {{$complaints->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
