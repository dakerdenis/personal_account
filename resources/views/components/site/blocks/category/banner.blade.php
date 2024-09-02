<div class="collection-sidebar-banner">
    <a href="{{ $block->data['link'] ?? 'javascript:void(0);' }}"><img src="{{ $block->getFirstMediaUrl('preview_'. App::getLocale()) }}" class="img-fluid blur-up lazyload"
                     alt="{{ $block->title }}"></a>
</div>
