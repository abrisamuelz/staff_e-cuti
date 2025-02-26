@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row align-items-center my-4">
        <div class="col-md-12">
            <h1 class="fw-bold text-dark mb-0">User Management</h1>
        </div>
    </div>

    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.staff.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by Name or Email" value="{{ request('search') }}">
            <button class="btn btn-secondary" type="submit">Search</button>
        </div>
    </form>

    <!-- Staff Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Registered Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Registered At</th>
                <th>Last Login</th>
                {{-- <th>Actions</th> --}}
            </tr>
        </thead>
        <tbody>
            @forelse ($staff as $person)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $person->name }}</td>
                    <td>{{ $person->email }}</td>
                    <td>{{ ucfirst($person->role) }}</td>
                    <td>{{ $person->created_at->diffForHumans() }} ({{ $person->created_at->format('d M, Y') }})</td>
                    <td>{{ $person->updated_at->diffForHumans() }} ({{ $person->updated_at->format('d M, Y') }})</td>
                    {{-- <td>
                        @if($person->id != auth()->user()->id)
                            <a href="{{ route('admin.user.edit', $person->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                        @else
                            -
                        @endif
                    </td> --}}
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No User found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $staff->appends(['search' => request('search')])->links() }}
</div>
@endsection
