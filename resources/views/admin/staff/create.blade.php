@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center my-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-dark mb-0">Staff Details - Create</h1>
            </div>
        </div>
        <div class="row">
            <!-- Profile Image -->
            <div class="col-md-4">
                <div class="card p-3 d-flex align-items-center justify-content-center"
                    style="height: 100%; text-align: center;">
                    <div>
                        <!-- Profile Image -->
                        <img id="profileImagePreview" src="{{ asset('storage/default.png') }}"
                            alt="Default Image" class="rounded-circle mb-3 border border-secondary"
                            style="width: 150px; height: 150px; object-fit: cover;">

                        <!-- File Upload -->
                        <label for="profile_image" class="btn btn-outline-primary btn-sm mt-3">
                            Upload Profile Image
                            <input type="file" name="profile_image" id="profile_image" class="d-none">
                        </label>
                        @error('profile_image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="col-md-8">
                <form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="staffTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="personal-tab" data-bs-toggle="tab" href="#personal"
                                        role="tab" aria-controls="personal" aria-selected="true">Personal Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="work-tab" data-bs-toggle="tab" href="#work" role="tab"
                                        aria-controls="work" aria-selected="false">Work</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="staffTabContent">
                                <!-- Personal Details Tab -->
                                <div class="tab-pane fade show active" id="personal" role="tabpanel"
                                    aria-labelledby="personal-tab">
                                    <div class="mb-3">
                                        <label for="full_name" class="form-label">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="form-control"
                                            value="{{ old('full_name') }}" required>
                                        @error('full_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="nric" class="form-label">NRIC</label>
                                        <input type="text" name="nric" id="nric" class="form-control"
                                            maxlength="12" minlength="12" value="{{ old('nric') }}" required>
                                        @error('nric')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_personal" class="form-label">Personal Email</label>
                                        <input type="email" name="email_personal" id="email_personal" class="form-control"
                                            value="{{ old('email_personal') }}">
                                        @error('email_personal')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="email_company" class="form-label">Company Email</label>
                                        <input type="email" name="email_company" id="email_company" class="form-control"
                                            value="{{ old('email_company') }}">
                                        @error('email_company')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" id="phone_number" class="form-control"
                                            maxlength="14" minlength="10" value="{{ old('phone_number') }}">
                                        @error('phone_number')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Work Tab -->
                                <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                    <div class="mb-3">
                                        <label for="starting_date" class="form-label">Starting Date</label>
                                        <input type="date" name="starting_date" id="starting_date"
                                            class="form-control" value="{{ old('starting_date') }}" required>
                                        @error('starting_date')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="work_type" class="form-label">Work Type</label>
                                        <select name="work_type" id="work_type" class="form-control">
                                            <option value="full_time"
                                                {{ old('work_type') === 'full_time' ? 'selected' : '' }}>Full Time</option>
                                            <option value="part_time"
                                                {{ old('work_type') === 'part_time' ? 'selected' : '' }}>Part Time</option>
                                            <option value="contract"
                                                {{ old('work_type') === 'contract' ? 'selected' : '' }}>Contract</option>
                                            <option value="intern" {{ old('work_type') === 'intern' ? 'selected' : '' }}>
                                                Intern</option>
                                            <option value="terminated"
                                                {{ old('work_type') === 'terminated' ? 'selected' : '' }}>Terminated
                                            </option>
                                        </select>
                                        @error('work_type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <!-- Intern Details
                                                'university' => 'required|string|max:255',
                                                'date_start' => 'required|date',
                                                'date_end' => 'required|date|after_or_equal:date_start',
                                                'supervisor_id' => 'nullable|exists:staff,id',
                                                'university_supervisor' => 'required|string|max:255',
                                                'university_supervisor_contact' => 'required|string|max:20',
                                            -->
                                    <div id="intern-details" style="display: none;">
                                        <div class="mb-3">
                                            <label for="university" class="form-label">University</label>
                                            <input type="text" name="university" id="university" class="form-control"
                                                value="{{ old('university') }}">
                                            @error('university')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Internship Start Date --}}
                                        <div class="mb-3">
                                            <label for="internship_start_date" class="form-label">Internship Start
                                                Date</label>
                                            <input type="date" name="internship_start_date" id="internship_start_date"
                                                class="form-control" value="{{ old('internship_start_date') }}">
                                            @error('internship_start_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Internship End Date --}}
                                        <div class="mb-3">
                                            <label for="internship_end_date" class="form-label">Internship End
                                                Date</label>
                                            <input type="date" name="internship_end_date" id="internship_end_date"
                                                class="form-control" value="{{ old('internship_end_date') }}">
                                            @error('internship_end_date')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Supervisor --}}
                                        <div class="mb-3">
                                            <label for="supervisor_id" class="form-label">Company Supervisor</label>
                                            <select name="supervisor_id" id="supervisor_id" class="form-control">
                                                <option value="">Select Supervisor</option>
                                                @foreach ($staff as $person)
                                                    <option value="{{ $person->id }}"
                                                        {{ old('supervisor_id') == $person->id ? 'selected' : '' }}>
                                                        {{ $person->full_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supervisor_id')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- University Supervisor --}}
                                        <div class="mb-3">
                                            <label for="university_supervisor" class="form-label">University
                                                Supervisor</label>
                                            <input type="text" name="university_supervisor" id="university_supervisor"
                                                class="form-control" value="{{ old('university_supervisor') }}">
                                            @error('university_supervisor')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- University Supervisor Contact --}}
                                        <div class="mb-3">
                                            <label for="university_supervisor_contact" class="form-label">University
                                                Supervisor Contact</label>
                                            <input type="text" name="university_supervisor_contact"
                                                id="university_supervisor_contact" class="form-control"
                                                value="{{ old('university_supervisor_contact') }}">
                                            @error('university_supervisor_contact')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        {{-- additional details --}}
                                        <div class="mb-3">
                                            <label for="additional_details" class="form-label">Additional Details</label>
                                            <textarea name="additional_details" id="additional_details" class="form-control" rows="3">{{ old('additional_details') }}</textarea>
                                            @error('additional_details')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Create Staff</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const workTypeSelect = document.getElementById('work_type');
        const internDetails = document.getElementById('intern-details');
        const terminatedDetails = document.getElementById('terminated-details');

        workTypeSelect.addEventListener('change', function() {
            if (this.value === 'intern') {
                internDetails.style.display = 'block';
                terminatedDetails.style.display = 'none';
            } else if (this.value === 'terminated') {
                terminatedDetails.style.display = 'block';
                internDetails.style.display = 'none';
            } else {
                internDetails.style.display = 'none';
                terminatedDetails.style.display = 'none';
            }
        });
    </script>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('profileImagePreview');
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('profileImagePreview');
                preview.src = URL.createObjectURL(file);
            }
        });
    </script>
@endsection
