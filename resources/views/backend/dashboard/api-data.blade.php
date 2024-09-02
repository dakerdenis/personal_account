@extends('layouts.backend')

@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Api Data', 'breadcrumbs' => []])
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if (\Session::has('message'))
                    <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                        <strong>{!! \Session::get('message')['type'] !!}
                            ! </strong> {!! \Session::get('message')['message'] !!}
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Casco data</h1>
                        <div class="row">
                            <form action="{{ route('backend.api-data-casco') }}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit" data-bs-toggle="tooltip" title="" data-bs-original-title="btn btn-success" data-original-title="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Brands
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['brands'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Production Years
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['years'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Repair Shops
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{!! json_encode($data['shops'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Franchises
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['franchises'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Drivers
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['drivers'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Installments
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['installments'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        Bonuses
                                    </div>
                                    <div class="card-body" style="height: 450px; overflow-y: scroll">
                                        <pre>{{ json_encode($data['bonuses'] ?? [], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Doctors data</h1>
                        <div class="row">
                            <form action="{{ route('backend.api-data-doctors') }}" method="post">
                                @csrf
                                <button class="btn btn-success" type="submit" data-bs-toggle="tooltip" title="" data-bs-original-title="btn btn-success" data-original-title="btn btn-success">Update</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mt-4">
                            @foreach($doctorsSpecialities['specialities'] ?? [] as $speciality)
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            {{ $speciality['name'] }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
