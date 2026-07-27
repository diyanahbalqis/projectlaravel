@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Setting')

@section('content')

    <div class="container mt-4">
    <h4> Update Password </h4>

    @session('success')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

    <div class="card- mt-4">
        <div class="card-header"> Change Your Password </div>
        <div class="card-body">
            <br>
            <form method="POST" action="{{ route ('settings.updatePassword') }}">
                @csrf
                <div class="mb-3">
                    <label> Current Password </label>
                    <input type="password" name="current_password" class="form-control" required></input>
                </div>
                <div class=mb-3>
                    <label> New Password </label>
                    <input type="password" name="new_password" class="form-control" required></input>
                </div>
                <div class="mb3">
                    <label> Confirm Password </label>
                    <input type="password" name="new_password_confirmation" class="form-control" required></input>
                </div>
                <br>
                <button type="submit" class="btn btn-primary"> Update password </button>
            </form>
        </div>

    </div>
</div>

@endsection