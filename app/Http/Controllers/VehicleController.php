<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Interfaces\Interfaces\VehicleInterface;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    private VehicleInterface $vehicleInterface;

    public function __construct(VehicleInterface $vehicleInterface)
    {
        $this->vehicleInterface = $vehicleInterface;
    }
    public function store(Request $request)
    {
        return $this->vehicleInterface->store($request);
    }

    public function show(string $uuid)
    {
        return $this->vehicleInterface->show($uuid);
    }

    public function search(Request $request)
    {
        return $this->vehicleInterface->search($request);
    }

    public function update(Request $request, string $uuid)
    {
        return $this->vehicleInterface->update($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->vehicleInterface->destroy($uuid);
    }

}
