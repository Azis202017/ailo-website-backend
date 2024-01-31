<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        $data = EventCategory::with(['event'])->get();

        $research = $data->map(function ($eventCategory) {
            $eventCategory->foto_url = asset('event_foto_categories/' . $eventCategory->foto);

            $eventCategory->event->map(function ($event) {
                $event->foto_url = asset('events/' . $event->foto);

                return $event;
            });

            return $eventCategory;
        });

        return response()->json([
            'data' => $research,
        ]);
    }
    public function show($id)
    {
        $eventCategory = EventCategory::find($id);
        return $eventCategory;
    }
    public function create(Request $request)
    {
        $uploadedFile = $request->file('foto');
        $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();

        $uploadedFile->move(public_path('event_foto_categories'), $imageName);
        $data = EventCategory::create([
            'title' => $request->title,
            'event_foto_categories' => $imageName,
        ]);
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
    public function edit(Request $request, $id)
    {
        $data =  EventCategory::find($id);
        $data->title = $request->title;

        $data->save();
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
    public function delete($id)
    {
        $data = EventCategory::find($id);
        $data->delete();
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
}
