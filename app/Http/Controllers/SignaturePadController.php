<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\SignaturePad;

class SignaturePadController extends Controller
{
    public function index()
    {
        return view('signature.index');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'signature_data' => 'required|string',
        ]);

        $signatureData = $request->signature_data;

        // Determine extension
        [$mime, $imgData] = explode(';base64,', $signatureData);
        $extension = str_contains($mime,'png') ? 'png' : 'jpg';
        $fileName = 'signatures/'.Str::uuid().'.'.$extension;

        // Save to storage
        Storage::disk('public')->put($fileName, base64_decode($imgData));

        // Save to DB
        SignaturePad::create([
            'file_path' => $fileName,
            'type' => 'drawn',
        ]);

        return response()->json([
            'success' => true,
            'file_path' => Storage::url($fileName)
        ]);
    }
}