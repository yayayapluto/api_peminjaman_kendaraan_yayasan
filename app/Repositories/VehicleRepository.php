<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\VehicleInterface;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Http\Resources\MakeResource;
use Illuminate\Validation\ValidationException;

class VehicleRepository implements VehicleInterface
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $vehicles = Vehicle::paginate($limit);

        return ApiResponse::sendSuccess("Vehicles retrieved successfully", [
            "vehicles" => MakeResource::collection($vehicles),
            "meta" => [
                "current_page" => $vehicles->currentPage(),
                "last_page" => $vehicles->lastPage(),
                "per_page" => $vehicles->perPage(),
                "total" => $vehicles->total(),
            ],
        ]);
    }

    public function show(string $uuid)
    {
        $vehicle = Vehicle::where('id_vehicle', $uuid)->first();
        if (!$vehicle) {
            return ApiResponse::sendErrors("Vehicle not found", [], 404);
        }
        return ApiResponse::sendSuccess("Vehicle retrieved successfully", new MakeResource($vehicle));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $vehicles = Vehicle::where('brand', 'LIKE', "%{$query}%")
            ->orWhere('model', 'LIKE', "%{$query}%")
            ->paginate(15);

        return ApiResponse::sendSuccess("Vehicles found", [
            "vehicles" => MakeResource::collection($vehicles),
            "meta" => [
                "current_page" => $vehicles->currentPage(),
                "last_page" => $vehicles->lastPage(),
                "per_page" => $vehicles->perPage(),
                "total" => $vehicles->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_vehicle' => 'required|uuid|unique:vehicles,id_vehicle',
                'brand' => 'required|string|max:255',
                'model' => 'required|string|max:255',
                'color' => 'required|string|max:255',
                'nopol' => 'required|string|max:255',
                'is_available' => 'required|boolean',
            ]);

            $validatedData['id_vehicle'] = Str::uuid();
            $vehicle = Vehicle::create($validatedData);

            return ApiResponse::sendSuccess("Vehicle created successfully", new MakeResource($vehicle), 201);
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }

    public function update(Request $request, string $uuid)
    {
        try {
            $vehicle = Vehicle::where('id_vehicle', $uuid)->first();
            if (!$vehicle) {
                return ApiResponse::sendErrors("Vehicle not found", [], 404);
            }

            $validatedData = $request->validate([
                'brand' => 'sometimes|required|string|max:255',
                'model' => 'sometimes|required|string|max:255',
                'color' => 'sometimes|required|string|max:255',
                'nopol' => 'sometimes|required|string|max:255',
                'is_available' => 'sometimes|required|boolean',
            ]);

            $vehicle->update($validatedData);
            return ApiResponse::sendSuccess("Vehicle updated successfully", new MakeResource($vehicle));
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }

    public function destroy(string $uuid)
    {
        $vehicle = Vehicle::where('id_vehicle', $uuid)->first();
        if (!$vehicle) {
            return ApiResponse::sendErrors("Vehicle not found", [], 404);
        }
        $vehicle->delete();
        return ApiResponse::sendSuccess("Vehicle deleted successfully");
    }
}
