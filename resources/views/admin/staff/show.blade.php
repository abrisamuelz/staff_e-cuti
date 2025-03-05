@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- <h1 class="mb-4">Edit Staff Details</h1> --}}
        <div class="row align-items-center my-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-dark mb-0">Staff Details - Show</h1>
            </div>
        </div>
        <div class="row mb-3">
            <!-- Details Card -->
            <div class="col-md-4 px-1">
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
                                        value="{{ old('full_name', strtoupper($staff->full_name)) }}" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nric" class="form-label">NRIC</label>
                                    <input type="text" name="nric" id="nric" class="form-control"
                                        value="{{ old('nric', $staff->nric) }}" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email_personal" class="form-label">Personal Email</label>
                                    <input type="email" name="email_personal" id="email_personal" class="form-control"
                                        value="{{ old('email_personal', $staff->email_personal ?? '-') }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="email_company" class="form-label">Company Email</label>
                                    <input type="email" name="email_company" id="email_company" class="form-control"
                                        value="{{ old('email_company', $staff->email_company ?? '-') }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" id="phone_number" class="form-control"
                                        value="{{ old('phone_number', $staff->phone_number ?? '-') }}" readonly>
                                </div>
                            </div>

                            <!-- Work Tab -->
                            <div class="tab-pane fade" id="work" role="tabpanel" aria-labelledby="work-tab">
                                <div class="mb-3">
                                    <label for="starting_date" class="form-label">Starting Date</label>
                                    <input type="date" name="starting_date" id="starting_date" class="form-control"
                                        value="{{ old('starting_date', $staff->starting_date) }}" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="work_type" class="form-label">Work Type</label>
                                    @if ($staff->work_type === 'full_time')
                                        <input type="text" name="work_type" id="work_type" class="form-control"
                                            value="Full Time" readonly>
                                    @elseif ($staff->work_type === 'part_time')
                                        <input type="text" name="work_type" id="work_type" class="form-control"
                                            value="Part Time" readonly>
                                    @elseif ($staff->work_type === 'contract')
                                        <input type="text" name="work_type" id="work_type" class="form-control"
                                            value="Contract" readonly>
                                    @elseif ($staff->work_type === 'intern')
                                        <input type="text" name="work_type" id="work_type" class="form-control"
                                            value="Intern" readonly>
                                    @elseif ($staff->work_type === 'terminated')
                                        <input type="text" name="work_type" id="work_type" class="form-control"
                                            value="Terminated" readonly>
                                    @endif
                                </div>

                                <div id="intern-details"
                                    style="display: {{ $staff->work_type === 'intern' ? 'block' : 'none' }}">
                                    {{-- <h5>Intern Details</h5> --}}
                                    <div class="mb-3">
                                        <label for="university" class="form-label">University</label>
                                        <input type="text" name="university" id="university" class="form-control"
                                            value="{{ old('university', $staff->internDetails->university ?? '-') }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date_start" class="form-label">Internship Start Date</label>
                                        <input type="date" name="date_start" id="date_start" class="form-control"
                                            value="{{ old('date_start', $staff->internDetails->date_start ?? '-') }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="date_end" class="form-label">Internship End Date</label>
                                        <input type="date" name="date_end" id="date_end" class="form-control"
                                            value="{{ old('date_end', $staff->internDetails->date_end ?? '-') }}" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="supervisor_name" class="form-label">Supervisor</label>
                                        @if ($staff->internDetails === null)
                                            <input type="text" name="supervisor_name" id="supervisor_name"
                                                class="form-control" value="No supervisor assigned" readonly>
                                        @else
                                            <input type="text" name="supervisor_name" id="supervisor_name"
                                                class="form-control"
                                                value="{{ $staff->internDetails->supervisor_name ?? '-' }}" readonly>
                                        @endif
                                    </div>
                                    <div class="mb-3">
                                        <label for="university_supervisor" class="form-label">University
                                            Supervisor</label>
                                        <input type="text" name="university_supervisor" id="university_supervisor"
                                            class="form-control"
                                            value="{{ old('university_supervisor', $staff->internDetails->university_supervisor ?? '-') }}"
                                            readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="university_supervisor_contact" class="form-label">University
                                            Supervisor Contact</label>
                                        <input type="text" name="university_supervisor_contact"
                                            id="university_supervisor_contact" class="form-control"
                                            value="{{ old('university_supervisor_contact', $staff->internDetails->university_supervisor_contact ?? '-') }}"
                                            readonly>
                                    </div>
                                    {{-- additional details --}}
                                    <div class="mb-3">
                                        <label for="other_details" class="form-label">Additional Details</label>
                                        <textarea name="other_details" id="other_details" class="form-control" readonly>{{ $staff->internDetails->other_details ?? '-' }}</textarea>
                                    </div>
                                </div>

                                {{-- if work_type == terminated , show reason --}}
                                <div id="terminated-details"
                                    style="display: {{ $staff->work_type === 'terminated' ? 'block' : 'none' }}">
                                    {{-- <h5>Termination Details</h5> --}}
                                    <div class="mb-3">
                                        <label for="reason" class="form-label">Termination Reason</label>
                                        <textarea name="reason" id="reason" class="form-control">
                                                @if ($staff->work_type === 'terminated')
{{ $changeLogs->where('work_type', 'terminated')->last()->reason ?? '' }}
@else
{{ '' }}
@endif
                                            </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Leave config details -->
            <div class="col-md-8 px-1">
                <div class="card">
                    <div class="card-header">Leave Configuration</div>
                    <div class="card-body">
                        @if ($staff_leave_balance->count() > 0)
                            @php
                                $groupedLeaveBalance = $staff_leave_balance->groupBy('year');
                                $currentYear = date('Y');
                                $selectedYear = request()->get('year', $currentYear);
                                $selectedYear = array_key_exists($selectedYear, $groupedLeaveBalance->toArray())
                                    ? $selectedYear
                                    : $groupedLeaveBalance->keys()->first();
                                $currentLeaveBalance = $groupedLeaveBalance[$selectedYear] ?? collect([]);
                            @endphp

                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <select name="year" id="year" class="form-select"
                                    onchange="reloadWithYear(this.value)">
                                    @foreach ($groupedLeaveBalance as $year => $leaveBalance)
                                        <option value="{{ $year }}"
                                            @if ($year == $selectedYear) selected @endif>{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @foreach ($currentLeaveBalance as $leave)
                                <div class="mb-3">
                                    <label class="form-label">{{ $leave->leaveType->name }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Annual Limit</span>
                                        <input type="number" class="form-control" value="{{ $leave->annual_limit }}"
                                            readonly>
                                        <span class="input-group-text">Taken</span>
                                        <input type="number" class="form-control" value="{{ $leave->taken }}" readonly>
                                        <span class="input-group-text">Carry Forward</span>
                                        <input type="number" class="form-control"
                                            value="{{ $leave->carry_forward_leaves }}" readonly>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-danger" role="alert">
                                No Leave Configuration found for this staff.
                            </div>
                        @endif

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary"
                                onclick="window.location.href='{{ route('admin.staff.edit', $staff->id) }}'">Edit</button>
                        </div>
                    </div>
                </div>
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

        function showInternDetails() {
            internDetails.style.display = 'block';
            terminatedDetails.style.display = 'none';
        }

        function showTerminatedDetails() {
            terminatedDetails.style.display = 'block';
            internDetails.style.display = 'none';
        }

        // Show the relevant details when the page loads
        if (workTypeSelect.value === 'intern') {
            showInternDetails();
        } else if (workTypeSelect.value === 'terminated') {
            showTerminatedDetails();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.leave-toggle').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const leaveType = checkbox.getAttribute('data-leavetype');
                    const container = document.getElementById(leaveType + '_container');
                    const disabledLabel = document.getElementById(leaveType + '_disabled_label');

                    if (checkbox.checked) {
                        container.style.display = 'block';
                        disabledLabel.style.display = 'none';
                    } else {
                        container.style.display = 'none';
                        disabledLabel.style.display = 'block';
                    }
                });
            });
        });

        function reloadWithYear(year) {
            const url = new URL(window.location.href);
            url.searchParams.set('year', year);
            window.location.href = url.toString();
        }
    </script>
@endsection
