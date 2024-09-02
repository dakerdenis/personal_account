<x-app-layout class="main-text-page main-sitemap-page">
    <div class="text-content sitemap-content">
        <div class="main-container container">
            <div class="row">
                @foreach($menu->chunk(ceil($menu->count() / 2)) as $col)
                    @php($colLoop = $loop)
                <div class="col col-{{ $loop->iteration }}">
                    <div class="col-content">
                        @foreach($col as $item)
                            @if($loop->first && $colLoop->first)
                                <div class="block">
                                    <a href="{{app()->getLocale() === 'az' ? url('/') : LaravelLocalization::getLocalizedURL(App::getLocale(), '/')}}" title="{{ __('site.home_page') }}" class="title">{{ __('site.home_page') }}</a>
                                </div>
                            @endif
                            <div class="block">
                                @if($item->slug === '#')
                                    <span class="title">{{$item->title}}</span>
                                @else
                                    <a href="{{$item->slug === '/' && app()->getLocale() === 'az' ? url('/') : LaravelLocalization::getLocalizedURL(App::getLocale(), $item->slug)}}" title="{{$item->title . ($item->seo_keywords ? ' ' . $item->seo_keywords : '')}}" class="title">{{$item->title}}</a>
                                @endif
                                    @if(count($item->children))
                                        <ul class="parent-ul">
                                            @foreach($item->children as $child)
                                                <li>
                                                    @if($child->slug === '#')
                                                        <span>{{$child->title}}</span>
                                                    @else
                                                        <a title="{{$child->title . ($child->seo_keywords ? ' ' . $child->seo_keywords : '')}}" href="{{$child->slug != '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $child->slug) : 'javascript:void();'}}">{{$child->title}}</a>
                                                    @endif
                                                    @if(count($child->children))
                                                            <ul class="child-ul">
                                                                @foreach($child->children as $superChild)
                                                                    <li>
                                                                        <a title="{{$superChild->title . ($superChild->seo_keywords ? ' ' . $superChild->seo_keywords : '')}}" href="{{$superChild->slug != '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $superChild->slug) : 'javascript:void();'}}">{{$superChild->title}}</a>
                                                                        @if(count($superChild->children))
                                                                            <ul class="child-ul">
                                                                                @foreach($superChild->children as $innerSuperChild)
                                                                                    <li>
                                                                                        <a title="{{$innerSuperChild->title . ($innerSuperChild->seo_keywords ? ' ' . $innerSuperChild->seo_keywords : '')}}" href="{{$innerSuperChild->slug != '#' ? LaravelLocalization::getLocalizedURL(App::getLocale(), $innerSuperChild->slug) : 'javascript:void();'}}">{{$innerSuperChild->title}}</a>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
