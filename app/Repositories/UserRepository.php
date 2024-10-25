<?php

namespace App\Repositories;

use App\Interfaces\ResourceInterface;
use App\Interfaces\UserInterface;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Http\Resources\MakeResource;
use Illuminate\Validation\ValidationException;

class UserRepository implements UserInterface
{
    public function __construct()
    {
        //
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'password' => 'required|string',
        ]);

        $user = User::where('name', $validatedData['name'])->first();

        if (!$user || !Hash::check($validatedData['password'], $user->password)) {
            return ApiResponse::sendErrors("Invalid credentials", [], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return ApiResponse::sendSuccess("Login successful", [
            'token' => $token,
            'user' => new MakeResource($user)
        ]);
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $users = User::paginate($limit);

        return ApiResponse::sendSuccess("Users retrieved successfully", [
            "users" => MakeResource::collection($users),
            "meta" => [
                "current_page" => $users->currentPage(),
                "last_page" => $users->lastPage(),
                "per_page" => $users->perPage(),
                "total" => $users->total()
            ]
        ]);
    }


    public function show(string $uuid)
    {
        $user = User::where('id_user', $uuid)->first();
        if (!$user) {
            return ApiResponse::sendErrors("User not found", [], 404);
        }
        return ApiResponse::sendSuccess("User retrieved successfully", array(new MakeResource($user)));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $users = User::where('name', 'LIKE', "%{$query}%")->paginate(15);
        return ApiResponse::sendSuccess("Users found", array(MakeResource::collection($users)));
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:users,name|max:255',
                'password' => 'required|string|min:6',
                'level' => 'required|integer',
                'is_enable' => 'required|boolean',
                'created_by' => 'nullable|string|max:255',
            ]);
            $validatedData['id_user'] = Str::uuid();
            $validatedData['password'] = Hash::make($validatedData['password']);
            $user = User::create($validatedData);
            return ApiResponse::sendSuccess("User created successfully", array(new MakeResource($user)), 201);
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }

    public function update(Request $request, string $uuid)
    {
        try {
            $user = User::where('id_user', $uuid)->first();
            if (!$user) {
                return ApiResponse::sendErrors("User not found", [], 404);
            }
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|unique:users,name,' . $user->name . "|max:255",
                'password' => 'sometimes|required|string|min:6',
                'level' => 'sometimes|required|integer',
                'is_enable' => 'sometimes|required|boolean',
                'updated_by' => 'nullable|string|max:255',
            ]);
            if (isset($validatedData['password'])) {
                $validatedData['password'] = Hash::make($validatedData['password']);
            }
            $user->update($validatedData);
            return ApiResponse::sendSuccess("User updated successfully", array(new MakeResource($user)));
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }

    public function destroy(string $uuid)
    {
        $user = User::where('id_user', $uuid)->first();
        if (!$user) {
            return ApiResponse::sendErrors("User not found", [], 404);
        }
        $user->delete();
        return ApiResponse::sendSuccess("User deleted successfully");
    }
}
