@php
    $breadcrumb = '<h4 class="py-3 mb-4">
            <a href="'.route('moderator-management').'"><span class="text-muted fw-light">Moderator Management </span></a>
        </h4>';
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', 'Moderator Management')
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

    <!-- Hoverable Table rows -->
    <div class="card">
        <div class="header-custom-block">
            <h5 class="card-header">Moderator Management</h5>
            @can('moderator_management-create')
            <a href="{{ route('moderator-management.create') }}" class="btn btn-primary">+ Add New Moderator</a>
            @endcan
        </div>
        <div class="table-responsive">
            <table class="datatables-ajax table table-bordered dataTable no-footer" id="user-management-table">
                <caption></caption>
                <thead>
                    <tr>
                        <th class="custom-width">Id</th>
                        <th class="custom-width">Name</th>
                        <th class="custom-width">Email Id</th>
                        <th class="custom-width">Role</th>
                        <th class="custom-width">Status</th>
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
                })
            });
            
            $('body').on('change', '.status', function() {
                let status = $(this).prop('checked');
                let id = $(this).attr('data-id');

                $.ajax({
                    url: "{{ route('users.status') }}",
                    type: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({
                        "_token": "{{ csrf_token() }}",
                        status: status,
                        id: id
                    }),
                    success: function(response, status) {
                        if (table !== null) {
                            table.clear().destroy(); // Destroy the DataTable
                        }
                        if (response.status === 200) {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            }
                            toastr.success(response.message);
                        }
                        dataTableFun();
                    }
                });
            });

            function dataTableFun() {
                var isCmsEditOrDeleteAllowed = <?php echo json_encode(auth()->user()->can('moderator_management-edit') || auth()->user()->can('moderator_management-delete')); ?>;
                table = $('#user-management-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('moderator-management') }}",
                    columns: [{data: 'DT_RowIndex', name: 'DT_RowIndex'},
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'role',
                            name: 'role'
                        },
                        {
                            data: 'status',
                            name: 'status'
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
            toastr.success("{{ session('message') }}");
        @endif
    </script>
@endsection
