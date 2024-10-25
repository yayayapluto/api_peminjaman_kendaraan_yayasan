<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Interfaces\Interfaces\RecordInterface;
use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    private RecordInterface $recordInterface;

    public function __construct(RecordInterface $recordInterface)
    {
        $this->recordInterface = $recordInterface;
    }

    public function index(Request $request)
    {
        return $this->recordInterface->index($request);
    }

    public function create()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    public function store(Request $request)
    {
        return $this->recordInterface->store($request);
    }

    public function show(string $uuid)
    {
        return $this->recordInterface->show($uuid);
    }

    public function search(Request $request)
    {
        return $this->recordInterface->search($request);
    }

    public function edit()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    public function requestStatus(Request $request)
    {
        $statuses = Record::select('status', \DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return ApiResponse::sendSuccess("Request status retrieved successfully", $statuses);
    }

    public function numberOfOrders(Request $request)
    {
        $totalOrders = Record::count();

        return ApiResponse::sendSuccess("Total number of orders retrieved successfully", ['total_orders' => $totalOrders]);
    }

    public function mostPickedDriver(Request $request)
    {
        $driver = Record::select('driver_name', \DB::raw('count(*) as total'))
            ->groupBy('driver_name')
            ->orderBy('total', 'desc')
            ->first();

        return ApiResponse::sendSuccess("Most picked driver retrieved successfully", $driver);
    }

    public function mostRentedUser(Request $request)
    {
        $user = Record::select('id_user', \DB::raw('count(*) as total'))
            ->groupBy('id_user')
            ->orderBy('total', 'desc')
            ->first();

        return ApiResponse::sendSuccess("Most rented user retrieved successfully", $user);
    }

    public function farthestDistance(Request $request)
    {
        $farthest = Record::selectRaw('id_record, (POW((to_lat - from_lat), 2) + POW((to_lon - from_lon), 2)) as distance')
            ->orderBy('distance', 'desc')
            ->first();

        return ApiResponse::sendSuccess("Farthest distance retrieved successfully", $farthest);
    }

    public function kindOfCar(Request $request)
    {
        $kindOfCar = Record::select('id_vehicle', \DB::raw('count(*) as total'))
            ->groupBy('id_vehicle')
            ->get();

        return ApiResponse::sendSuccess("Kind of car statistics retrieved successfully", $kindOfCar);
    }

    public function mostUsedCar(Request $request)
    {
        $mostUsed = Record::select('id_vehicle', \DB::raw('count(*) as total'))
            ->groupBy('id_vehicle')
            ->orderBy('total', 'desc')
            ->first();

        return ApiResponse::sendSuccess("Most used car retrieved successfully", $mostUsed);
    }
}
