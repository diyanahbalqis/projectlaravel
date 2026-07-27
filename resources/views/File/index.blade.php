@extends('layouts.app')

@section('title', 'File Upload')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" />

<div class="container mt-5">
    <div class="card">
        <h3 class="card-header p-3">
            <i class="fa fa-star"></i> Laravel File Upload Example
        </h3>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">File:</label>
                    <input type="file" 
                           name="file" 
                           class="form-control @error('file') is-invalid @enderror">

                    @error('file')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> Upload
                    </button>
                    <a href="{{ route('userinfo.index') }}" class="btn btn-danger">
                        <i class="fa-solid fa-reply"></i> 
                    </a>
                </div>
            </form>

            <hr>

            <h4 class="mb-3">Uploaded Files</h4>

            <div class="row">
                @forelse($files as $file)
                    <div class="col-md-4 mb-3">
                        <a href="{{ asset('storage/' . $file->path) }}" 
                           target="_blank" 
                           class="btn btn-outline-secondary w-100 mb-2">
                           📁 {{ basename($file->path) }}
                        </a>

                        <form action="{{ route('file.destroy', $file->id) }}" 
                              method="POST" 
                              onsubmit="return confirm('Delete this file?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger w-100">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p>No files uploaded yet.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@if(Session::has('message'))
<script>
    toastr.options = {
        "progressBar": true,
    }
    toastr.success("{{ Session::get('message') }}");
</script>
@endif

@endsection
