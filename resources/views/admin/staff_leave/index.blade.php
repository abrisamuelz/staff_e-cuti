@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Manage Staff Leave Balances</h2>
        <a href="{{ route('admin.staff-leaves.create') }}" class="btn btn-primary">+ Add Leave Balance</a>
    </div>

    <form method="GET" action="{{ route('admin.staff-leaves.index') }}" class="mb-3">
        <label for="year">Filter by Year:</label>
        <select name="year" id="year" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
            <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>
    </form>

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Staff</th>
                <th>Leave Type</th>
                <th>Total</th>
                <th>Used</th>
                <th>Carry Forward</th>
                <th>Remaining</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($balances as $balance)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $balance->staff->full_name }}</td>
                <td>{{ $balance->leave_type }}</td>
                <td>{{ $balance->total_leaves }}</td>
                <td>{{ $balance->used_leaves }}</td>
                <td>{{ $balance->carry_forward_leaves }}</td>
                <td>{{ $balance->remaining_leaves }}</td>
                <td>
                    <a href="{{ route('admin.staff-leaves.show', $balance->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('admin.staff-leaves.edit', $balance->id) }}" class="btn btn-warning btn-sm">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
