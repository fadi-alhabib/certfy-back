<?php

namespace App\Http\Controllers;

use App\Http\Services\ImageServiceInterface;
use App\Models\Family;

use Illuminate\Http\Request;

class FamilyController extends Controller
{
    public function __construct(private readonly ImageServiceInterface $imageService) {}
    public function index()
    {
        $families = Family::all();
        return response()->json($families);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|mimes:ttf',
        ]);
        $family = new Family(["name" => $data['name']]);
        $family->path = $this->imageService->uploadImage($request->file("file"), "/font-families");
        $family->save();
        return response()->json($family, 201);
    }

    public function show($id)
    {
        $family = Family::findOrFail($id);
        return response()->json($family);
    }

    public function update(Request $request, $id)
    {
        $family = Family::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'path' => 'sometimes|nullable|string|max:255',
        ]);

        $family->update($data);
        return response()->json($family);
    }

    public function destroy($id)
    {
        $family = Family::findOrFail($id);
        $family->delete();
        return response()->json(null, 204);
    }
}
