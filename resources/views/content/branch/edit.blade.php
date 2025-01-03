@extends('layouts/contentNavbarLayout')

@section('title', 'New Sandha')

@section('content')

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Location Details </span> </h4>
<form id="editSandhaForm" method="POST" action="{{ route('branch.update', $branch->id) }}">
  @csrf
  @method('PUT') <!-- Add method override for PUT -->

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <h5 class="card-header">Location Information</h5>
        <div class="card-body demo-vertical-spacing demo-only-element">

        <div class="input-group">
            <span class="input-group-text">Location Name</span>
            <input type="text" aria-label="sandha_name name" name="branch_name" id="branch_name" class="form-control" value="{{ $branch->branch_name }}">

          </div>


          <div class="input-group">
            <span class="input-group-text">ShortCode</span>
            <input type="text" aria-label="First name" name="branch_prefix" id="branch_prefix" class="form-control" value="{{ $branch->branch_prefix }}">


          </div>


          <div class="input-group">
            <span class="input-group-text">Address</span>
            <input type="text" aria-label="First name" name="address" id="address" class="form-control" value="{{ $branch->address }}">

          </div>

         <!--  -->
          <div class="input-group">
            <span class="input-group-text">Contact Number</span>
            <input type="text" aria-label="First name" name="mobile_number" id="mobile_number" class="form-control" onchange=isNumber(this.value); value="{{ $branch->mobile_number }}" minlength="10" maxlength="10">

          </div>

          <div class="input-group">
            <span class="input-group-text">Agent Name</span>
            <input type="text" aria-label="First name" name="org_name" id="org_name" class="form-control" value="{{ $branch->org_name }}">

          </div>

          <div class="input-group">
            <span class="input-group-text">Status</span>
            <select class="form-select" id="status" name="status">
              <option value="Active" {{ $branch->status == 'Active' ? 'selected' : '' }}>Active</option>
              <option value="InActive" {{ $branch->status == 'InActive' ? 'selected' : '' }}>InActive</option>
            </select>

          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Save Button -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <button type="submit" class="btn rounded-pill btn-success">Save Changes</button>
          <a href="{{ route('branch.index') }}" class="btn rounded-pill btn-secondary">Cancel</a>
        </div>
      </div>
    </div>
  </div>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
 $('#editSandhaForm').on('submit', function (e) {
    e.preventDefault();

    let form = $(this); // Reference to the form
    Swal.fire({
        title: "Save Changes?",
        text: "Please ensure and then confirm!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Update it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with form submission via AJAX
            $.ajax({
                url: form.attr('action'), // Ensure correct route in 'action' attribute
                method: 'POST', // Change to 'PUT' if your route expects a PUT request
                data: form.serialize(),
                success: function (response) {
                    Swal.fire({
                        title: "Success!",
                        text: "Location updated successfully.",
                        icon: "success",
                    }).then(() => {
                        window.location.href = "{{ route('branch.index') }}"; // Redirect to index
                    });
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    Swal.fire("Error!", errorHtml, "error");
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire("Cancelled", "Your changes were not saved!", "info");
        }
    });
});



</script>



<script>
  function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
    return true;
  }
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
            url: '{{ route("users.softDelete", "") }}/' + userId,
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#pincode').select2({
                placeholder: 'Search for Pincode...',
                ajax: {
                    url: '{{ route("fetch.pincode") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term // search term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>

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
});

document.getElementById('mobile_number').addEventListener('change', function () {
    const value = this.value;
    const regex = /^[0-9]+$/;
    if (!regex.test(value)) {
        alert("Please enter only numeric values!");
        this.value = ''; // Clear the invalid input
    }
});


</script>



@endsection
