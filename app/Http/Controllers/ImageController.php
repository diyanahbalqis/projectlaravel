<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
    $images = Image::latest()->get();
    return view('images.index', compact('images'));
    }

    public function upload(Request $request)
    {
    // Validate the uploaded file
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
    ]);

    // Store the image in the 'public' disk
    $path = $request->file('image')->store('images', 'public');

    // Save the image path to the database
    $image = new Image();
    $image->path = $path;
    $image->save();

    // Redirect back with a success message
    return redirect()->route('images.index')->with('success', 'Image uploaded successfully!');
    }
    
    public function destroy($id)
    {
        $image = Image::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete record from database
        $image->delete();

        return redirect()->route('images.index')->with('success', 'Image deleted successfully.');
    }
}