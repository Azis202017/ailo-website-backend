<?php

namespace App\Http\Controllers;

use App\Models\UserResearchPublication;
use Illuminate\Http\Request;

class UserResearchPublicationController extends Controller
{
    public function create(Request $request) {
        $userResearchPublication = new UserResearchPublication();
        $userResearchPublication->title = $request->title;
        $userResearchPublication->id_user = $request->id_user;
        $userResearchPublication->save();
        return $userResearchPublication;
    }
}
