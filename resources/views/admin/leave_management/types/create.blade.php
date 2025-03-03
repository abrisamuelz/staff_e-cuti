@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <strong>Add Leave Type</strong>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.leave-management.leave-types.store') }}">
                @csrf
                <div class="mb-3">
                    <label>Leave Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Carry Forward?</label>
                        <select name="carry_forward" class="form-select">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Carry Forward Percentage (%)</label>
                        <input type="number" name="carry_forward_percentage" class="form-control" value="0">
                    </div>
                </div>

                <div class="mb-3">
                    <label>Carry Forward Max Days</label>
                    <input type="number" name="carry_forward_max_days" class="form-control" value="0">
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
