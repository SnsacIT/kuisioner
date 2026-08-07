<nav class="app-header navbar navbar-expand bg-white shadow-sm" style="height: 3.5rem;">
  <div class="container-fluid">
    
    {{-- Hamburger Menu for Sidebar --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
          <i class="bi bi-list fs-4"></i>
        </a>
      </li>
    </ul>

    <a href="{{ route('rules.index') }}" class="navbar-brand ms-2">
      <img src="{{ asset('assets/img/logo-sns.png') }}" alt="Logo SNS.AC"
        style="height: 35px; width: auto; object-fit: contain;">
    </a>

    <ul class="navbar-nav ms-auto align-items-center">
      {{-- Switch Layout Button --}}
      @if(auth()->check() && auth()->user()->role >= 2)
      <li class="nav-item me-2">
        <a href="{{ route('rules.index') }}" class="btn btn-outline-primary btn-sm mt-1 d-flex align-items-center gap-1">
          <i class="bi bi-card-checklist"></i> <span class="d-none d-md-inline">Kembali ke Kuesioner</span>
        </a>
      </li>
      @endif

      {{-- Fullscreen Toggle --}}
      <li class="nav-item me-2">
        <a class="nav-link" href="#" data-lte-toggle="fullscreen" role="button" aria-label="Toggle Fullscreen">
          <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen fs-5"></i>
          <i data-lte-icon="minimize" class="bi bi-fullscreen-exit fs-5" style="display: none;"></i>
        </a>
      </li>

      {{-- User Dropdown --}}
      <li class="nav-item dropdown">
        <a href="#" class="nav-link d-flex align-items-center gap-2" data-bs-toggle="dropdown"
          data-bs-auto-close="outside">
          <img src="{{ asset(auth()->user()->profile ?? 'assets/img/userno.png') }}"
            class="user-image rounded-circle shadow-sm" style="width: 35px; height: 35px; object-fit: cover;"
            alt="User Image" />

          <div class="d-none d-md-flex flex-column text-start" style="line-height: 1.2;">
            <span class="fw-bold text-dark" style="font-size: 0.9rem;">{{ auth()->user()->nama ?? 'Admin' }}</span>
            <span class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->cabang ?? 'Administrator' }}</span>
          </div>

        </a>

        {{-- Dropdown --}}
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="width: 280px; border-radius: 12px;">

          {{-- Profil Besar --}}
          <li class="text-center py-4 px-3 bg-light rounded-top">
            <img src="{{ asset(auth()->user()->profile ?? 'assets/img/userno.png') }}"
              class="rounded-circle shadow mb-3 border border-white"
              style="width: 90px; height: 90px; object-fit: cover;" alt="Avatar">
            <h6 class="fw-bold mb-0 text-dark fs-5">{{ auth()->user()->nama ?? 'Admin' }}</h6>
            <div class="mt-2">
              <span class="badge bg-primary rounded-pill px-3 py-1">{{ auth()->user()->cabang ?? 'Administrator' }}</span>
            </div>
          </li>

          <li>
            <hr class="dropdown-divider m-0">
          </li>

          {{-- Footer Dropdown (Logout) --}}
          <li class="p-3">
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit"
                class="btn btn-danger text-light w-100 fw-bold d-flex align-items-center justify-content-center gap-2 rounded-3 shadow-sm">
                <i class="bi bi-box-arrow-right"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
