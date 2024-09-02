@php
    /** @var \App\Models\Product[] $products */
@endphp
<x-app-layout>
    <section class="section-b-space ratio_asos">
        <div class="collection-wrapper">
            <div class="container">
                <div class="row">
                    <div class="collection-content col">
                        <div class="page-main-content">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="collection-product-wrapper">
                                        <div class="product-top-filter">
                                            <div class="container-fluid p-0">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <form action="">
                                                            <div class="product-filter-content">
                                                                <div class="search-count" id="results-line">
                                                                    @include('site.partials.results-line', compact('products'))
                                                                </div>
                                                                <div class="product-page-per-view">
                                                                    <select class="force-submit" name="per_page">
                                                                        @foreach(\App\Models\Product::PER_PAGE as $perPage)
                                                                            <option {{ $filters->getPerPage() === $perPage ? 'selected' : '' }} value="{{ $perPage }}"> {{ __('site.per_page', compact('perPage')) }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="product-page-filter">
                                                                    <select class="force-submit" name="order_by" >
                                                                        @foreach(\App\Models\Product::ORDER_BY as $key => $orderBy)
                                                                            <option {{ $filters->getOrderBy() === $key ? 'selected' : '' }} value="{{ $key }}">{{ __('site.sort.' . $key) }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-wrapper-grid">
                                            <div class="row margin-res">
                                                @foreach($products as $product)
                                                    <x-site.product-card :can-disappear="true" :product="$product" :class="'col-xl-3 col-6 col-grid-box'"/>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
