<aside class="app-sidebar shadow custom-light-sidebar custom-scroll" data-bs-theme="light">
    <div class="sidebar-brand" style="height: 3.5rem; display: block; border: none;"></div>

    {{-- Sidebar Wrapper --}}
    <div class="sidebar-wrapper">
        <nav class="mt-3">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation"
                aria-label="Main navigation" data-accordion="false" id="navigation">

                <li class="nav-item mb-1">
                    <a href="{{ route('report.index') }}"
                        class="nav-link {{ request()->routeIs('report.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-clipboard-data"></i>
                        <p>Rekap Kuisioner</p>
                    </a>
                </li>
                
                <li class="nav-item mb-1">
                    <a href="{{ route('status.index') }}"
                        class="nav-link {{ request()->routeIs('status.index') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-clipboard-check"></i>
                        <p>Status Kuesioner</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>