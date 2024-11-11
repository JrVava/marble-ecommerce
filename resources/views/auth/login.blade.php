@php
    $settings = null;
    if(isset($setting[0])){
        $settings = $setting[0];
    }
@endphp
@extends('layouts/blankLayout')

@section('title', 'Login')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ getBaseUrl().'/vendor/css/pages/page-auth.css' }}">
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
            @endif
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    {{-- @if(isset($settings))
                                    <img src="{{ getStorage($settings->small_logo) }}"
                                        alt="{{ $settings->small_logo }}" style="width:46px">
                                    @else
                                    <img src="{{ getBaseUrl().'/img/STPL_Icon.webp' }}"
                                        alt="{{ config('variables.templateName') }}" style="width:46px">
                                    @endif --}}
                                </span>
                                <span
                                    class="app-brand-text demo text-body fw-bold">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to 
                            @if(isset($settings))
                                {{ $settings->panel_name }}
                            @else
                            {{ config('variables.templateName') }}
                            @endif
                            ! 👋
                        </h4>
                        {{-- <p class="mb-4">Please sign-in to your account and start the adventure</p> --}}
                        <form id="formAuthentication" method="POST" class="mb-3" action="{{ route('login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="email" class="form-control"
                                    id="email" name="email" placeholder="Enter your Email Id" autocomplete="off" >
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control" name="password"
                                        
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}
                                        type="checkbox" id="remember-me">
                                    <label class="form-check-label" for="remember-me">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        {{-- <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ url('auth/register-basic') }}">
                                <span>Create an account</span>
                            </a>
                        </p> --}}
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#email').val(''); // Clear the email field on page load
            $('#password').val('');
        });
    </script>
@endsection
