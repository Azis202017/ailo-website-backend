<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->error([
                    'message' => 'Unauthorized'
                ], 500);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('calmifyToken')->plainTextToken;
            return response()->json([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => ' username dan password salah',
            ], 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => 'required',
            ]);





            // Check if a custom photo is provided
            if ($request->file('foto')) {
                $uploadedFile = $request->file('foto');
                $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('foto_profile'), $imageName);
            } else {
                // No custom photo provided, use the default photo
                $imageName = 'default.webp';
            }
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'kode_asisten' => $request->kode_asistant,
                'tahun_asisten' => $request->tahun_assistent,
                'foto' => $imageName,
                'linkedin' => $request->linkedin,
                'github' => $request->github,
                'discord' => $request->discord,
                'twitter' => $request->twitter,
            ]);



            return response()->json([
                'token_type' => 'Bearer',
                'message' => 'Berhasil registrasi',
                'user' => $user,
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Ada sesuatu yang salah',
                'error' => $error->getMessage(),
            ], 403);
        }
    }
    public function create()
    {
    }
}
