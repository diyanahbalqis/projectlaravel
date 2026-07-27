<!DOCTYPE html>
<html>
<head>
    <title>Edit User Details</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">

</head>
<body class="container py-5">

    <h2>Edit User Details</h2>

    @session('success')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession

    <form action="{{ route('userinfo.update', $model->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="{{ $model->name }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" value="{{ $model->email }}" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $model->phone }}" class="form-control">
    </div>

    <div class="mb-3">
        <label>Address</label>
        <input type="text" name="address" value="{{ $model->address }}" class="form-control">
    </div>
    <div>
    <button type="submit" class="btn btn-primary">
        <i class="fa-regular fa-square-caret-up"></i>
    </button>
    <a href="{{ route('userinfo.index') }}" class="btn btn-danger">Back</a>
</div>
</form>


</body>
</html>
