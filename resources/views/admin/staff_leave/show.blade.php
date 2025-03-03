@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Staff Leave Details</h4>
        </div>
        <div class="card-body">
            <h5 class="mb-3"><strong>Staff:</strong> {{ $balance->staff->full_name }}</h5>
            <p><strong>Leave Type:</strong> {{ $balance->leave_type }}</p>
            <p><strong>Total Leaves:</strong> {{ $balance->total_leaves }}</p>
            <p><strong>Used Leaves:</strong> {{ $balance->used_leaves }}</p>
            <p><strong>Carry Forward:</strong> {{ $balance->carry_forward_leaves }}</p>
            <p><strong>Remaining:</strong> {{ $balance->remaining_leaves }}</p>
            <p><strong>Year:</strong> {{ $balance->year }}</p>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-between">
        <a href="{{ route('admin.staff-leaves.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.staff-leaves.edit', $balance->id) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection
