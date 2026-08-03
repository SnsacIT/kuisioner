<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  {{-- 1. Meta Tags --}}
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Kuisioner System</title>

  {{-- 4. Vendor CSS (Libraries) --}}
  {{-- UI & Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" />

  {{-- DataTables CSS --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/4.0.1/css/fixedHeader.bootstrap5.min.css">

  {{-- Select2 CSS --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  
  {{-- 5. App CSS & JS (Vite Removed) --}}
  <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
  <script src="{{ asset('assets/js/app.js') }}"></script>
</head>

<body class="bg-body-tertiary">
  <div class="app-wrapper">
    <x-navbar />
    {{-- <x-sidebar /> --}}
    <main class="app-main">
      <div class="app-content-wrapper">
        {{-- @yield('breadcrumb') --}}
        @yield('section-header')

        <x-session-status />
        
        @yield('content')
      </div>
      <x-footer />
      <x-back-to-top />
    </main>
  </div>

  {{-- ===================== JAVASCRIPT ===================== --}}

  @include('layouts.script')

  {{-- 5. Page Specific Scripts --}}
  @stack('scripts')
</body>

</html>