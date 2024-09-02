<x-app-layout :class="'main-text-page main-reports-page'">
    <div class="text-content">
        <div class="main-container">
            <div class="wysiwyg">
                {!! html_entity_decode($category->description) !!}
            </div>

            @foreach($years as $year)
                <section class="reports-section">
                    <div class="title-block animate-on-scroll animate__animated"  data-animation="fadeIn">
                        <h2>{{ $year->title }}</h2>
                        <div class="year">{{ $year->year }}</div>
                    </div>

                    @foreach($year->reportGroups()->where('active', 1)->orderBy('_lft')->get() as $group)
                        <div class="download-links">
                            <h3 class="animate-on-scroll animate__animated" data-animation="fadeIn">{{ $group->title }}</h3>

                            @foreach($group->files as $file)
                                <a target="_blank" title="{{ $file->title }}" href="{{ $file->link }}" class="download-link animate-on-scroll animate__animated" data-animation="zoomIn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M18.0018 3.11719C18.7665 3.11719 19.3864 3.7371 19.3864 4.5018V19.159L24.5227 14.0227C25.0635 13.482 25.9401 13.482 26.4809 14.0227C27.0216 14.5635 27.0216 15.4401 26.4809 15.9809L18.9809 23.4809C18.4401 24.0216 17.5635 24.0216 17.0227 23.4809L9.52273 15.9809C8.98201 15.4401 8.98201 14.5635 9.52273 14.0227C10.0635 13.482 10.9401 13.482 11.4809 14.0227L16.6172 19.159V4.5018C16.6172 3.7371 17.2371 3.11719 18.0018 3.11719ZM4.5018 21.1172C5.26651 21.1172 5.88642 21.7371 5.88642 22.5018V28.5018C5.88642 28.9302 6.05661 29.3411 6.35955 29.6441C6.6625 29.947 7.07338 30.1172 7.5018 30.1172H28.5018C28.9302 30.1172 29.3411 29.947 29.6441 29.6441C29.947 29.3411 30.1172 28.9302 30.1172 28.5018V22.5018C30.1172 21.7371 30.7371 21.1172 31.5018 21.1172C32.2665 21.1172 32.8864 21.7371 32.8864 22.5018V28.5018C32.8864 29.6647 32.4245 30.7799 31.6022 31.6022C30.7799 32.4245 29.6647 32.8864 28.5018 32.8864H7.5018C6.33893 32.8864 5.22369 32.4245 4.40141 31.6022C3.57914 30.7799 3.11719 29.6647 3.11719 28.5018V22.5018C3.11719 21.7371 3.7371 21.1172 4.5018 21.1172Z"
                                              fill="#BE111D" />
                                    </svg>
                                    <span>{{ $file->title }}</span>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </section>
            @endforeach
        </div>
    </div>
</x-app-layout>
