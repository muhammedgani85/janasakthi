@extends('layouts/contentNavbarLayout')

@section('title', 'Customer Print Management')

@section('page-script')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection





<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>






<style>
  .holiday {
    color: red;
  }

  .sunday {
    color: blue;
  }
</style>

<style>
.form-control {
    height: 40px; /* Set the height for input fields */
}
.btn {
    height: 40px; /* Make buttons the same height as inputs */
    margin-left: 5px; /* Optional: Add some space between buttons */
}
.select2-container .select2-selection--single {
  height: 34px !important;
}

.select2-container--default .select2-selection--single {
 /*  border: 1px solid #ccc !important; */
  border-radius: 0px !important;
}
</style>

@section('content')
<h4 class="py-0 mb-4">
  <span class="text-muted fw-light" style="color:red !important;">Customer Print</span>
</h4>

<div class="row">
  @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  <div class="card">

    <div class="table-responsive text-nowrap" style="margin-top:30px;">
    <form method="GET" action="{{ route('customers.report.index') }}" class="mb-3 p-3 border rounded bg-light">
    <div class="form-row align-items-center">


        <div class="col-md-2 col-sm-12 mb-2">
            <label for="pincode" class="font-weight-bold">Pincode:</label>
            <select name="pincode" id="pincode" class="form-control select2">
        <option value="">Choose</option>
        @foreach ($pincode as $pin)
            <option value="{{ $pin->id }}">{{ $pin->pin_code . '-' . $pin->name }}</option>
        @endforeach
    </select>
        </div>







        <div class="col-md-2 col-sm-12 mb-2" style="margin-left:70px;">
            <label for="city" class="font-weight-bold">District:</label>
            <select name="district_id" id="district_id" class="form-control select2">
                <option value="">Choose</option>
                @foreach ($district as $dist)
                    <option value="{{ $dist->id }}">{{ $dist->district_name." ".$dist->district_name_tamil  }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 col-sm-12 mb-2" style="margin-left:70px;">
            <label for="city" class="font-weight-bold">No of Column:</label>
            <input type="text" id="column" name="column" />
        </div>

        <div class="col-auto mb-2" style="margin-left:90px;">
           <!--  <button type="submit" class="btn btn-primary">Filter</button> -->
            <a href="{{ route('customers_print.index') }}" class="btn btn-secondary">Clear</a>
            <button type="button" class="btn btn-success" onclick="openPrintPreview()">Print</button>
        </div>
    </div>
</form>
<!-- <select class="form-control select2">
        <option>Select</option>
        <option>Car</option>
        <option>Bike</option>
        <option>Scooter</option>
        <option>Cycle</option>
        <option>Horse</option>
      </select> -->





    </div>
  </div>
</div>

<!-- Include required libraries -->


<script>
  $('.select2').select2();
</script>


<script>
    function openPrintPreview() {
        const url = new URL('{{ route('page_print') }}');
        const params = new URLSearchParams(new FormData(document.querySelector('form')));
        url.search = params.toString();
        window.open(url, '_blank');
    }
</script>



@endsection
