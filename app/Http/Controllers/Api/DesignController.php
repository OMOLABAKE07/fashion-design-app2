<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Design;
use App\Models\DesignPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DesignController extends Controller
{
    public function getAllDesigns()
    {
        return response()->json(Design::with('customer')->get(), 200);
    }

    public function createDesign(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|string',
            'photos.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $design = Design::create($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('designs', 'public');
                $design->photos()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Design created successfully',
            'data' => $design->load('photos'),
        ], 201);
    }

    public function getDesign($id)
    {
        return response()->json(
            Design::with(['customer', 'photos'])->findOrFail($id),
            200
        );
    }

    public function updateDesign(Request $request, $id)
    {
        $design = Design::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'nullable|string',
            'photos.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $design->update($validated);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $path = $file->store('designs', 'public');
                $design->photos()->create([
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return response()->json([
            'message' => 'Design updated successfully',
            'data' => $design->load('photos'),
        ], 200);
    }

    public function deleteDesignPhoto($photoId)
    {
        $photo = DesignPhoto::findOrFail($photoId);

        if (Storage::disk('public')->exists($photo->file_path)) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return response()->json(['message' => 'Photo deleted successfully'], 200);
    }

    public function deleteDesign($id)
    {
        Design::findOrFail($id)->delete();
        return response()->json(['message' => 'Design deleted'], 200);
    }
}
