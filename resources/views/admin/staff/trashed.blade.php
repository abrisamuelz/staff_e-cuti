@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Trashed Staff</h1>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-primary mb-3">Back to Staff List</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>NRIC</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staff as $person)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $person->full_name }}</td>
                    <td>{{ $person->nric }}</td>
                    <td>{{ $person->deleted_at }}</td>
                    <td>
                        <form action="{{ route('admin.staff.restore', $person->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm">Restore</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No trashed staff found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $staff->links() }}
</div>
@endsection
