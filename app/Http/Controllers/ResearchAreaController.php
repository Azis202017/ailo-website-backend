<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ResearchArea;
use Illuminate\Http\Request;

class ResearchAreaController extends Controller
{
    public function index(Request $request)
    {
        $data = ResearchArea::with(['publications'])->get();

        $research = $data->map(function ($research_data) {
            $research_data->foto_url = asset('foto/' . $research_data->foto);
            $research_data->icon_url = asset('icon/' . $research_data->icon);

            $research_data->publications->map(function ($publication) {
                $publication->foto_url = asset('research/' . $publication->foto);

                return $publication;
            });

            return $research_data;
        });

        return response()->json([
            'data' => $research,
        ]);
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'icon' => 'required|image|mimes:jpg,png,jpeg,gif',
                'foto' => 'required|image|mimes:jpg,png,jpeg,gif',


            ]);

            $uploadedFileIcon = $request->file('icon');
            $imageNameIcon = uniqid() . '.' . $uploadedFileIcon->getClientOriginalExtension();

            $uploadedFileIcon->move(public_path('icon'), $imageNameIcon);
            $uploadedFile = $request->file('foto');
            $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

            // Move the uploaded file to the public/image directory with the new name
            $uploadedFile->move(public_path('foto'), $imageName);

            $postData = ResearchArea::create([

                'title' => $request->title,
                'description' => $request->description,
                'short_title' => $request->short_title,
                'foto' => $imageName,
                'icon' => $imageNameIcon,

            ]);

            return response()->json([
                'message' => 'success',
                'data' => $postData,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'statusCode' => 500,
            ], 500);
        }
    }
    public function edit(Request $request, $id)
    {
        try {
            $researchArea = ResearchArea::find($id);

            if (!$researchArea) {
                return response()->json([
                    'message' => 'Research tidak ditemukan',
                ], 404);
            }

            if ($request->hasFile('foto') && $request->hasFile('icon')) {
                $request->validate([
                    'foto' => 'image|mimes:jpg,png,jpeg,gif',
                    'icon' => 'image|mimes:jpg,png,jpeg,gif',
                ]);

                // Process icon file
                $uploadedFileIcon = $request->file('icon');
                $iconName = uniqid() . '.' . $uploadedFileIcon->getClientOriginalExtension();
                $uploadedFileIcon->move(public_path('icon'), $iconName);
                $researchArea->icon = $iconName;

                // Process foto file
                $uploadedFileFoto = $request->file('foto');
                $fotoName = uniqid() . '.' . $uploadedFileFoto->getClientOriginalExtension();
                $uploadedFileFoto->move(public_path('foto'), $fotoName);
                $researchArea->foto = $fotoName;
            }

            // Update other fields
            $researchArea->title = $request->title;
            $researchArea->description = $request->description;
            $researchArea->short_title = $request->short_title;

            $researchArea->save();

            return response()->json([
                'data' => $researchArea,
                'message' => 'success',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'ada yang salah',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $data = ResearchArea::find($id);
        $data->delete();
        if ($data) {
            return response()->json([
                'data' => $data,
            ], 200);
        } else {
            return response()->json([
                'message' => 'data not found',
            ], 404);
        }
    }
}
