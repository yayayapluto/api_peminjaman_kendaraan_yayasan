<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Interfaces\ResourceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private ResourceInterface $resourceInterface;

    public function __construct(ResourceInterface $resourceInterface) {
        $this->resourceInterface = $resourceInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->resourceInterface->index($request);
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
        return $this->resourceInterface->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user)
    {
        return $this->resourceInterface->show($user);
    }

    public function search(Request $request) {
        return $this->resourceInterface->search($request);
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
    public function update(Request $request, string $user)
    {
        return $this->resourceInterface->update($request, $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $user)
    {
        return $this->resourceInterface->destroy($user);
    }
}
