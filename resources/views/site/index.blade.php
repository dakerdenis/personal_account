<x-app-layout class="main-text-page main-home-page">
    @if($slides->count())
        <x-site.partials.main-page-banner :slides="$slides"/>
    @endif

        @foreach($blocks as $block)
            <x-dynamic-component :component="'site.blocks.'.Str::studly($block->block->type)" :block="$block->block" class="mt-4"/>
        @endforeach
</x-app-layout>
