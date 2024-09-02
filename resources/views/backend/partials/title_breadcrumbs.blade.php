<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-lg-6 flex-column justify-content-start">
                <h3>{{$title}}</h3>
                @if(isset($breadcrumbs) && $breadcrumbs)
                    <ol class="breadcrumb justify-content-start mt-2">
                        <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}" data-bs-original-title="" title="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </a>
                        </li>
                        @foreach($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{$breadcrumb['active'] ? 'active' : '' }}">
                                @if($breadcrumb['active'])
                                    {{$breadcrumb['title']}}
                                @else
                                    <a href="{{ $breadcrumb['link'] }}">{{$breadcrumb['title']}}</a>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
            @if(isset($buttons) && $buttons)
                <div class="col-lg-6 d-flex justify-content-end">
                    @foreach($buttons as $button)
                        @if($button)
                            <a href="{{$button['route']}}" class="text-white btn btn-{{$button['class'] ?? 'success'}} m-l-20">{{$button['title']}}</a>
                        @endif
                    @endforeach
                </div>
            @endif
            @if(isset($form_buttons) && $form_buttons)
                <div class="col-lg-6 d-flex justify-content-end">
                    @foreach($form_buttons as $button)
                        <form action="{{$button['route']}}" method="post">
                            @csrf
                            @method($button['method'])
                            <button class="text-white btn btn-{{$button['class'] ?? 'success'}} mr-3">{{$button['title']}}</button>
                        </form>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
