<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Store the uploaded file
        if ($request->file('image')) {
            $path = $request->file('image')->store('images', 'public');

            // Save the file path to the database
            $image = new Image();
            $image->filepath = $path;
            $image->save();
            return redirect()->route('images.index')->with('success', 'Image uploaded successfully.');
        }
    }

    public function index()
    {
        // Get all the images from the database
        $images = Image::all();
        return view('upload', compact('images'));
    }
}