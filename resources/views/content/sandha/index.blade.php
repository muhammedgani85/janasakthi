@extends('layouts/contentNavbarLayout')

@section('title', 'Sandha Management')

@section('page-script')
<script src="{{asset('assets/js/form-basic-inputs.js')}}"></script>
@endsection

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.print.min.js"></script>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.2.0/css/buttons.dataTables.css">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
  .text-left {
    text-align: left;
  }

  .text-success {
    color: green;
  }

  .text-warning {
    color: purple;
  }

  .text-danger {
    color: red;
  }


</style>
<!-- Include other styles here -->
@section('content')
<h4 class="py-0 mb-4">
  <span class="text-muted fw-light" style="color:red !important;">Sandha(s)</span>
</h4>

<div class="row">



  <!-- Form controls -->

  <div class="card">
    <div class="table-responsive text-nowrap">

      <table class="table table-bordered" style="margin-bottom: 20px;" id="usersTable">
        <thead style="background-color: #aed6f1;">
          <tr>

            <th>Sandha Name</th>
            <th>Duration</th>
            <th>Price</th>

            <th>Status</th>
            <th>No Of Copies</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sandhas as $sandha)


        <tr>

            <td>{{ $sandha->sandha_name }}</td>
            <td>{{ $sandha->duration }}</td>
            <td>{{ $sandha->price }}</td>
            <td style="color: {{ $sandha->status == 'active' ? 'green' : 'red' }};">{{ $sandha->status }}</td>
            <td>{{ $sandha->no_of_copies }}</td>
            <td><a href="javascript:void(0);" data-id="{{ $sandha->id }}" class="btn-delete" title="Inactive"><i class="bx bx-trash me-1" style=" color:red;"></i></a>
            <a href="{{ route('sandhas.edit', $sandha->id) }}" title="Edit">
            <i class="bx bx-pencil me-1"></i>
        </a>
          </td>
          </tr>
          @endforeach
    </tbody>
    </table>
  </div>
</div>


</div>
<script>
new DataTable('#usersTable', {

    lengthMenu: [10, 25, 50, 100],
});


</script>



<script>
  $(document).ready(function() {
    $('.btn-delete').on("click", function() {
      var $this = $(this);
      swal({
        title: "InActive?",
        text: "Please ensure and then confirm!",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
      }).then(function(e) {
        if (e.value) {
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          var userId = $this.data('id');

          $.ajax({
            type: 'DELETE',
            url: '{{ route("sandhas.softDelete", "") }}/' + userId,
            data: {
              _token: CSRF_TOKEN
            },
            dataType: 'JSON',
            success: function(results) {
              if (results.success) {
                swal("Done!", results.message, "success");
                setTimeout(function() {
                  location.reload()
                }, 2000);
              } else {
                swal("Error!", results.message, "error");
              }
            },
            error: function(xhr) {
              console.log(xhr.responseText);
            }
          });
        }
      });
    });
  });
</script>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

@endsection
