<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage; // ✅ Import the File model
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Show uploaded files
     */
    public function index()
    {
        $files = File::latest()->get();
        return view('file.index', compact('files'));
    }

    /**
     * Store uploaded file
     */
    public function store(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:2048',
    ]);

    $file = $request->file('file');
    $path = $file->store('uploads', 'public');

    File::create([
        'name' => $file->getClientOriginalName(),
        'path' => $path,
        'mime_type' => $file->getClientMimeType(),
        'size' => $file->getSize(),
        'user_id' => auth()->id(),
    ]);

    return back()->with('success', 'uploaded successfully.');
}
        

    public function destroy($id)
    {
        $file = File::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }

        // Delete record from database
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}
