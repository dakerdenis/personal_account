@extends('layouts.backend')
@section('content')
    @include('backend.partials.title_breadcrumbs', ['title' => 'Edit Contacts', 'breadcrumbs' => [], 'buttons' => null])
        <form
            class="content-form"
            action="{{route('backend.contacts.update', ['contact' => $contact->id])}}"
            method="post" enctype='multipart/form-data'>
        @method('put')
        @csrf
        <!-- Container-fluid starts-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                                                <li class="nav-item">
                                                    <a class="nav-link {{$loop->first ? 'active' : ''}}"
                                                       id="{{ $localeCode }}-tab" data-bs-toggle="tab"
                                                       href="#{{ $localeCode }}" role="tab"
                                                       aria-controls="{{ $localeCode }}"
                                                       aria-selected="true">{{ mb_convert_case($properties['native'], MB_CASE_TITLE, "UTF-8") }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            @foreach(\App\Services\LocalizationService::getLocalesOrder() as $localeCode => $properties)
                                                <div class="tab-pane fade {{$loop->first ? 'active show' : ''}}"
                                                     id="{{$localeCode}}" role="tabpanel"
                                                     aria-labelledby="{{$localeCode}}-tab">
                                                    <div class="mb-0 m-t-30">
                                                        <div class="row">
                                                            <div class="form-group col-md-6">
                                                                <label for="title" class="col-form-label">Title</label>
                                                                <input
                                                                    class="form-control @error('title:'.$localeCode)is-invalid @enderror "
                                                                    type="text" name="title:{{$localeCode}}"
                                                                    value="{{old('title:'.$localeCode, (isset($contact) && $contact->translate($localeCode)) ? $contact->translate($localeCode)->title : '')}}"
                                                                    id="title">
                                                                @error('title:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="sub_title" class="col-form-label">SubTitle</label>
                                                                <input
                                                                    class="form-control @error('sub_title:'.$localeCode)is-invalid @enderror "
                                                                    type="text" name="sub_title:{{$localeCode}}"
                                                                    value="{{old('sub_title:'.$localeCode, (isset($contact) && $contact->translate($localeCode)) ? $contact->translate($localeCode)->sub_title : '')}}"
                                                                    id="sub_title">
                                                                @error('sub_title:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="form-group">
                                                                <label for="description:{{$localeCode}}" class="col-form-label">Description</label>
                                                                <textarea id="description:{{$localeCode}}" class="@error('description:'.$localeCode)is-invalid @enderror editor-cke" name="description:{{$localeCode}}" cols="30" rows="10">
                                                                {{old('description:'.$localeCode, (isset($contact) && $contact->translate($localeCode)) ? $contact->translate($localeCode)->description : '')}}
                                                            </textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="form-group col-md-6">
                                                                <label for="address:{{$localeCode}}"
                                                                       class="col-form-label">Address</label>
                                                                <textarea id="address:{{$localeCode}}"
                                                                          class="@error('address:'.$localeCode)is-invalid @enderror form-control"
                                                                          name="address:{{$localeCode}}" cols="30"
                                                                          rows="3">{{old('address:'.$localeCode, (isset($contact) && $contact->translate($localeCode)) ? $contact->translate($localeCode)->address : '')}}</textarea>
                                                                @error('address:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="working_hours:{{$localeCode}}"
                                                                       class="col-form-label">Working Hours</label>
                                                                <textarea id="working_hours:{{$localeCode}}"
                                                                          class="@error('working_hours:'.$localeCode)is-invalid @enderror form-control"
                                                                          name="working_hours:{{$localeCode}}" cols="30"
                                                                          rows="3">{{old('working_hours:'.$localeCode, (isset($contact) && $contact->translate($localeCode)) ? $contact->translate($localeCode)->working_hours : '')}}</textarea>
                                                                @error('working_hours:'.$localeCode)
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row mb-3">
                                            <div class="form-group col-md-6">
                                                <label for="latitude" class="col-form-label">Latitude</label>
                                                <input class="form-control @error('latitude')is-invalid @enderror"
                                                       value="{{old('latitude', isset($contact) ? $contact->latitude : '')}}"
                                                       type="text" name="latitude" id="latitude">
                                                @error('latitude')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="longitude" class="col-form-label">Longitude</label>
                                                <input class="form-control @error('longitude')is-invalid @enderror"
                                                       value="{{old('longitude', isset($contact) ? $contact->longitude : '')}}"
                                                       type="text" name="longitude" id="longitude">
                                                @error('longitude')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>@enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for='short_number' class="col-form-label">Short Number</label>
                                                    <input class="form-control @error('short_number')is-invalid @enderror"
                                                           value="{{old('short_number', isset($contact) ? ($contact->short_number ?? null) : '')}}"
                                                           type="text" name="short_number" placeholder="" id='short_number'>
                                                    @error('short_number')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phones" class="col-form-label">Phones</label>
                                                    <textarea class="form-control" name="phones" id="phones" cols="30" rows="4">{{old('phones', isset($contact) ? $contact->phones : '')}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="col-form-label">E-mails</label>
                                                    <textarea class="form-control" name="email" id="email" cols="30" rows="4">{{old('email', isset($contact) ? $contact->email : '')}}</textarea>
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{$message}}
                                                    </div>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="card card-absolute">
                                                    <div class="card-header bg-primary">
                                                        <h5 class="text-white">Socials</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for='social_networks.facebook' class="col-form-label">FaceBook</label>
                                                                    <input class="form-control @error('social_networks.facebook')is-invalid @enderror"
                                                                           value="{{old('social_networks.facebook', isset($contact) ? ($contact->social_networks?->facebook ?? null) : '')}}"
                                                                           type="text" name="social_networks[facebook]" placeholder="" id='social_networks.facebook'>
                                                                    @error('social_networks.facebook')
                                                                    <div class="invalid-feedback">
                                                                        {{$message}}
                                                                    </div>@enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for='social_networks.youtube' class="col-form-label">YouTube</label>
                                                                    <input class="form-control @error('social_networks.youtube')is-invalid @enderror"
                                                                           value="{{old('social_networks.youtube', isset($contact) ? ($contact->social_networks?->youtube ?? null) : '')}}"
                                                                           type="text" name="social_networks[youtube]" placeholder="" id='social_networks.youtube'>
                                                                    @error('social_networks.youtube')
                                                                    <div class="invalid-feedback">
                                                                        {{$message}}
                                                                    </div>@enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for='social_networks.instagram' class="col-form-label">Instagram</label>
                                                                    <input class="form-control @error('social_networks.instagram')is-invalid @enderror"
                                                                           value="{{old('social_networks.instagram', isset($contact) ? ($contact->social_networks?->instagram ?? null) : '')}}"
                                                                           type="text" name="social_networks[instagram]" placeholder="" id='social_networks.instagram'>
                                                                    @error('social_networks.instagram')
                                                                    <div class="invalid-feedback">
                                                                        {{$message}}
                                                                    </div>@enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for='social_networks.skype' class="col-form-label">Skype</label>
                                                                    <input class="form-control @error('social_networks.skype')is-invalid @enderror"
                                                                           value="{{old('social_networks.skype', isset($contact) ? ($contact->social_networks?->skype ?? null) : '')}}"
                                                                           type="text" name="social_networks[skype]" placeholder="" id='social_networks.skype'>
                                                                    @error('social_networks.skype')
                                                                    <div class="invalid-feedback">
                                                                        {{$message}}
                                                                    </div>@enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for='social_networks.twitter' class="col-form-label">X(twitter)</label>
                                                                    <input class="form-control @error('social_networks.twitter')is-invalid @enderror"
                                                                           value="{{old('social_networks.twitter', isset($contact) ? ($contact->social_networks?->twitter ?? null) : '')}}"
                                                                           type="text" name="social_networks[twitter]" placeholder="" id='social_networks.twitter'>
                                                                    @error('social_networks.twitter')
                                                                    <div class="invalid-feedback">
                                                                        {{$message}}
                                                                    </div>@enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="card card-absolute">
                                                    <div class="card-header bg-primary">
                                                        <h5 class="text-white">App Links</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row mb-3">
                                                            <div class="form-group col-md-6">
                                                                <label for="google_play_link" class="col-form-label">Google PlayMarket link</label>
                                                                <input
                                                                    class="form-control @error('google_play_link')is-invalid @enderror "
                                                                    type="text" name="google_play_link"
                                                                    value="{{old('google_play_link', isset($contact) && $contact->google_play_link ? $contact->google_play_link : '')}}"
                                                                    id="google_play_link">
                                                                @error('google_play_link')
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                            <div class="form-group col-md-6">
                                                                <label for="app_store_link" class="col-form-label">Ios App Store link</label>
                                                                <input
                                                                    class="form-control @error('app_store_link')is-invalid @enderror "
                                                                    type="text" name="app_store_link"
                                                                    value="{{old('app_store_link', (isset($contact) && $contact->app_store_link) ? $contact->app_store_link : '')}}"
                                                                    id="app_store_link">
                                                                @error('app_store_link')
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>@enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            class="btn btn-primary">Update</button>
                                        <a style="color: white" href="{{route('backend.dashboard')}}"
                                           class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container-fluid Ends-->
        </form>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('backend/assets/css/dropify.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/dragula.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/select2.css')}}">
@endsection
@section('scripts')
    <script src="{{asset('backend/assets/js/slugify.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.js')}}"></script>
    <script src="{{asset('backend/assets/js/datepicker/date-picker/datepicker.en.js')}}"></script>
    <script src="{{ asset('backend/assets') }}/js/dragula.min.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/ckeditor.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="{{ asset('backend/assets') }}/js/editor/ckeditor/styles.js"></script>
    <script src="{{ asset('backend/assets') }}/js/dropify.min.js"></script>
    <script src="{{ asset('backend/assets/js/select2/select2.full.min.js') }}"></script>
@endsection
