@extends('auth.layout.app')

@section('title', 'Register')

@section('content')
    @php
        $selectedState = old('state_id', $userData->state_id ?? '');
        $selectedCity = old('city_id', $userData->city_id ?? '');
    @endphp

    <div class="container mt-5">
        <h2>Register Form</h2>
        <form id="registerForm" method="POST" action="{{ isset($isEdit) ? route('profile.update') : route('register') }}" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $userData->name ?? '') }}">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address:</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ old('email', $userData->email ?? '') }}">
                <span id="email-feedback" class="form-text"></span>
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-3">
                <label for="contact">Contact</label>
                <input type="text" class="form-control" name="contact"
                    value="{{ old('contact', $userData->contact ?? '') }}">
            </div>
            @if (isset($isEdit))
                <div class="mb-3">
                    <label for="profile_image">Profile Image</label>
                    <input type="file" class="form-control" name="profile_image">

                    <div class="mt-3">
                        <strong>Current Image:</strong><br>
                        <img src="{{ $userData->profile_image ? asset('uploads/profile/' . $userData->profile_image) : asset('default/profile.png') }}"
                            alt="Profile Image" class="rounded-circle" width="100" height="100">
                    </div>
                </div>
            @endif

            @if (!isset($isEdit))
                <div class="mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" name="password_confirmation">
                </div>
            @endif

            <div class="mb-3">
                <label>State</label>
                <select name="state_id" id="state_id" class="form-control">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->id }}"
                            {{ old('state_id', $userData->state_id ?? '') == $state->id ? 'selected' : '' }}>
                            {{ $state->sname }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>City</label>


                <select name="city_id" id="city_id" class="form-control">
                    <option value="">Select City</option>
                    {{-- Cities will be populated via AJAX --}}
                </select>
            </div>

            <div class="mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control">{{ old('address', $userData->address ?? '') }}</textarea>
            </div>

            <button type="submit" class="btn btn-{{ isset($isEdit) ? 'warning' : 'primary' }}">
                {{ isset($isEdit) ? 'Update Profile' : 'Register' }}
            </button>
        </form>

    </div>
    <script>
        $(document).ready(function() {
            let selectedState = $('#state_id').val();
            let selectedCity = "{{ old('city_id', $userData->city_id ?? '') }}";

            function loadCities(stateId, cityIdToSelect = null) {
                if (!stateId) return;

                $('#city_id').html('<option>Loading...</option>');

                $.ajax({
                    url: "{{ route('get.cities') }}",
                    type: "GET",
                    data: {
                        state_id: stateId
                    },
                    success: function(data) {
                        $('#city_id').empty().append('<option value="">Select City</option>');
                        $.each(data, function(key, city) {
                            let selected = city.id == cityIdToSelect ? 'selected' : '';
                            $('#city_id').append(
                                `<option value="${city.id}" ${selected}>${city.cname}</option>`
                                );
                        });
                    }
                });
            }

            // ✅ On page load (edit mode)
            if (selectedState && selectedCity) {
                loadCities(selectedState, selectedCity);
            }

            // ✅ When state changes
            $('#state_id').on('change', function() {
                let stateID = $(this).val();
                loadCities(stateID); // without selected city
            });
        });
    </script>

@endsection
