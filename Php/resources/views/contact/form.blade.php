@extends('layout')
@section('content')
<div class="container">
    @include('navigation')
    <form id="contactForm" @if(isset($data)) action="{{ route('contact.update', $data->id) }}" @else action="{{ route('contact.store') }}" @endif>
        @csrf
        @if(isset($data))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $data->name ?? '' }}">
            <div class="text-danger" id="nameError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="company">Company</label>
            <input type="text" class="form-control" id="company" name="company" placeholder="Company" value="{{ $data->company ?? '' }}">
            <div class="text-danger" id="companyError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" value="{{ $data->phone ?? '' }}">
            <div class="text-danger" id="phoneError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $data->email ?? '' }}">
            <div class="text-danger" id="emailError" style="display: none;"></div>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#contactForm').submit(function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Serialize form data
            var formData = $(this).serialize();

            // Send AJAX request to Laravel backend
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle successful response
                    window.location.replace(response.route);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    var errors = xhr.responseJSON.errors;
                    displayErrors(errors);
                }
            });
        });

        function displayErrors(errors) {
            $('#nameError').hide().empty();
            $('#companyError').hide().empty();
            $('#phoneError').hide().empty();
            $('#emailError').hide().empty();

            if (errors && typeof errors === 'object') {
                if (errors.hasOwnProperty('name')) {
                    $('#nameError').show().text(errors.name[0]);
                }

                if (errors.hasOwnProperty('company')) {
                    $('#companyError').show().text(errors.company[0]);
                }

                if (errors.hasOwnProperty('phone')) {
                    $('#phoneError').show().text(errors.phone[0]);
                }

                if (errors.hasOwnProperty('email')) {
                    $('#emailError').show().text(errors.email[0]);
                }
            } else {
                console.error('Unexpected error response:', errors);
            }
        }
    });
</script>
@endsection
