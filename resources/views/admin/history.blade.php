@extends('layouts/contentNavbarLayout')

@section('title', ' History')
@section('breadcrumb')
    History
@endsection
@section('content')
<div class="container mt-4">
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Product</th>
                <th>Mobile</th>
                {{-- <th>Status</th> --}}
                <th>Sent at</th>
                <th width="100px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    $(function () {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('histories') }}",
          columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false}, 
              {data: 'product_name', name: 'product_name'},
              {data: 'mobile_number', name: 'mobile_number'},
              {data: 'send_at', name: 'send_at'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
  
          ]
      });
    });
  </script>
@endsection
