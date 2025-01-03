<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{ getBaseUrl(). '/vendor/fonts/boxicons.css' }}" />

<!-- Core CSS -->
<link rel="stylesheet" href="{{ getBaseUrl(). '/vendor/css/core.css' }}" />
<link rel="stylesheet" href="{{ getBaseUrl(). '/vendor/css/theme-default.css' }}" />
<link rel="stylesheet" href="{{ getBaseUrl(). '/css/demo.css' }}" />
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ getBaseUrl(). '/vendor/libs/perfect-scrollbar/perfect-scrollbar.css' }}" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')
