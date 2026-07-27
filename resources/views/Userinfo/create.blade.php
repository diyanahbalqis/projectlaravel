@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="py-12">
        <div class="content text-dark">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- REMOVE dark: classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-dark">
                        <h2 class="font-semibold text-xl text-dark leading-tight mb-4">
                            {{ __('User Information Form') }}
                        </h2>

    <form action="{{ route('userinfo.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="text" name="name" placeholder="Name">
    <input type="email" name="email" placeholder="Email">
    <input type="text" name="phone" placeholder="Phone">
    <input type="text" name="address" placeholder="Address">
    <input type="text" name="department" placeholder="Department">
    <select name="approval" required>
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
    <input type="file" name="profile_picture">
    <button type="submit">Save</button>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
