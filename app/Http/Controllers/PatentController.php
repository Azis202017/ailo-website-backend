<?php

namespace App\Http\Controllers;

use App\Models\Patent;
use Illuminate\Http\Request;

class PatentController extends Controller
{
    public function index() {
        $data = Patent::all() ;
        return response()->json(['data' => $data, 'status' => 'OK'], 200);
    }
    public function store(Request $request) {
        $data = Patent::create([
            'patent' => $request->patent
        ]);
        return response()->json(['data' => $data, 'status' => 'OK'], 200);

    }
}
