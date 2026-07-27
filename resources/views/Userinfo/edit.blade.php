@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Edit Page')
@section('content')
<form action="{{ route('userinfo.update', $users->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <input type="text" name="staff_id" placeholder="Staff Id" value="{{ old('staff_id', $users->staff_id) }}">
    <input type="text" name="name" placeholder="Name" value="{{ old('name', $users->name) }}">
    <input type="email" name="email" placeholder="Email" value="{{ old('email', $users->email) }}">
    <input type="text" name="phone" placeholder="Phone" value="{{ old('phone', $users->phone ?? '') }}">
    <!-- <input type="text" name="address" placeholder="Address" value="{{ old('address', $users->address ?? '') }}"> -->
    <input type="text" name="department" placeholder="Department" value="{{ old('department', $users->department ?? '') }}">

    <!-- Approval Dropdown -->
    <select name="approval" class="form-select form-select-sm">
        <option value="0" {{ old('approval', $users->approval) == 0 ? 'selected' : '' }}>Pending</option>
        <option value="1" {{ old('approval', $users->approval) == 1 ? 'selected' : '' }}>Approved</option>
        <option value="2" {{ old('approval', $users->approval) == 2 ? 'selected' : '' }}>Rejected</option>
    </select>

    <input type="file" name="profile_picture">

    <button type="submit">Update</button>
</form>

@endsection