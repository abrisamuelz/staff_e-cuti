@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Staff Leave Balance</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.staff-leaves.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Staff Name</label>
                    <select name="staff_id" class="form-select" required>
                        <option value="" disabled selected>Select Staff</option>
                        @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Leave Type</label>
                    <input type="text" name="leave_type" class="form-control" placeholder="Annual Leave, Medical Leave, etc." required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Leaves</label>
                        <input type="number" name="total_leaves" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Carry Forward</label>
                        <input type="number" name="carry_forward_leaves" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" value="{{ date('Y') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.staff-leaves.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Leave Balance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
