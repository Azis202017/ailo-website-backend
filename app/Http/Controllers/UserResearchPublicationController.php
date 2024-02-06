<?php

namespace App\Http\Controllers;

use App\Models\UserResearchPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserResearchPublicationController extends Controller
{
    public function create(Request $request) {
        $user = Auth::user();
        $userResearchPublication = new UserResearchPublication();
        $userResearchPublication->title = $request->title;
        $userResearchPublication->id_user = $user->id;
        $userResearchPublication->save();
        return $userResearchPublication;
    }
}
