@extends('layouts.app')

@section('content')
<div class="container my-3">
    <h3 class="mb-4">Leave Management Configuration</h3>

    <!-- Leave Types Card (Top Card) -->
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Leave Types</h5>
            <a href="{{ route('admin.leave-management.leave-types.create') }}" class="btn btn-light btn-sm">+ Create</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Carry Forward?</th>
                        <th>CF %</th>
                        <th>CF Max Days</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveTypes as $index => $type)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $type->name }}</td>
                            <td>{{ $type->carry_forward ? 'Yes' : 'No' }}</td>
                            <td>{{ $type->carry_forward_percentage }}%</td>
                            <td>{{ $type->carry_forward_max_days }}</td>
                            <td>
                                <a href="{{ route('admin.leave-management.leave-types.edit', $type->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leave Configurations Card (Bottom Card) -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Leave Config. (Selectable by staff)</h5>
            <a href="{{ route('admin.leave-management.leave-configs.create') }}" class="btn btn-light btn-sm">+ Create</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Leave Type (Parent)</th>
                        <th>Config Name</th>
                        <th>Rate</th>
                        <th>Notice (Days)</th>
                        <th>Max Days</th>
                        <th>Attachment?</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveConfigs as $index => $config)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $config->leaveType->name }}</td>
                            <td>{{ $config->name }}</td>
                            <td>{{ $config->rate }}</td>
                            <td>{{ $config->notice_period }}</td>
                            <td>{{ $config->max_continuous_days ?: 'Unlimited' }}</td>
                            <td>{{ $config->attachment_required ? 'Yes' : 'No' }}</td>
                            <td>{{ $config->active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('admin.leave-management.leave-configs.edit', $config->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
