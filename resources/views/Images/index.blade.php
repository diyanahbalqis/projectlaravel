@extends('layouts.app') 

@section('File Upload')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
    <h1>Upload an Image</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('images.upload') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        <div class="form-group">
            <label for="image">Select Image</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Upload</button>
        <a href="{{ route('userinfo.index') }}" class="btn btn-danger"><i class="fa-solid fa-backward-step"></i></a>
    </form>

    <h2>Uploaded Images</h2>
    <div class="row">
        @forelse($images as $image)
            <div class="col-md-4 mb-3">
                <img src="{{ asset('storage/' . $image->path) }}" alt="Uploaded Image" class="img-fluid">
            </div>

            <div class="col-md-1 mb-4">
                <form action="{{ route('images.destroy', $image->id) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this image?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger w-100"><i class="fa-solid fa-box-archive"></i></button>
                </form>
            </div>
        @empty
            <p>No files uploaded yet.</p>
        @endforelse
    </div>
</div>
</body>
</html>
@endsection