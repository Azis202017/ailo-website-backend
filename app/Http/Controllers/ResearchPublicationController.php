<?php

namespace App\Http\Controllers;

use App\Models\ResearchPublication;
use Illuminate\Http\Request;

class ResearchPublicationController extends Controller
{
    public function index()
    {
        $data = ResearchPublication::with(['research_area'])->get();

        $research = $data->map(function ($research_data) {
            $research_data->foto_url = asset('research/' . $research_data->foto);
            $research_data->research_area->icon_url = asset('icon/' . $research_data->research_area->icon);
            $research_data->research_area->foto_url = asset('foto/' . $research_data->research_area->foto);

            return $research_data;
        });

        return response()->json([
            'data' => $research,
        ]);
    }

    public function show($id)
    {
        $publication = ResearchPublication::find($id);
        return $publication;
    }
    public function create(Request $request)
    {
        $uploadedFile = $request->file('foto');
        $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->move(public_path('research'), $imageName);
        $data = ResearchPublication::create([
            'id_research_area' => $request->id_research_area,
            'title' => $request->title,
            'description' => $request->description,
            'link_publication' => $request->link_publication,
            'publish_year' => $request->publish_year,
            'foto' => $imageName
        ]);
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
    public function edit(Request $request, $id)
    {
        $data =  ResearchPublication::find($id);
        $data->id_research_area = $request->id_research_area;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->link_publication = $request->link_publication;
        $data->publish_year = $request->publish_year;
        $data->save();
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
    public function delete($id)
    {
        $data = ResearchPublication::find($id);
        
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
}
