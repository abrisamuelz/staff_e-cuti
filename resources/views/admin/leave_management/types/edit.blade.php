@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <strong>Edit Leave Type</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.leave-management.leave-types.update', $leaveType->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Leave Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $leaveType->name }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Carry Forward?</label>
                        <select name="carry_forward" class="form-select">
                            <option value="1" {{ $leaveType->carry_forward ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$leaveType->carry_forward ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Carry Forward Percentage (%)</label>
                        <input type="number" name="carry_forward_percentage" class="form-control" value="{{ $leaveType->carry_forward_percentage }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Carry Forward Max Days</label>
                    <input type="number" name="carry_forward_max_days" class="form-control" value="{{ $leaveType->carry_forward_max_days }}">
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-warning">Update</button>
                    <a href="{{ route('admin.leave-management.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
