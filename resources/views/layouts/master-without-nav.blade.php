<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light">

    <head>
    <meta charset="utf-8" />
    <title>@yield('title') | {{ config('settings.app_name') ?? 'Web Coding' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    {{-- <link rel="shortcut icon" href="{{ isset($settings['favicon']) && !empty($settings['favicon']->value) ? asset('storage/' . $settings['favicon']->value) : URL::asset('build/icons/favicon.ico') }}"> --}}
    <link rel="shortcut icon" href="{{ config('settings.favicon') ? asset('storage/' . config('settings.favicon')) : asset('build/icons/favicon.ico') }}">
        @include('layouts.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('layouts.vendor-scripts')
    </body>
</html>
