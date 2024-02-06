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
        $users = User::with(['expertise', 'research'])->get();

        // Sort users alphabetically by name
        $users = $users->sortBy('name');

        $roleGroupedUsers = [
            'vice_directur' => null,
            'directur' => null,
            'members' => [],
            'undergraduates' => [],
            'graduates' => [],
        ];

        foreach ($users as $user) {
            $fotoUrl = url('/') . '/foto_profile/' . ($user->foto ?: 'maskot.webp');
            $user['foto_url'] = $fotoUrl;

            $role = $user->kategori_asistant;

            switch ($role) {
                case 'vice_directur':
                    $roleGroupedUsers['vice_directur'] = $user;
                    break;
                case 'directur':
                    $roleGroupedUsers['directur'] = $user;
                    break;
                case 'member':
                    $roleGroupedUsers['members'][] = $user;
                    break;
                case 'undergraduate':
                    $roleGroupedUsers['undergraduates'][] = $user;
                    break;
                case 'graduate':
                    $roleGroupedUsers['graduates'][] = $user;
                    break;
                default:
                    // Handle unknown roles if needed
                    break;
            }
        }

        // Convert 'members', 'undergraduates', and 'graduates' to objects if they are empty arrays
        foreach (['members', 'undergraduates', 'graduates'] as $role) {
            if (empty($roleGroupedUsers[$role])) {
                $roleGroupedUsers[$role] = (object)[];
            }
        }

        return response()->json($roleGroupedUsers, 200);
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
                'name' => ['required', 'string', 'max:255'],
                'email' => ['email', 'max:255'],
                'password' => 'required',
            ]);





            // Check if a custom photo is provided
            if ($request->file('foto')) {
                $uploadedFile = $request->file('foto');
                $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('foto_profile'), $imageName);
            } else {
                $imageName = 'maskot.webp';
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'kode_asistant' => $request->kode_asistant,
                'tahun_asistant' => $request->tahun_asistant,
                'foto' => $imageName,
                'linkedin' => $request->linkedin,
                'github' => $request->github,
                'discord' => $request->discord,
                'twitter' => $request->twitter,
                'jabatan' => $request->jabatan,
                'google_schoolar' => $request->google_schoolar,
                'kategori_asistant' => $request->kategori_assistant,
                'is_assistant' => $request->is_assistant,
                'jurusan' => $request->jurusan,
                'biography' => $request->biography,

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

    public function update(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $request->validate([
                'name' => ['string', 'max:255'],
                'email' => ['email', 'max:255'],
                'password' => 'sometimes|required',
                'foto' => ['image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // adjust as needed
                // Add validation rules for other fields as needed
            ]);

            // Check if a custom photo is provided
            if ($request->hasFile('foto')) {
                $uploadedFile = $request->file('foto');
                $imageName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
                $uploadedFile->move(public_path('foto_profile'), $imageName);
                $user->foto = $imageName;
            }

            // Update other fields
            $user->name = $request->input('name', $user->name);
            $user->email = $request->input('email', $user->email);

            // Check if email is provided and different from the current one
            if ($request->filled('email') && $request->email !== $user->email) {
                // Validate uniqueness only if the email is different
                $request->validate(['email' => 'unique:users,email']);
                $user->email = $request->email;
            }

            $user->password = $request->filled('password') ? Hash::make($request->password) : $user->password;
            $user->kode_asistant = $request->input('kode_asistant', $user->kode_asistant);
            $user->tahun_asistant = $request->input('tahun_asistant', $user->tahun_asistant);
            $user->linkedin = $request->input('linkedin', $user->linkedin);
            $user->github = $request->input('github', $user->github);
            $user->discord = $request->input('discord', $user->discord);
            $user->twitter = $request->input('twitter', $user->twitter);
            $user->jabatan = $request->input('jabatan', $user->jabatan);
            $user->google_schoolar = $request->input('google_schoolar', $user->google_schoolar);
            $user->kategori_asistant = $request->input('kategori_asistant', $user->kategori_asistant);
            $user->is_assistant = $request->input('is_assistant', $user->is_assistant);
            $user->jurusan = $request->input('jurusan', $user->jurusan);
            $user->biography = $request->input('biography', $user->biography);

            $user->save();

            return response()->json([
                'message' => 'User profile updated successfully',
                'user' => $user,
            ], 200);
        } catch (Exception $error) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $error->getMessage(),
            ], 403);
        }
    }
    public function show($id)
    {
        $user = User::with(['expertise', 'research'])->find($id);

        if ($user) {
            $fotoUrl = url('/') . '/foto_profile/' . ($user->foto ?: 'maskot.webp');
            $user['foto_url'] = $fotoUrl;

            return response()->json($user, 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }
}
