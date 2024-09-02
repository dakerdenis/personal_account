@php use App\Models\Product; @endphp
<x-app-layout class="main-text-page main-products-page">

    @if($category->children->count())
        @php
            $categories = $category->children()->where('active', 1)->orderBy('_lft')->get();
        @endphp
        @foreach($categories as $innerCategory)
            @include('site.partials.products-line', ['inner' => true, 'first' => $loop->first, 'category' => $innerCategory, 'products' => $innerCategory->products()->where('active', 1)->where('type', Product::TYPE_PRODUCT)->orderBy('_lft')->get()])
        @endforeach
    @else
        @include('site.partials.products-line', ['first' => true, 'inner' => false,  'category' => $category, 'products' => $category->products()->where('active', 1)->where('type', Product::TYPE_PRODUCT)->orderBy('_lft')->get()])
    @endif

</x-app-layout>
