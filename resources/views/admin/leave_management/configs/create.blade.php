@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <strong>Add Leave Config</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.leave-management.leave-configs.store') }}">
                @csrf
                <div class="mb-3">
                    <label>Config Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Leave Type (Parent)</label>
                    <select name="leave_type_id" class="form-select" required>
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Rate</label>
                        <input type="number" step="0.01" name="rate" class="form-control" value="1">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Notice Period (Days Before)</label>
                        <input type="number" name="notice_period" class="form-control" value="0">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Max Continuous Days</label>
                        <input type="number" name="max_continuous_days" class="form-control" value="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Attachment Required?</label>
                        <select name="attachment_required" class="form-select">
                            <option value="1">Yes</option>
                            <option value="0" selected>No</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Active?</label>
                    <select name="active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('admin.leave-management.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
