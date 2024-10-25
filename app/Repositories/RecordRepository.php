<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\RecordInterface;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Http\Resources\MakeResource;
use Illuminate\Validation\ValidationException;

class RecordRepository implements RecordInterface
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $records = Record::paginate($limit);

        return ApiResponse::sendSuccess("Records retrieved successfully", [
            "records" => MakeResource::collection($records),
            "meta" => [
                "current_page" => $records->currentPage(),
                "last_page" => $records->lastPage(),
                "per_page" => $records->perPage(),
                "total" => $records->total(),
            ],
        ]);
    }

    public function show(string $uuid)
    {
        $record = Record::where('id_record', $uuid)->first();
        if (!$record) {
            return ApiResponse::sendErrors("Record not found", [], 404);
        }
        return ApiResponse::sendSuccess("Record retrieved successfully", new MakeResource($record));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $records = Record::where('driver_name', 'LIKE', "%{$query}%")->paginate(15);

        return ApiResponse::sendSuccess("Records found", [
            "records" => MakeResource::collection($records),
            "meta" => [
                "current_page" => $records->currentPage(),
                "last_page" => $records->lastPage(),
                "per_page" => $records->perPage(),
                "total" => $records->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_record' => 'required|uuid|unique:records,id_record',
                'id_user' => 'required|uuid|exists:users,id_user',
                'id_vehicle' => 'required|uuid|exists:vehicles,id_vehicle',
                'driver_name' => 'required|string|max:255',
                'service' => 'required|in:internal,external',
                'image' => 'required|string|max:255',
                'from_address' => 'required|string|max:255',
                'from_lon' => 'required|decimal:10,7',
                'from_lat' => 'required|decimal:10,7',
                'to_address' => 'required|string|max:255',
                'to_lon' => 'required|decimal:10,7',
                'to_lat' => 'required|decimal:10,7',
                'status' => 'required|in:new,apr,rej',
            ]);

            $validatedData['id_record'] = Str::uuid();
            $record = Record::create($validatedData);

            return ApiResponse::sendSuccess("Record created successfully", new MakeResource($record), 201);
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }
}
