<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $roles = $user->roles()->pluck('name')->toArray();

        return response()->json([
            'user' => $user,
            'roles' => $roles
        ]);
    }
    public function updatePhoto(Request $request)
    {
        $id = $request->user()->id;
        $user = User::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->storePublicly('photos', 'public');
            $validatedData['photo'] = Storage::url($photo);
        }

        $user->fill($validatedData);

        $user->save();

        return response()->json([
            'status' => 'Photo updated successfully',
            'data' => [
                $user->id,
                $user->name,
                $user->photo,
            ]
        ], 200);
    }
    
}