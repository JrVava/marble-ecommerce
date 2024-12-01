@php
    $breadcrumb =
        '<h4 class="py-3 mb-4">
            <a href="' .
        route('users.list') .
        '"><span class="text-muted fw-light">Products </span></a>
        </h4>';
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', 'Products')
@section('breadcrumb')
    {!! $breadcrumb !!}
@endsection
@section('content')
    <style>
        .custom-width {
            max-width: 90px;
            word-wrap: break-word;
        }

        .user-management-table {
            overflow-x: hidden;
        }

        /* Add padding to DataTable wrapper for space on both sides */
        .dataTables_wrapper {
            padding: 20px;
        }

        .header-custom-block {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            margin-bottom: 20px;
            margin-right: 15px;
        }
    </style>
    {{-- 
    <div class="header-custom-block">
        <a href="{{ route(users.create) }}" class="btn btn-primary">Add User</a>
    </div> --}}
    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="header-custom-block">
            <h5 class="card-header">Products</h5>

            @can('user_management-create')
                <a href="{{ route('products.create') }}" class="btn btn-primary">+ Add Product</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table class="datatables-ajax table table-bordered dataTable no-footer" id="user-management-table">
                <caption></caption>
                <thead>
                    <tr>
                        <th class="custom-width">Id</th>
                        <th class="custom-width">Name</th>
                        <th class="custom-width">SKU</th>
                        <th class="custom-width">QTY</th>
                        <th class="custom-width">Amount</th>
                        <th class="custom-width">Discount</th>
                        <th class="custom-width">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0s">

                </tbody>
            </table>
        </div>
    </div>


    {{-- QR Model Start Here --}}
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <b class="modal-title" id="qrModalLabel">QR Code of</b>
                    <strong id="product_name" class="ms-2 text-white"></strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div id="qrCodeContainer" class="p-4">
                        <!-- QR Code will be dynamically inserted here -->
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="printQrCode" class="btn btn-primary">
                        <i class="bx bx-printer"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- QR Model End Here --}}
    <script>
        $(document).ready(function() {
            $('#printQrCode').on('click', function() {
                var printContents = $('#qrCodeContainer').html();

                // Create a hidden iframe to use it for printing
                var iframe = document.createElement('iframe');
                iframe.style.position = 'absolute';
                iframe.style.width = '0';
                iframe.style.height = '0';
                iframe.style.border = 'none';
                document.body.appendChild(iframe);

                // Write HTML content into the iframe
                var doc = iframe.contentWindow.document;
                doc.open();
                doc.write(`
            <html>
            <head>
                <title>Print QR Code</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        padding: 0;
                    }
                    #qrCode {
                        width: 400px;
                        height: 400px;
                    }
                </style>
            </head>
            <body>
                <div id="qrCode">
                    ${printContents}
                </div>
            </body>
            </html>
        `);
                doc.close();

                // Print the content of the iframe
                iframe.contentWindow.focus();
                iframe.contentWindow.print();

                // Remove the iframe after printing
                document.body.removeChild(iframe);
            });

            $('#qrModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var productId = button.data('id'); // Extract product ID from data-id attribute
                var modal = $(this);
                var qrCodeContainer = modal.find('#qrCodeContainer');

                // Clear previous QR code content
                qrCodeContainer.html('<p>Loading QR Code...</p>');

                // Fetch the QR code via AJAX
                $.ajax({
                    url: `/products/qrcode/${productId}`,
                    method: 'GET',
                    success: function(response) {
                        console.log(response.productName);
                        $("#product_name").html(`<strong>${response.productName}</strong>`);
                        // Insert the QR code HTML into the modal
                        qrCodeContainer.html(response.qrCodeHtml);
                    },
                    error: function() {
                        qrCodeContainer.html(
                            '<p class="text-danger">Failed to load QR Code.</p>');
                    }
                });
            });
            var table = null;
            dataTableFun();
            $("body").on("click", ".delete-product", function(e) {
                e.preventDefault();
                let text = "Are you sure you want to delete this product?";
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).prev('form').submit();
                    }
                });
            });


            function dataTableFun() {
                table = $('#user-management-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('products.get-products') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'product_name',
                            name: 'product_name'
                        },
                        {
                            data: 'sku',
                            name: 'sku'
                        },
                        {
                            data: 'total_qty',
                            name: 'total_qty'
                        },
                        {
                            data: 'rate',
                            name: 'rate'
                        },
                        {
                            data: 'discount',
                            name: 'discount'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                        },
                    ],
                });
            }
        });
        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif
    </script>
@endsection
