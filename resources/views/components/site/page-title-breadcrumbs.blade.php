<title>{{$title}} ::: {{__('site.site_name')}}</title>
<meta property="og:locale" content="{{app()->getLocale() . '_' . strtoupper(app()->getLocale())}}" />
<meta property="og:title" content="{{$title}} ::: {{__('site.site_name')}}" />
<meta property="og:type" content="{{ \Illuminate\Support\Facades\Request::route() &&\Illuminate\Support\Facades\Request::route()->getName() == 'index' ? 'website' : 'article' }}" />
<meta property="og:url" content="{{\Illuminate\Support\Facades\URL::current()}}" />
<meta property="og:image" content="{{$ogImage ?? asset('assets/images/a-qroup_default_image_01.png')}}"/>
<meta property="og:site_name" content="{{ __('site.site_name')}}" />
@if($description)
    <meta property="og:description" content="{{$description}}" />
@endif
<meta name="twitter:title" content="{{$title}} ::: {{__('site.site_name')}}">
@if($description)
    <meta name="twitter:description" content="{{$description}}">
@endif
<meta name="twitter:image" content="{{$ogImage ?? asset('assets/images/a-qroup_default_image_01.png')}}">
<meta name="twitter:card" content="summary_large_image">
@if($description)
    <meta name="description" content="{{$description}}">
@endif
@if($seo_keywords)
    <meta name="keywords" content="{{$seo_keywords}}">
@endif
