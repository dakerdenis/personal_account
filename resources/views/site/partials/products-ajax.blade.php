@foreach($products as $product)
    <x-site.product-card :product="$product"/>
@endforeach
