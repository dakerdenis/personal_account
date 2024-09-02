
<div class="page-header">
    <div class="header-wrapper row m-0">
        <form class="form-inline search-full col" action="#" method="get">
            <div class="form-group w-100">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                               placeholder="Search Cuba .." name="q" title="" autofocus>
                        <div class="spinner-border Typeahead-spinner" role="status"><span
                                class="sr-only">Loading...</span></div>
                        <i class="close-search" data-feather="x"></i>
                    </div>
                    <div class="Typeahead-menu"></div>
                </div>
            </div>
        </form>
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid"
                                                                src="{{ asset('backend/assets') }}/images/logo.svg" alt=""></a>
            </div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                                           data-feather="align-center"></i></div>
        </div>
        <div class="left-header col horizontal-wrapper ps-0">
            @canany(['edit user translations', 'generate sitemap', 'edit contacts'])
            <ul class="horizontal-menu">
                <li class="level-menu outside"><a class="nav-link" href="#!"><i data-feather="settings"></i><span>Settings</span></a>
                    <ul class="header-level-menu menu-to-be-close">
                        @can('edit user translations')
                        <li><a target="_blank" href="{{route('languages.index')}}" data-original-title="" title=""> <i
                                    data-feather="git-pull-request"></i><span>Translations</span></a></li>
                        @endcan
                        @can('generate sitemap')
                        <li><a href="{{route('backend.dashboard.generate_sitemap')}}" data-original-title="" title=""> <i
                                    data-feather="airplay"></i><span>Sitemap</span></a></li>
                        @endcan
                            @can('edit contacts')
                        <li><a href="{{route('backend.contacts.edit', ['contact' => 1])}}" data-original-title="" title=""> <i
                                    data-feather="phone"></i><span>Contacts</span></a></li>
                            @endcan
                            @can('view settings')
                        <li><a href="{{route('backend.settings')}}"> <i
                                    data-feather="settings"></i><span>General</span></a></li>
                            @endcan
                            @can('access api data')
                        <li><a href="{{route('backend.api-data')}}" data-original-title="" title=""> <i
                                    data-feather="refresh-cw"></i><span>Api Data</span></a></li>
                            @endcan
                    </ul>
                </li>
            </ul>
            @endcanany
        </div>
        <div class="nav-right col-8 pull-right right-header p-0">
            <ul class="nav-menus">
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li class="maximize"><a class="text-dark" href="#!" onclick="toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>
                <li class="profile-nav onhover-dropdown p-0 me-0">
                    <div class="media profile-media">
                        <div class="media-body"><span>{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                            <p class="mb-0 font-roboto">Admin </p>
                        </div>
                    </div>
                    <form id="form-logout" method="post" action="{{route('backend.logout')}}">
                        @csrf
                    </form>
                    <ul class="profile-dropdown onhover-show-div">

                        <li><a onclick="event.preventDefault();document.getElementById('form-logout').submit();" href="#"><i data-feather="log-in"> </i><span>Log out</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>

