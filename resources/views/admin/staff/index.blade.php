@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center my-4">
        <div class="col-md-12">
            <h1 class="fw-bold text-dark mb-0">Staff Management</h1>
        </div>
    </div>
    
    <form method="POST" action="{{ route('admin.staff.sync') }}" class="mb-3">
        @csrf
        <button class="btn btn-primary" type="submit">Sync Staff Table</button>
    </form>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.staff.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name or NRIC" value="{{ request('search') }}">
            <button class="btn btn-secondary" type="submit">Search</button>
        </div>
    </form>

    <!-- Staff Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>NRIC</th>
                <th>Work Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staff as $person)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- capitalize each words --}}
                    <td>{{ strtoupper($person->full_name) }}</td>
                    <td>{{ $person->nric }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $person->work_type)) }}</td>
                    <td>
                        <a href="{{ route('admin.staff.show', $person->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No staff found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $staff->appends(['search' => request('search')])->links() }}
</div>
@endsection
