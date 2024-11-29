@php
    $breadcrumb = '<h4 class="py-3 mb-4">
            <a href="'.route('users.list').'"><span class="text-muted fw-light">Products </span></a>
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
    <script>
        $(document).ready(function() {
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
                    columns: [{data: 'DT_RowIndex', name: 'DT_RowIndex'},
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
