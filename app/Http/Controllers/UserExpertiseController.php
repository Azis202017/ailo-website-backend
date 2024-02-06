<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserExpertise;
use Illuminate\Support\Facades\Auth;

class UserExpertiseController extends Controller
{
    public function create(Request $request) {
        $user  = Auth::user();
        $userExpertise = new UserExpertise();

        $userExpertise->title = $request->title;
        $userExpertise->id_user = $user->id;
        $userExpertise->save();
        return $userExpertise;
    }
}
