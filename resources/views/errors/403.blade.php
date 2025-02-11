@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="text-danger">403 - Forbidden</h1>
    <p>You are not authorized to perform this action.</p>
    <a href="{{ url('/') }}" class="btn btn-primary">Go Back to Dashboard</a>
</div>
@endsection