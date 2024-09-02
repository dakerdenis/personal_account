<div class="col-lg-3">
    <div class="dashboard-sidebar">
        <div class="profile-top">
            <div class="profile-detail">
                <h5>{{ $user->full_name }}</h5>
                <h6>{{ $user->email }}</h6>
            </div>
        </div>
        <div class="faq-tab">
            <ul class="nav nav-tabs" id="top-tab" role="tablist">
                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link {{ empty($type) || $type === 'orders' ? 'active' : '' }}" href="#orders">{{ __('site.orders') }}</a>
                </li>
                <li class="nav-item"><a data-bs-toggle="tab" class="nav-link {{ $type === 'view' ? 'active' : '' }}" href="#profile">{{ __('site.profile') }}</a>
                </li>
                <li class="nav-item"><a class="nav-link" onclick="event.preventDefault();document.getElementById('form-logout').submit();" href="">{{ __('site.logout') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>
