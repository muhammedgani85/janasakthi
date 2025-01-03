@extends('layouts/contentNavbarLayout')

@section('title', 'New Sandha')

@section('content')

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Sandha Details </span> </h4>
<form id="editSandhaForm" method="POST" action="{{ route('pincodes.update', $pincode->id) }}">
  @csrf
  @method('PUT') <!-- Add method override for PUT -->

  <div class="row">
    <div class="col-md-6">
      <div class="card mb-4">
        <h5 class="card-header">Sandha Information</h5>
        <div class="card-body demo-vertical-spacing demo-only-element">

        <div class="input-group">
            <span class="input-group-text">Name</span>
            <input type="text" aria-label="sandha_name name" name="name" id="name" class="form-control" value="{{ $pincode->name }} ">

          </div>

          <div class="input-group">
            <span class="input-group-text">Tamil Name</span>
            <input type="text" aria-label="sandha_name name" name="name_tamil" id="name_tamil" class="form-control" value="{{ $pincode->name_tamil }}">

          </div>


          <div class="input-group">
            <span class="input-group-text">Pincode </span>
            <input type="text" aria-label="First name" name="pin_code" id="pin_code" class="form-control" maxlength="6" minlength="6" value="{{ $pincode->pin_code }}">
            <input type="hidden" aria-label="First name" name="updated_by" id="updated_by" class="form-control" value="{{ session('user_data')->id }}">

          </div>


          <div class="input-group">
            <span class="input-group-text">Status</span>
            <select name="status" id="status" class="form-control">

                <option value="Active"  {{ $pincode->status == 'Active' ? 'selected' : '' }}>Active</option>
                <option value="InActive" {{ $pincode->status == 'InActive' ? 'selected' : '' }}>InActive</option>
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
          <a href="{{ route('pincodes.index') }}" class="btn rounded-pill btn-secondary">Cancel</a>
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
                        text: "Sandha updated successfully.",
                        icon: "success",
                    }).then(() => {
                        window.location.href = "{{ route('pincodes.index') }}"; // Redirect to index
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








@endsection
