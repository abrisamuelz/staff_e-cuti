@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <strong>Edit Leave Config</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.leave-management.leave-configs.update', $leaveConfig->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label>Config Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $leaveConfig->name }}" required>
                </div>
                <div class="mb-3">
                    <label>Leave Type (Parent)</label>
                    <select name="leave_type_id" class="form-select" required>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}" {{ $leaveConfig->leave_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Rate</label>
                        <input type="number" step="0.01" name="rate" class="form-control" value="{{ $leaveConfig->rate }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Notice Period (Days Before)</label>
                        <input type="number" name="notice_period" class="form-control" value="{{ $leaveConfig->notice_period }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Max Continuous Days</label>
                        <input type="number" name="max_continuous_days" class="form-control" value="{{ $leaveConfig->max_continuous_days }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Attachment Required?</label>
                        <select name="attachment_required" class="form-select">
                            <option value="1" {{ $leaveConfig->attachment_required ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ !$leaveConfig->attachment_required ? 'selected' : '' }}>No</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Active?</label>
                    <select name="active" class="form-select">
                        <option value="1" {{ $leaveConfig->active ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ !$leaveConfig->active ? 'selected' : '' }}>Inactive</option>
                    </select>
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
