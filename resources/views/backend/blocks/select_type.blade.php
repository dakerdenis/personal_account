@extends('layouts.backend')

@section('content')
    @include('backend.partials.delete_modal')
    @include('backend.partials.title_breadcrumbs',
        ['title' => 'Select Block Type',
         'breadcrumbs' => [
             ['active' => true, 'title' => 'Select Block Type'],
             ],
          'buttons' => null,
              ])
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Select Block Type</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            @foreach($types as $type => $typeName)
                                <li class="list-group-item"><a href="{{route('backend.blocks.create')}}?type={{$type}}">{{$typeName}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

@endsection
