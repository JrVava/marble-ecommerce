@php
    $mode = isset($user->id) ? 'Edit' : 'Add';
    $breadcrumb = '<h4 class="py-3 mb-4">
        <a href="'.route('user-management').'">
            <span class="text-muted fw-light">User Management</span></a><span class="text-muted fw-light">/</span>'. $mode .'
            </h4>';
    if(isset($user->id)){
            $route = route('user-management.update');
        }else{
            $route = route('user-management.save');
        }
@endphp
@extends('layouts/contentNavbarLayout')

@section('title', ' User Management - ' . $mode)
@section('breadcrumb')
    {!! $breadcrumb !!}
@endsection
@section('content')
    <!-- Basic Layout -->
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
        </div>
    @endif
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Management</h5> <small class="text-muted float-end">User Management</small>
                </div>
                <div class="card-body">
                    <form action="{{ $route }}" method="post">
                        @csrf
                        <input type="hidden" name="id"
                            value="@if (isset($user->id)) {{ $user->id }} @endif">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Id"
                                value="@if(isset($user->email)){{ $user->email }}@else{{ old('email') }}@endif"
                                {{ isset($user) ? 'readonly' : '' }} ppattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}"
                                title="Please enter a valid email address" oninput="checkEmailValidity(this)" />
                                <span id="emailError" style="color: red;"></span>

                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="@if(isset($user->name)){{ $user->name }}@else{{ old('name') }}@endif"
                                placeholder="Name" />
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">--Select Gender--</option>
                                <option value="Male" @if (isset($user->gender) && $user->gender == 'Male') selected @endif>Male</option>
                                <option value="Female" @if (isset($user->gender) && $user->gender == 'Female') selected @endif>Female</option>
                                <option value="Other" @if (isset($user->gender) && $user->gender == 'Other') selected @endif>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-phone">Date of Birth</label>
                            <input type="text" name="dob" id="dob" class="form-control phone-mask"
                                placeholder="Date Of Birth"
                                value="@if(isset($user->dob)){{ $user->dob }}@else{{ old('dob') }}@endif" />
                            @error('dob')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control phone-mask"
                                placeholder="Phone Number"
                                value="@if(isset($user->phone_number)){{ $user->phone_number }}@else{{ old('phone_number') }}@endif" />
                                @error('phone_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Address</label>
                            <textarea class="form-control" name="address" placeholder="Address">@if (isset($user->address)){{ $user->address }}@else{{ old('address') }}@endif</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-message">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" @if (isset($user->status) && $user->status) selected @endif>Active</option>
                                <option value="0" @if (isset($user->status) && $user->status == 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                        @if (!isset($user->id))
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">Password</label>
                                <input type="password" name="password" id="password" class="form-control password"
                                    placeholder="Password" />
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm-password"
                                    class="form-control password" placeholder="Confirm Password" />
                            </div>
                        @endif
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        flatpickr("#dob", {
            maxDate: "today",
            dateFormat: "Y-m-d",
        });

        function checkEmailValidity(input) {
            var errorSpan = document.getElementById('emailError');
            var isValid = input.checkValidity();

            if (!isValid) {
                errorSpan.textContent = 'Please enter a valid email address';
            } else {
                errorSpan.textContent = '';
            }
        }
    </script>
@endsection
