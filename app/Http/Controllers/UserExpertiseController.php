<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExpertise;

class UserExpertiseController extends Controller
{
    public function create(Request $request) {
        $userExpertise = new UserExpertise();
        $userExpertise->title = $request->title;
        $userExpertise->id_user = $request->id_user;
        $userExpertise->save();
        return $userExpertise;
    }
}
