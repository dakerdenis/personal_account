@if($breadcrumbs)
    @php($loop_iteration = 2)
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [
          {
            "@type": "ListItem",
            "position": 1,
            "name": "{{__('site.homepage')}}",
        "item": "{{ customIndexUrl() }}"
      },
        @foreach($breadcrumbs as $breadcrumb)
            @if($breadcrumb['link'] !== 'javascript:void();')
                {
                  "@type": "ListItem",
                  "position": {{$loop_iteration}},
              "name": "{{$breadcrumb['title']}}",
              "item": "{{$breadcrumb['link']}}"
            }{{ !$loop->last ? ',' : '' }}
                @php($loop_iteration++)
            @endif
        @endforeach
        ]
      }
    </script>

    @if($image)
        <section class="header">
            <div class="main-container animate-on-scroll animate__animated" data-animation="fadeIn">
                <div class="breadcrumbs">
                    <span><a title="{{__('site.homepage')}}" href="{{ customIndexUrl() }}">{{__('site.homepage')}}</a></span>
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            {{--                                    <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb['title']}}</li>--}}
                        @else
                            <span>
                                @if($breadcrumb['link'] === 'javascript:void();')
                                    {{$breadcrumb['title']}}
                                @else
                                    <a href="{{$breadcrumb['link']}}">{{$breadcrumb['title']}}</a>
                                @endif
                            </span>
                        @endif
                    @endforeach
                </div>

                <h1>{{ $page_title }}</h1>
                @if($subTitle)
                    <p>{{ $subTitle }}</p>
                @endif
            </div>
            <picture class="p-abs-inset-0">
                <source srcset="{{ $image->getUrl('thumb') }}" media="(max-width: 500px)">
                <img class="img-in-picture" src="{{ $image->getUrl('webp') }}" width="1920" height="785" alt="{{ $page_title }}">
            </picture>
        </section>
    @else
        <section class="header animate__animated animate__fadeIn">
            <div class="main-container">
                <div class="breadcrumbs">
                    <span><a title="{{__('site.homepage')}}" href="{{ customIndexUrl() }}">{{__('site.homepage')}}</a></span>
                    @foreach($breadcrumbs as $breadcrumb)
                        @if($loop->last)
                            {{--                                    <li class="breadcrumb-item active" aria-current="page">{{$breadcrumb['title']}}</li>--}}
                        @else
                            <span>
                                @if($breadcrumb['link'] === 'javascript:void();')
                                    {{$breadcrumb['title']}}
                                @else
                                    <a href="{{$breadcrumb['link']}}">{{$breadcrumb['title']}}</a>
                                @endif
                            </span>
                        @endif
                    @endforeach
                </div>
                <h1>{{ $page_title }}</h1>

                @if(\Illuminate\Support\Facades\Route::is('search') || \Illuminate\Support\Facades\Route::is('search-other'))
                    <p class="description">{!! __('site.found_for', ['query' => htmlspecialchars(request()->get('query'))]) !!}</p>
                @endif
                @if(isset($date) && $date)
                    <p class="date">
                        <svg xmlns="http://www.w3.org/2000/svg" width="26" height="27" viewBox="0 0 26 27" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M8.66667 4.83073H17.3333V2.66406H19.5V4.83073H20.5833C21.158 4.83073 21.7091 5.059 22.1154 5.46533C22.5217 5.87166 22.75 6.42276 22.75 6.9974V22.1641C22.75 22.7387 22.5217 23.2898 22.1154 23.6961C21.7091 24.1025 21.158 24.3307 20.5833 24.3307H5.41667C4.84203 24.3307 4.29093 24.1025 3.8846 23.6961C3.47827 23.2898 3.25 22.7387 3.25 22.1641V6.9974C3.25 6.42276 3.47827 5.87166 3.8846 5.46533C4.29093 5.059 4.84203 4.83073 5.41667 4.83073H6.5V2.66406H8.66667V4.83073ZM5.41667 9.16406V22.1641H20.5833V9.16406H5.41667ZM7.58333 12.4141H9.75V14.5807H7.58333V12.4141ZM11.9167 12.4141H14.0833V14.5807H11.9167V12.4141ZM16.25 12.4141H18.4167V14.5807H16.25V12.4141ZM16.25 16.7474H18.4167V18.9141H16.25V16.7474ZM11.9167 16.7474H14.0833V18.9141H11.9167V16.7474ZM7.58333 16.7474H9.75V18.9141H7.58333V16.7474Z"
                                  fill="#BE111D"></path>
                        </svg>
                        <span>{{ $date }} @if(isset($end_date) && $end_date)
                                - {{ $end_date }}
                            @endif</span>
                    </p>
                @endif
                @isset($subTitle)
                    @if($subTitle)
                        <p class="description">{{ $subTitle }}</p>
                    @endif
                @endisset
            </div>
        </section>
    @endif
@endif
