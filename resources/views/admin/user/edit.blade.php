@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center my-4">
            <div class="col-md-12">
                <h1 class="fw-bold text-dark mb-0">User Role - Edit</h1>
            </div>
        </div>


        <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <!-- Username (editable) , email (editable), registered date, last login date, role (editable) -->
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="name">Username</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ $user->email }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="registered_at">Registered At</label>
                                <input type="text" name="registered_at" id="registered_at" class="form-control"
                                    value="{{ $user->created_at }}" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>
                        </div>
                         <!-- Buttons Group (Back & Update) -->
                         <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('admin.user.index', $user->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
