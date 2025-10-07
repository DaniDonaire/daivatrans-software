@php
    // Obtener las preferencias del usuario autenticado
    $prefs = auth()->check() ? auth()->user()->preference : null;
    $darkMode = $prefs && $prefs->dark_mode ? 'dark' : 'light';
    $sidebarSize = $prefs && $prefs->sidebar_pinned ? 'sm-hover-active' : 'sm-hover';
@endphp
<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-tag-master" data-sidebar-size="{{ $sidebarSize }}" data-layout="vertical" data-topbar="light" data-sidebar="dark"  data-sidebar-image="none" data-preloader="disable" data-bs-theme="{{ $darkMode }}">
 
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('settings.app_name') ?? 'Web Coding' }} - Software Premium Desarrollado por Webcoding</title>    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Software Premium Personalizado | Desarrollado por WebCoding" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <!-- <link rel="shortcut icon" href="{{ isset($settings['favicon']) && !empty($settings['favicon']->value) ? asset('storage/' . $settings['favicon']->value) : URL::asset('build/icons/favicon.ico') }}"> -->
    <link rel="shortcut icon" href="{{ config('settings.favicon') ? asset('storage/' . config('settings.favicon')) : asset('build/icons/favicon.ico') }}">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- CSS de Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- JS de Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

    @include('layouts.head-css')
</head>

@section('body')
    @include('layouts.body')
@show
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    @include('layouts.customizer')

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
</body>

</html>
