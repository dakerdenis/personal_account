@extends('layouts.backend')

@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Sitemap', 'breadcrumbs' => []])
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
                    @if($fileData)
                    <div class="card-header">
                        <h5>{{$fileData->name}}</h5><span>Last regenerated: {{$fileData->created_at}}</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <form action="" method="post">
                            @csrf
                            <button class="btn btn-success" type="submit" data-bs-toggle="tooltip" title="" data-bs-original-title="btn btn-success" data-original-title="btn btn-success">Regenerate</button>
                            @if($fileData)
                                <a target="_blank" href="/sitemap.xml" class="btn btn-info" >View</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
