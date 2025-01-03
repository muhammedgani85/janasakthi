@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Customer')

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Customer Details </span> </h4>
<form id="customerForm" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Add this line to specify PUT request for update -->
    <div class="row">
        <!-- Basic Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Basic Information</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                @if ($customer->customer_photo !=NULL)
                <div align="center"><img src="{{ $customer->customer_photo ? asset('storage/' . $customer->customer_photo) : asset('assets/images/sj_logo.png') }}"  alt="Image" style="width:150px; height:110px; border-radius:50%;"></div>
                @endif
                    <div class="input-group">
                        <span class="input-group-text">Customer ID</span>
                        <input type="text" name="customer_id" id="customer_id" class="form-control" value="{{ $customer->customer_id}}" readonly>
                        <input type="hidden" name="location_id" id="location_id" class="form-control" value="{{ $location }}" readonly>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Initial</span>
                        <input type="text" name="initial" id="initial" class="form-control" maxlength="2" minlength="1" value="{{ $customer->initial }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">First Name</span>
                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $customer->first_name }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Last Name</span>
                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $customer->last_name }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Father Name</span>
                        <input type="text" name="father_name" id="father_name" class="form-control" value="{{ $customer->father_name }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Spouse Name</span>
                        <input type="text" name="spouse_name" id="spouse_name" class="form-control" value="{{ $customer->spouse_name }}">
                    </div>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Gender</label>
                        <select class="form-select" id="gender" name="gender">
                            <option selected>Choose...</option>
                            <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="FeMale" {{ $customer->gender == 'FeMale' ? 'selected' : '' }}>FeMale</option>
                            <option value="Others" {{ $customer->gender == 'Others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">DOB</span>
                        <input type="date" name="dob" id="dob" class="form-control" value="{{ $customer->dob }}">
                    </div>
                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Marital Status</label>
                        <select class="form-select" id="marital_status" name="marital_status">
                            <option selected>Choose...</option>
                            <option value="UnMarried" {{ $customer->marital_status == 'UnMarried' ? 'selected' : '' }}>UnMarried</option>
                            <option value="Married" {{ $customer->marital_status == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Single" {{ $customer->marital_status == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Widow" {{ $customer->marital_status == 'Widow' ? 'selected' : '' }}>Widow</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Details -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Contact Details</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="input-group">
                        <span class="input-group-text">Phone Number</span>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" onkeypress="return isNumber(event)" maxlength="13" minlength="10" value="{{ $customer->phone_number }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Emr. Number</span>
                        <input type="text" name="emergency_number" id="emergency_number" class="form-control" onkeypress="return isNumber(event)" maxlength="13" minlength="10" value="{{ $customer->emergency_number }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Email</span>
                        <input type="text" name="email_id" id="email_id" class="form-control" value="{{ $customer->email_id }}">
                    </div>

                    <div class="input-group">
            <span class="input-group-text">State</span>
            <select class="form-select" id="state_id" name="state_id">
              <option selected>Choose...</option>
              @foreach($states as $state)
              <option value="{{  $state->id }}" {{ $customer->state_id == $state->id ? 'selected' : '' }}>{{ $state->name. "-".$state->name_tamil  }}</option>

              @endforeach
            </select>

          </div>
          <div class="input-group">
            <span class="input-group-text">District</span>
            <select class="form-select" id="district_id" name="district_id">
              <option selected>Choose...</option>
              @foreach($district as $dis)
              <option value="{{  $dis->id }}" {{ $customer->district_id == $dis->id ? 'selected' : '' }}>{{ $dis->district_name. "-".$dis->district_name_tamil  }}</option>

              @endforeach
            </select>

          </div>


             <div class="input-group">
            <span class="input-group-text">City</span>
            <select class="form-select" id="city" name="city">
              <option selected>Choose...</option>
              @foreach($city as $cty)
              <option value="{{  $cty->id }}" {{ $customer->city == $cty->id ? 'selected' : '' }}>{{ $cty->name. "-".$cty->name_tamil  }}</option>

              @endforeach
            </select>

          </div>

          <div class="input-group">
            <span class="input-group-text">Pincode</span>
            <select class="form-select" id="pincode" name="pincode">

            <option selected>Choose...</option>
            </select>


          </div>

          <!-- Add a loading spinner -->
<div id="loading-spinner" style="display: none;color:red;">
    Loading data, please wait...
</div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Permanent Address</span>
                        <textarea class="form-control" name="permanent_address" id="permanent_address">{{ $customer->permanent_address }}</textarea>
                    </div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Communication Address</span>
                        <textarea class="form-control" name="communication_address" id="communication_address">{{ $customer->communication_address }}</textarea>
                    </div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Ward</span>
                        <textarea class="form-control" name="ward" id="ward">{{ $customer->ward }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Identification -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Identification</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                    <div class="input-group">
                        <span class="input-group-text">Aadhar Number</span>
                        <input type="text" name="aadhar_number" id="aadhar_number" class="form-control" onkeypress="return isNumber(event)" maxlength="16" minlength="16" value="{{ $customer->aadhar_number }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Driving Lic Number</span>
                        <input type="text" name="driving_license_number" id="driving_license_number" class="form-control" value="{{ $customer->driving_license_number }}">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">PAN</span>
                        <input type="text" name="pan" id="pan" class="form-control" value="{{ $customer->pan }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Occupation -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Ocupation</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">

                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Occupation</label>
                        <select class="form-select" id="occupation_id" name="occupation_id">
                            <option selected>Choose...</option>
                            @foreach($occupations as $occupation)
                            <option value="{{  $occupation->id }}" {{ $customer->occupation_id  == $occupation->id  ? 'selected' : '' }}>{{ $occupation->occupation }}</option>

                            @endforeach
                        </select>
                    </div>

                    <div class="input-group">
                        <label class="input-group-text" for="inputGroupSelect01">Type</label>
                        <select class="form-select" id="occupation_type" name="occupation_type">
                            <option selected>Choose...</option>
                            <option value="Salaried" {{ $customer->occupation_type == 'Salaried' ? 'selected' : '' }}>Salaried</option>
                            <option value="Business" {{ $customer->occupation_type == 'Business' ? 'selected' : '' }}>Business</option>

                        </select>
                    </div>

                    <div class="input-group">
                        <span class="input-group-text">Job Title</span>
                        <input type="text" aria-label="First name" name="job_type_details" id="job_type_details" class="form-control" value="{{ $customer->job_type_details }}">

                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">References</h5>

                <div class="card-body demo-vertical-spacing demo-only-element">

                <div class="input-group">
          <label class="input-group-text" for="inputGroupSelect01">Ref 1</label>

          <select class="form-select" id="r_name" name="r_name">
              <option selected>Choose...</option>
              @foreach ($ref_customers as $refc )
              <option value="{{ $refc->id }} " {{ $customer->r_name == $refc->id ? 'selected' : '' }}>{{ $refc->first_name." - ".$refc->last_name  }} </option>

              @endforeach

            </select>

          </div>
                    <div class="input-group">
                        <span class="input-group-text">Phone No:</span>
                        <input type="text" aria-label="First name" name="r_phone" id="r_phone" class="form-control" value="{{ $customer->r_phone}}" onkeypress="return isNumber(event)" maxlength="13" minlength="10" readonly>

                    </div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Address</span>
                        <textarea class="form-control" aria-label="With textarea" name="r_address" id="r_address" value="{{ $customer->r_address}}" readonly></textarea>
                    </div>


                    <div class="input-group">
                        <span class="input-group-text">R.Name2:</span>
                        <input type="text" aria-label="First name" name="r_name1" id="r_name1" class="form-control" value="{{ $customer->r_name1}}">

                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Phone No:</span>
                        <input type="text" aria-label="First name" name="r_phone1" id="r_phone1" class="form-control" value="{{ $customer->r_phone1}}" onkeypress="return isNumber(event)" maxlength="13" minlength="10">

                    </div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Address</span>
                        <textarea class="form-control" aria-label="With textarea" name="r2_address" id="r2_address" value="{{ $customer->r2_address}}"></textarea>
                    </div>

                    <div class="input-group input-group-merge">
                        <span class="input-group-text">Others</span>
                        <textarea class="form-control" aria-label="With textarea" name="r_others" id="r_others" value="{{ $customer->r_others}}"></textarea>
                    </div>

                </div>

            </div>
        </div>
        <!-- Documents -->
        <div class="col-md-6">
            <div class="card mb-4">
                <h5 class="card-header">Documents</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">
                @if ($customer->customer_photo !=NULL)
                <img src="{{ $customer->customer_photo ? asset('storage/' . $customer->customer_photo) : asset('assets/images/sj_logo.png') }}"  alt="Image" style="width:50px; height:50px; border-radius:50%;">
                @endif

                @if ($customer->customer_other !=NULL)
                <img src="{{ $customer->customer_other ? asset('storage/' . $customer->customer_other) : asset('assets/images/sj_logo.png') }}"  alt="Image" style="width:50px; height:50px; border-radius:50%;">
                @endif

                @if ($customer->customer_aadharr !=NULL)
                <img src="{{ $customer->customer_aadharr ? asset('storage/' . $customer->customer_aadharr) : asset('assets/images/sj_logo.png') }}"  alt="Image" style="width:50px; height:50px; border-radius:50%;">
                @endif



                    <div class="input-group">
                        <input type="file" name="customer_photo" id="customer_photo" class="form-control">
                        <label class="input-group-text" for="customer_photo">Customer Photo</label>
                    </div>
                    <div class="input-group">
                        <input type="file" name="customer_aadharr" id="customer_aadharr" class="form-control">
                        <label class="input-group-text" for="customer_aadharr">Aadharr Card</label>
                    </div>
                    <div class="input-group">
                        <input type="file" name="customer_other" id="customer_other" class="form-control">
                        <label class="input-group-text" for="customer_other">Other Documents</label>
                    </div>




                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">Bank Details</h5>
                <div class="card-body demo-vertical-spacing demo-only-element">

                <div class="input-group">
            <span class="input-group-text">Plan</span>
            <select class="form-select" id="sandha_plan" name="sandha_plan">
            <option selected>Choose Plan</option>
            @foreach ($sandha_details as $sandha)
            <option value="{{ $sandha->id }}" {{ $customer->sandha_plan == $sandha->id ? 'selected' : '' }}>{{ $sandha->sandha_name. " - Duration : ".$sandha->duration." - Price : RS-".$sandha->price }}</option>
            @endforeach

            </select>

          </div>

          <div class="input-group">
            <span class="input-group-text">Customer Joining Date:</span>
            <input type="date" aria-label="First name" name="join_date" id="join_date" class="form-control" value="{{ $customer->join_date }}">

          </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body demo-vertical-spacing demo-only-element">
                        <div class="input-group">
                            <button type="button" id="submitForm" class="btn rounded-pill btn-success">Update</button>
                            <button type="button" class="btn rounded-pill btn-danger">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    // Event listener for dropdown click
    $('#pincode').on('click', function () {
        if ($('#pincode').children('option').length === 1) { // Fetch only if no data loaded yet
            $('#loading-spinner').show(); // Show loading spinner

            // Simulate AJAX call to fetch data
            $.ajax({
                url: '{{ route("fetch.pincode") }}', // Replace with your route
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#loading-spinner').hide(); // Hide loading spinner

                    // Populate dropdown with fetched data
                    $('#pincode').empty().append('<option selected>Choose...</option>');
                    $.each(data, function (key, value) {
                        $('#pincode').append('<option value="' + value.id + '">' + value.pin_code + ' - ' + value.name + '</option>');
                    });
                },
                error: function () {
                    $('#loading-spinner').hide(); // Hide loading spinner
                    alert('Failed to fetch data. Please try again later.');
                }
            });
        }
    });



    $('#r_name').change(function () {
                var customerId = $(this).val();
                if (customerId) {
                    $.ajax({
                        url: '/get-customer-details', // Laravel route
                        type: 'GET',
                        data: { id: customerId },
                        cache: false, // Prevent browser caching
                        success: function (response) {
                            $('#r_phone').val(response.r_phone);
                            $('#r_address').val(response.r_address);
                        },
                        error: function () {
                            alert('Failed to fetch customer details.');
                        }
                    });
                } else {
                    $('#phone_number').val('');
                    $('#address').val('');
                }
            });

});

</script>

<script>
    $('#submitForm').click(function(e) {
        e.preventDefault();
        let formData = new FormData($('#customerForm')[0]);

        $.ajax({
            url: "{{ route('customers.update', $customer->id) }}",
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                //alert(response.success);

                swal("Done!", response.success, "success");
                window.location.href = "{{ url('customers')}}";

                //location.reload();
            },
            error: function(response) {
                let errors = response.responseJSON.errors;
                $('#errorMessages').remove(); // Remove the previous error messages container
                let errorHtml = '<div id="errorMessages"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul></div>';
                $('#customerForm').before(errorHtml);
            }
        });
    });



    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.keyCode : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
@endsection
