@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-warning text-white">
            <h4 class="mb-0">Edit Staff Leave Balance</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.staff-leaves.update', $balance->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Staff Name</label>
                    <input type="text" class="form-control" value="{{ $balance->staff->full_name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label">Leave Type</label>
                    <input type="text" class="form-control" value="{{ $balance->leave_type }}" disabled>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Total Leaves</label>
                        <input type="number" name="total_leaves" class="form-control" value="{{ $balance->total_leaves }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Used Leaves</label>
                        <input type="number" name="used_leaves" class="form-control" value="{{ $balance->used_leaves }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Carry Forward</label>
                        <input type="number" name="carry_forward_leaves" class="form-control" value="{{ $balance->carry_forward_leaves }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.staff-leaves.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Leave Balance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
