<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->input('category');
        $year = $request->input('year');
        $month = $request->input('month');
        $q = $request->input('q'); // assuming 'q' is the parameter name for the search query

        $query = EventCategory::with(['event']);

        if ($category) {
            $query->where('title', $category);
        }

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        if ($month) {
            $query->whereMonth('created_at', $month);
        }

        if ($q) {
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('title', 'like', '%' . $q . '%')
                    ->orWhereHas('event', function ($eventSubQuery) use ($q) {
                        $eventSubQuery->where('title', 'like', '%' . $q . '%');
                    });
            });
        }

        $data = $query->get();

        $data->transform(function ($eventCategory) {
            $eventCategory->foto_url = asset('event_foto_categories/' . $eventCategory->event_foto_categories);

            $eventCategory->event->transform(function ($event) {
                $event->foto_url = asset('events/' . $event->foto);
                return $event;
            });

            return $eventCategory;
        });

        return response()->json([
            'data' => $data,
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
