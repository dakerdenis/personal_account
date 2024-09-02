@extends('layouts.backend')

@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Dashboard', 'breadcrumbs' => []])
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-6 xl-50 notification box-col-6">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5 class="m-0">Latest Content logs</h5>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @foreach($contentLogs as $log)
                            @include('backend.partials.log', ['log' => $log])
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-6 xl-50 notification box-col-6">
                <div class="card">
                    <div class="card-header card-no-border">
                        <div class="header-top">
                            <h5 class="m-0">Latest Auth logs</h5>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        @foreach($authLogs as $log)
                            @include('backend.partials.log', ['log' => $log])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
