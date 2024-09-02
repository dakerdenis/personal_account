<div class="sidebar-wrapper" style="bottom: 0">
    <div>
        <div style="position: relative" class="logo-wrapper d-flex justify-content-center"><a style="text-align: center"
                                                                                                         href="{{ route('backend.dashboard') }}"><img
                    class="img-fluid for-light"
                    src="{{ asset('backend/assets/images/company_white.png') }}"
                    alt=""><img  class="img-fluid for-dark"
                                 src="{{ asset('backend/assets/images/company_white.png') }}" width="111"
                                 alt=""></a>
            <div style="top: 35px" class="toggle-sidebar" checked="checked"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid status_toggle middle sidebar-toggle"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg></div>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="index.html"><img class="img-fluid" width="25"
                                                                 src="{{asset('assets/style/imgs/crop.png')}}"
                                                                 alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">

                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="index.html"><img class="img-fluid"
                                                                   src="{{ asset('backend/assets') }}/images/logo/logo.png"
                                                                   alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                                                              aria-hidden="true"></i></div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="text-center">Administration Panel</h6>
                        </div>
                    </li>
                    {{ \Spatie\Menu\Laravel\Menu::main() }}
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
