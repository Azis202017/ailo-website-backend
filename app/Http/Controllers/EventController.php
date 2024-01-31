<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create(Request $request) {
        $uploadedFile = $request->file('foto');
        $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->move(public_path('event_foto'), $imageName);

        $data = Event::create([
            'id_research_area' => $request->id_research_area,
            'id_category_event' => $request->id_category_event,
            'title' => $request->title,
            'description' => $request->description,
            'short_title' => $request->short_title,
            'event_foto' => $imageName,
        ]);

        return response()->json(['data' => $data,'status' => 'OK'], 200);
    }
}
