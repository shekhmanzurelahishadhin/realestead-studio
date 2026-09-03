<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
     * Accepts a multipart "image" file, saves it to the public disk under
     * storage/app/public/images/uploads, and returns its public URL. Any
     * admin form (project, property, service, leadership photo, …) can call
     * this first, then save the returned `url` on the record itself.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:8192'], // 8MB
        ]);

        $path = $request->file('image')->store('images/uploads', 'public');

        return response()->json([
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ], 201);
    }
}
