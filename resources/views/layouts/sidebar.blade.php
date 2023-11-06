<div class="leftside-menu">

    <!-- Brand Logo Light -->
    @if (Auth::user()->isAdmin())
        <a href="{{ route('admin.home') }}" class="logo logo-light">
        @elseif (Auth::user()->isSales())
            <a href="{{ route('admin.sales') }}" class="logo logo-light">
    @endif
    <span class="logo-lg">
        <img src="{{ asset('assets/images/logo.png') }}" alt="logo">
    </span>
    <span class="logo-sm">
        <img src="{{ asset('assets/images/logo-sm.png') }}" alt="small logo">
    </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index-2.html" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ asset('assets/images/logo-dark.png') }} " alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="{{ asset('assets/images/logo-dark-sm.png') }}" alt="small logo">
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" height="42"
                    class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">
            <li class="side-nav-title">Navigation</li>
            @foreach ($menu as $item)
                @php
                    $isActive = false;
                    $isCollapsible = false;
                    foreach ($roleuser as $roleMenu) {
                        if ($roleMenu->Menu_id == $item->Menu_id) {
                            $isCollapsible = true;
                            $isActive = true;
                            break;
                        }
                    }
                @endphp

                @if ($isCollapsible)
                    <li class="side-nav-item">
                        @if (count($item->menu) > 0)
                            <a data-bs-toggle="collapse" href="#sidebar{{ $item->Menu_id }}" aria-expanded="false"
                                aria-controls="sidebar{{ $item->Menu_id }}" class="side-nav-link">
                                <i class="uil-navigator"></i>
                                <span> {{ $item->Menu_name }} </span>
                            </a>
                            <div class="collapse" id="sidebar{{ $item->Menu_id }}">
                                <ul class="side-nav-second-level">
                                    @foreach ($item->menu as $sub)
                                        <li>
                                            <a class="nav-link"
                                                href="{{ url('admin/' . $sub->Menu_link) }}">{{ $sub->Menu_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a class="side-nav-link" href="{{ url('admin/' . $item->Menu_link) }}">
                                <i class="uil-navigator"></i>
                                <span> {{ $item->Menu_name }} </span>
                            </a>
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
        </ul><!--- End Sidemenu -->
    </div>
</div>
