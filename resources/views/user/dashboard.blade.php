@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center my-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-dark mb-0">Dashboard</h1>
            </div>
        </div>
        @if ($staff !== null )
            {{-- @dd($staff) --}}
            <!-- Profile Section -->
            <div class="mb-4 row">
                <!-- Profile Card -->
                <div class="col-md-3 mb-3 mb-md-0 p-md-2">
                    <div class="card p-3 text-center position-relative h-100 shadow-sm border-0">
                        <!-- View Detail Button -->
                        <a href="{{ route('staff.show', $staff->id) }}" class="text-secondary position-absolute" 
                            style="top: 10px; right: 10px;">
                            <i class="fas fa-eye"></i>
                        </a>
            
                        @if (isset($staff->profile_image))
                            <img src="{{ asset('storage/' . $staff->profile_image) }}" alt="Profile Image"
                                class="rounded-circle border border-secondary mx-auto d-block"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/default.png') }}" alt="Default Image"
                                class="rounded-circle border border-secondary mx-auto d-block"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @endif
            
                        <h5 class="mt-2">{{ $staff->full_name }}</h5>
                        <p class="text-muted">{{ $staff->email_company }}</p>
                    </div>
                </div>
            
                <!-- Information Card -->
                <div class="col-md-9 p-md-2">
                    <div class="card p-3 h-100 shadow-sm border-0">
                        <p>Started: <strong>{{ $staff->starting_working }}</strong> <strong>({{ $staff->years_of_service }})</strong></p>
                        <p>Leave Taken: <strong>{{ $staff->leave_taken }}</strong> / <strong>{{ $staff->leave_available }}</strong></p>
                        <p>Medical Leave Taken: <strong>{{ $staff->medical_leave_taken }}</strong> / <strong>{{ $staff->medical_leave_available }}</strong></p>
                    </div>
                </div>
            </div>
            

            <!-- Grid Navigation -->
            <div class="row row-cols-1 row-cols-md-3 g-3">
                <div class="col">
                    <a href="#" class="card text-center p-3 shadow-sm border-0">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="System 1" class="mb-2"
                            style="width: 50px; height: 50px;">
                        <h6>System 1</h6>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="card text-center p-3 shadow-sm border-0">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="System 2" class="mb-2"
                            style="width: 50px; height: 50px;">
                        <h6>System 2</h6>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="card text-center p-3 shadow-sm border-0">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="System 3" class="mb-2"
                            style="width: 50px; height: 50px;">
                        <h6>System 3</h6>
                    </a>
                </div>
                <div class="col">
                    <a href="#" class="card text-center p-3 shadow-sm border-0">
                        <img src="https://picsum.photos/seed/picsum/200/300" alt="System 4" class="mb-2"
                            style="width: 50px; height: 50px;">
                        <h6>System 4</h6>
                    </a>
                </div>
                <div class="col">
                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="card text-center p-3 shadow-sm border-0">
                        <i class="fas fa-user-edit fa-2x text-primary"></i>
                        <h6>Edit Profile</h6>
                    </a>
                </div>
            </div>
        @else
            <div class="alert alert-danger">Your account not registered in this system.</div>
        @endif
    </div>
@endsection
