@extends('layout')
@section('content')
<div class="container">
    <div class="text-center">
        <h1>Register</h1>
    </div>
    <form id="registrationForm">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
            <div class="text-danger" id="nameError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
            <div class="text-danger" id="emailError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <div class="text-danger" id="passwordError" style="display: none;"></div>
        </div>
        <div class="form-group">
            <label for="confirmPassword">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
        </div>
        <div class="text-right">
            <a href="{{ route('login.page') }}" class="btn btn-primary">Login</a>
            <button type="button" class="btn btn-primary" id="registerBtn">Submit</button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('#registerBtn').click(function() {
            // Serialize form data
            var formData = $('#registrationForm').serialize();

            // Send AJAX request to Laravel backend
            $.ajax({
                url: '{{ route("user.register") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Handle successful response
                    window.location.replace(response.route)
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
            $('#emailError').hide().empty();
            $('#passwordError').hide().empty();

            if (errors && typeof errors === 'object') {
                if (errors.hasOwnProperty('name')) {
                    $('#nameError').show().text(errors.name[0]);
                }

                if (errors.hasOwnProperty('email')) {
                    $('#emailError').show().text(errors.email[0]);
                }

                if (errors.hasOwnProperty('password')) {
                    $('#passwordError').show().text(errors.password[0]);
                }
            } else {
                console.error('Unexpected error response:', errors);
            }
        }
    });
</script>
@endsection