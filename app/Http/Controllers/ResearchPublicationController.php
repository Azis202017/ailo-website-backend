<?php

namespace App\Http\Controllers;

use App\Models\ResearchPublication;
use Illuminate\Http\Request;

class ResearchPublicationController extends Controller
{
    public function index()
    {
        return ResearchPublication::with(['research_area'])->get();
    }
    public function show($id) {
        $publication = ResearchPublication::find($id);
        return $publication;
    }
    public function create(Request $request)
    {
        $data = ResearchPublication::create([
            'id_research_area' => $request->id_research_area,
            'title' => $request->title,
            'description' => $request->description,
            'link_publication' => $request->link_publication,
            'publish_year' => $request->publish_year,
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
    public function delete($id) {
        $data = ResearchPublication::find($id);
        $data->delete();
        return response()->json(['data' => $data,'status' => 'OK'], 200);
    }
}
