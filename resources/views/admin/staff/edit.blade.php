@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center my-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-dark mb-0">Staff Details - Edit</h1>
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
                        @php
                            $groupedLeaveBalance = $staff_leave_balance->groupBy('year');
                            $currentYear = date('Y');
                            $selectedYear = request()->get('year', $currentYear);
                            $selectedYear = array_key_exists($selectedYear, $groupedLeaveBalance->toArray())
                                ? $selectedYear
                                : $currentYear;

                            // Load leave balance for selected year, fallback to empty collection if year not found
                            $currentLeaveBalance = $groupedLeaveBalance[$selectedYear] ?? collect();

                            // Reformat for quick lookup (leave_type_id => balance)
                            $leaveBalanceMap = $currentLeaveBalance->keyBy('leave_type_id');
                        @endphp

                        <div class="mb-3">
                            <label for="year" class="form-label">Year</label>
                            <select name="year" id="year" class="form-select"
                                onchange="reloadWithYear(this.value)">
                                @for ($i = date('Y') - 1; $i <= date('Y') + 1; $i++)
                                    <option value="{{ $i }}" @if ($i == $current_year) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        @foreach ($leave_types as $leaveType)
                            @php
                                $leaveTypeKey = 'leave_type_' . $leaveType->id;
                                $leaveBalance = $current_leave_balance[$leaveType->id] ?? null;
                                $isEnabled = !is_null($leaveBalance);
                            @endphp

                            <div class="mb-3 leave-type-row" data-leavetype="{{ $leaveType->id }}">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input leave-toggle me-2"
                                        id="{{ $leaveTypeKey }}_enabled" @if ($isEnabled) checked @endif>

                                    <label class="form-label mb-0">{{ $leaveType->name }}</label>
                                </div>

                                <div class="leave-inputs" style="{{ !$isEnabled ? 'display: none;' : '' }}">
                                    <div class="row mt-1">
                                        <div class="col-4">
                                            <label class="form-label">Annual Limit</label>
                                            <input type="number" class="form-control p-1"
                                                name="leave[{{ $leaveType->id }}][annual_limit]"
                                                value="{{ $leaveBalance->annual_limit ?? 0 }}">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Taken</label>
                                            <input type="number" class="form-control p-1"
                                                name="leave[{{ $leaveType->id }}][taken]"
                                                value="{{ $leaveBalance->taken ?? 0 }}">
                                        </div>
                                        <div class="col-4">
                                            <label class="form-label">Carry Forward</label>
                                            <input type="number" class="form-control p-1"
                                                name="leave[{{ $leaveType->id }}][carry_forward_leaves]"
                                                value="{{ $leaveBalance->carry_forward_leaves ?? 0 }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-muted leave-disabled-alert"
                                    style="{{ $isEnabled ? 'display: none;' : '' }}">
                                    <div class="alert alert-secondary p-3 mt-3">This leave type is disabled for this staff.
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-primary" onclick="submitLeaveForm()">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.staff.update', $staff->id) }}" method="POST" id="staffForm-leaveupdate">
            @csrf
            @method('PUT')
            <input type="hidden" name="data" id="data">
            <input type="hidden" name="year" value="{{ $selectedYear }}">
        </form>
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

        function reloadWithYear(year) {
            const url = new URL(window.location.href);
            url.searchParams.set('year', year);
            window.location.href = url.toString();
        }

        document.querySelectorAll('.leave-toggle').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const parent = this.closest('.leave-type-row');
                const inputs = parent.querySelector('.leave-inputs');
                const alert = parent.querySelector('.leave-disabled-alert');

                if (this.checked) {
                    inputs.style.display = '';
                    alert.style.display = 'none';
                } else {
                    inputs.style.display = 'none';
                    alert.style.display = '';
                }
            });
        });

        function submitLeaveForm() {
            const data = {
                year: document.getElementById('year').value,
                staff_id: {{ $staff->id }},
                leave_records: []
            };

            document.querySelectorAll('.leave-type-row').forEach(row => {
                const leaveTypeID = row.dataset.leavetype;
                const isEnabled = row.querySelector('.leave-toggle').checked;

                const annualLimit = row.querySelector(`[name="leave[${leaveTypeID}][annual_limit]"]`)?.value || 0;
                const taken = row.querySelector(`[name="leave[${leaveTypeID}][taken]"]`)?.value || 0;
                const carryForward = row.querySelector(`[name="leave[${leaveTypeID}][carry_forward_leaves]"]`)
                    ?.value || 0;

                data.leave_records.push({
                    leave_type_id: leaveTypeID,
                    annual_limit: annualLimit,
                    taken: taken,
                    carry_forward_leaves: carryForward,
                    enabled: isEnabled
                });
            });

            document.getElementById('data').value = JSON.stringify(data);
            document.getElementById('staffForm-leaveupdate').submit();
        }
    </script>
@endsection
