@if($products->total())
    <h5>{{ __('site.showing_result_of_total', ['from' =>  (((request()->get('page') ?? 1) - 1) * 24) + 1 , 'to' => ((request()->get('page') ?? 1) * 24) < $products->total() ? (request()->get('page') ?? 1) * 24 : $products->total(), 'total' => $products->total()]) }}</h5>
@else
    <h5>{{ __('site.zero_results') }}</h5>
@endif
