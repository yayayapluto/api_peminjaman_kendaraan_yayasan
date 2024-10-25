<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserInterface $userInterface;

    public function __construct(UserInterface $userInterface) {
        $this->userInterface = $userInterface;
    }

    public function login(Request $request)
    {
        return $this->userInterface->login($request);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->userInterface->index($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        return $this->userInterface->show($uuid);
    }

    public function search(Request $request) {
        return $this->userInterface->search($request);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uuid)
    {
        return $this->userInterface->update($request, $uuid);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        return $this->userInterface->destroy($uuid);
    }
}
