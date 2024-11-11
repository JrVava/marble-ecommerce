<!-- BEGIN: Vendor JS-->
<script src="{{ getBaseUrl().'/vendor/libs/jquery/jquery.js' }}"></script>
<script src="{{ getBaseUrl().'/vendor/libs/popper/popper.js' }}"></script>
<script src="{{ getBaseUrl().'/vendor/js/bootstrap.js' }}"></script>
<script src="{{ getBaseUrl().'/vendor/libs/perfect-scrollbar/perfect-scrollbar.js' }}"></script>
<script src="{{ getBaseUrl().'/vendor/js/menu.js' }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>



@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ getBaseUrl().'/js/main.js' }}"></script>


<!-- END: Theme JS-->
<!-- Pricing Modal JS-->
@stack('pricing-script')
<!-- END: Pricing Modal JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
