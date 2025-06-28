$(document).ready(function () {
    $('#registerForm').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            contact: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            state_id: {
                required: true
            },
            city_id: {
                required: true
            },
            address: {
                required: true,
                minlength: 5
            }
        },
        messages: {
            name: {
                required: "Please enter your full name",
                minlength: "Name must be at least 2 characters"
            },
            email: {
                required: "Email is required",
                email: "Enter a valid email"
            },
            contact: {
                required: "Contact number is required",
                digits: "Only numbers allowed",
                minlength: "Contact must be 10 digits",
                maxlength: "Contact must be 10 digits"
            },
            password: {
                required: "Password is required",
                minlength: "Minimum 6 characters"
            },
            password_confirmation: {
                required: "Confirm your password",
                equalTo: "Passwords do not match"
            },
            state_id: {
                required: "Please select a state"
            },
            city_id: {
                required: "Please select a city"
            },
            address: {
                required: "Address is required",
                minlength: "Minimum 5 characters"
            }
        },
        errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
    let selectedCity = "{{ old('city_id', $userData->city_id ?? '') }}";
    let selectedState = "{{ old('state_id', $userData->state_id ?? '') }}";

    if (selectedState) {
        $.ajax({
            url: "/get-cities",
            type: "GET",
            data: { state_id: selectedState },
            success: function (data) {
                $('#city_id').empty().append('<option value="">Select City</option>');
                $.each(data, function (key, city) {
                    let selected = (city.id == selectedCity) ? 'selected' : '';
                    $('#city_id').append(`<option value="${city.id}" ${selected}>${city.cname}</option>`);
                });
            }
        });
    }

    $('#state_id').on('change', function () {
        let stateID = $(this).val();
        $('#city_id').empty().append('<option value="">Loading...</option>');

        if (stateID) {
            $.ajax({
                url: "/get-cities",
                type: "GET",
                data: { state_id: stateID },
                success: function (data) {
                    $('#city_id').empty().append('<option value="">Select City</option>');
                    $.each(data, function (key, city) {
                        $('#city_id').append('<option value="' + city.id + '">' + city.cname + '</option>');
                    });
                }
            });
        }
    });
    $('#email').on('blur', function () {
        let email = $(this).val();
        let $feedback = $('#email-feedback');

        if (email) {
            $.ajax({
                url: "/check-email",
                type: "GET",
                data: { email: email },
                success: function (response) {
                    if (response.exists) {
                        $feedback.text('Email already registered!').css('color', 'red');
                    } else {
                        $feedback.text('Email is available ✅').css('color', 'green');
                    }
                },
                error: function () {
                    $feedback.text('Unable to check email!').css('color', 'orange');
                }
            });
        } else {
            $feedback.text('');
        }
    });
});
