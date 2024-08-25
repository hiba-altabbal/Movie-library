<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    
    /**
     * Constructor to inject UserService Class
     * @param App\Services\UserService $userService 
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of user in database.
     */
    public function index()
    {
        //
        return User::all();
    }

    /**
     * Store a newly user in database.
     * @param Request $request
     * @return Illuminate\Http\JsonResponse;
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = $this->userService->createUser($validatedData);
        return response()->json($user, 201);
    }

    /**
     * Display spicific user from database
     * @param id of user i want to show its details
     */
    public function show(string $id)
    {
        //
        return User::findOrFail($id);
    }

    /**
     * Update the specified user in database.
     * @param Request $request
     * @param id of user i want to update
     * @return jsonResponse
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'sometimes|required|string|min:8',
        ]);

        $user = User::findOrFail($id);
        $updatedUser = $this->userService->updateUser($user, $validatedData);
        return response()->json($updatedUser, 200);
    }

    /**
     * Remove the specified user.
     * @param id of user i want to delete
     * @return null
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $this->userService->deleteUser($user);
        return response()->json(null, 204);
    }
}
