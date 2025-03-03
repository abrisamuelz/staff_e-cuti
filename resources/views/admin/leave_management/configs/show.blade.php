@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4">Leave Config Details</h4>

    <table class="table table-bordered">
        <tr>
            <th>Config Name</th>
            <td>{{ $leaveConfig->name }}</td>
        </tr>
        <tr>
            <th>Parent Leave Type</th>
            <td>{{ $leaveConfig->leaveType->name }}</td>
        </tr>
        <tr>
            <th>Rate</th>
            <td>{{ $leaveConfig->rate }}</td>
        </tr>
        <tr>
            <th>Notice Period</th>
            <td>{{ $leaveConfig->notice_period }}</td>
        </tr>
        <tr>
            <th>Max Continuous Days</th>
            <td>{{ $leaveConfig->max_continuous_days ?: 'Unlimited' }}</td>
        </tr>
        <tr>
            <th>Attachment Required?</th>
            <td>{{ $leaveConfig->attachment_required ? 'Yes' : 'No' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $leaveConfig->active ? 'Active' : 'Inactive' }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $leaveConfig->created_at->format('d M Y') }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $leaveConfig->updated_at->format('d M Y') }}</td>
        </tr>
    </table>

    <a href="{{ route('admin.leave-management.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
