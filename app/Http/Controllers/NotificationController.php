<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Interfaces\Interfaces\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private NotificationInterface $notificationInterface;

    public function __construct(NotificationInterface $notificationInterface)
    {
        $this->notificationInterface = $notificationInterface;
    }

    public function index(Request $request)
    {
        return $this->notificationInterface->index($request);
    }

    public function create()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    public function store(Request $request)
    {
        return $this->notificationInterface->store($request);
    }

    public function show(string $uuid)
    {
        return $this->notificationInterface->show($uuid);
    }

    public function search(Request $request)
    {
        return $this->notificationInterface->search($request);
    }

    public function edit()
    {
        return ApiResponse::sendErrors("There is no view on api", code: 404);
    }

    public function update(Request $request, string $uuid)
    {
        return $this->notificationInterface->update($request, $uuid);
    }
}
