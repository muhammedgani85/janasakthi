@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Management')

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
  <span class="text-muted fw-light" style="color:red !important;">Sandha Reminders(s)</span>
</h4>

<div class="row">



  <!-- Form controls -->

  <div class="card">
    <div class="table-responsive text-nowrap">


      <!-- <table class="table table-bordered" style="margin-bottom: 20px;" id="usersTable"> -->



      @if(count($unpaidCustomers) > 0)
    <table class="table table-bordered" style="margin-bottom: 20px;" id="usersTable">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Join Date</th>
                <th>Sandha Plan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unpaidCustomers as $customer)
            <tr>
                <td>{{ $customer->customer_id }}</td>
                <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                <td>{{ $customer->email_id }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ $customer->join_date }}</td>
                <td></td>
                <td>
                    <a href="" class="btn btn-info btn-sm">make a Payment</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <p>No unpaid customers found.</p>
    @endif
  </div>
</div>


</div>
<script>
new DataTable('#usersTable', {

    lengthMenu: [10, 25, 50, 100],
});


</script>






<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

@endsection
