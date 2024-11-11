@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('content')
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5">
            <div class="card mb-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">About</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-user"></i>
                            <span class="fw-medium mx-2">Full Name:</span>
                            <span>{{ $user->name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            {{-- <i class="bx bx-check"></i> --}}
                            <i class='bx bx-checkbox-checked'></i>
                            <span class="fw-medium mx-2">Status:</span>
                            <span>
                                @if ($user->status)
                                    Active
                                @else
                                    Inactive
                                @endif
                            </span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-child"></i>
                            <span class="fw-medium mx-2">Date of birth:</span>
                            <span>{{ $user->dob }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            {{-- <i class="bx bx-gender"></i> --}}
                            <i class='bx bxs-universal-access'></i>
                            <span class="fw-medium mx-2">Gender:</span>
                            <span>{{ $user->gender }}</span>
                        </li>
                    </ul>
                    <small class="text-muted text-uppercase">Contacts</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-phone"></i>
                            <span class="fw-medium mx-2">Contact:</span>
                            <span>{{ $user->phone_number }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-home"></i>
                            <span class="fw-medium mx-2">Address:</span>
                            <span>{{ $user->address }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-envelope"></i>
                            <span class="fw-medium mx-2">Email:</span>
                            <span>{{ $user->email }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
      
    </div>

@endsection
