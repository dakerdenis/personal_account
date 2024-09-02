<section class="text-content activities-in-numbers-section">
    <div class="main-container">
        <h2 class="centralized">{{ $block->title }}</h2>

        <div class="numbers-grid">
            @foreach($block->repeatables as $repeatable)
                @php
                    $string = $repeatable->title;
                    $updatedString = preg_replace('/@@(.*?)@@/', '<span>$1</span>', $string);
                @endphp
                <div class="numbers-block">
                    <div class="icon">
                        <img src="{{ $repeatable->getFirstMediaUrl('preview') }}" width="85" height="85" alt="{{ strip_tags($updatedString) }}" loading="lazy">
                    </div>
                    <div class="text">{!! $updatedString !!}</div>
                </div>
                @if(!$loop->last)
                    <div class="divider"><span></span></div>
                @endif
            @endforeach
        </div>

        @if($block->extendedStats->count())
            <div class="types-of-insurance">
                @foreach($block->extendedStats as $statBlock)
                    @if($loop->first)
                        <div class="insurance-type">
                            <picture class="p-abs-inset-0">
                                <source srcset="{{ $statBlock->getFirstMediaUrl('preview', 'thumbStatistics') }}" media="(max-width: 500px)">
                                <img class="img-in-picture" src="{{ $statBlock->getFirstMediaUrl('preview', 'webp') }}" width="1600" height="588" alt="{{ $statBlock->title }}" loading="lazy">
                            </picture>
                            <h2>{{ $statBlock->title }}</h2>
                            @if($statBlock->extendedStatInfos->count())
                                <div class="about-row">
                                    <div class="about-col">
                                        @foreach($statBlock->extendedStatInfos->take(2) as $infoBlock)
                                            <div class="about">
                                                @php
                                                    $string = $infoBlock->title;
                                                    $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                                @endphp
                                                <h3>{!! $updatedString !!}</h3>
                                                @if($infoBlock->description)
                                                    <div class="content">
                                                        <ul>
                                                            @foreach(explode(PHP_EOL, $infoBlock->description) as $item)
                                                                @php
                                                                    $string = $item;
                                                                    $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                                                @endphp
                                                                <li>{!! $updatedString !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    @if($lastBlock = $statBlock->extendedStatInfos->get(2))
                                        <div class="about-col">
                                            <div class="about">
                                                @php
                                                    $string = $lastBlock->title;
                                                    $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                                @endphp
                                                <h3>{!! $updatedString !!}</h3>
                                                @if($lastBlock->description)
                                                    <div class="content">
                                                        <ul>
                                                            @foreach(explode(PHP_EOL, $lastBlock->description) as $item)
                                                                @php
                                                                    $string = $item;
                                                                    $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                                                @endphp
                                                                <li>{!! $updatedString !!}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        @else
                        <div class="insurance-type w-pair">
                            <picture class="p-abs-inset-0">
                                <source srcset="{{ $statBlock->getFirstMediaUrl('preview', 'thumbStatistics') }}" media="(max-width: 500px)">
                                <img class="img-in-picture" src="{{ $statBlock->getFirstMediaUrl('preview', 'webp') }}" width="785" height="600" alt="{{ $statBlock->title }}" loading="lazy">
                            </picture>
                            <h2>{{ $statBlock->title }}</h2>
                            @foreach($statBlock->extendedStatInfos as $infoBlock)
                                <div class="about">
                                    @php
                                        $string = $infoBlock->title;
                                        $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                    @endphp
                                    <h3>{!! $updatedString !!}</h3>
                                    @if($infoBlock->description)
                                        <div class="content">
                                            <ul>
                                                @foreach(explode(PHP_EOL, $infoBlock->description) as $item)
                                                    @php
                                                        $string = $item;
                                                        $updatedString = preg_replace('/@@(.*?)@@/', '<span class="bold">$1</span>', $string);
                                                    @endphp
                                                    <li>{!! $updatedString !!}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
