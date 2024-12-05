@php
    $breadcrumb = '<h4 class="py-3 mb-4">
            <a href="'.route('role-permission.list').'"><span class="text-muted fw-light">Roles & Permission </span></a>
        </h4>';
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', 'Roles & Permission')
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

        button.btn-close {
            right: -2rem;
            -webkit-transform: translate(23px, -25px);
            transform: translate(23px, -25px);
            position: absolute;
            top: -2rem;
        }
    </style>
    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="header-custom-block">
            <h5 class="card-header">Roles & Permission</h5>
            @can('role_permission-create')
            <a href="{{ route('role-permission.create') }}" class="btn btn-primary">+ Add New Role</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table class="datatables-ajax table table-bordered dataTable no-footer" id="role-permission-table">
                <caption></caption>
                <thead>
                    <tr>
                        <th class="custom-width">Id</th>
                        <th class="custom-width">Name</th>
                        <th class="custom-width">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0s">

                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Start Here --}}
   
    {{-- Modal End Here --}}


    <script>
        $(document).ready(function() {
            $("body").on("click", ".delete-cms", function(e) {
                e.preventDefault();
                let text = "Are you sure you want to delete this cms?";
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

            var table = null;
            dataTableFun();

            function dataTableFun() {
                var isCmsEditOrDeleteAllowed = <?php echo json_encode(auth()->user()->can('role_permission-edit') || auth()->user()->can('role_permission-delete')); ?>;
                table = $('#role-permission-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('role-permission.list') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            visible: isCmsEditOrDeleteAllowed
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
            toastr.success("{{ session('message') }}")
        @endif
    </script>
@endsection
