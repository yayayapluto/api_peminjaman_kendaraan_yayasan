<?php

namespace App\Repositories;

use App\Interfaces\Interfaces\NotificationInterface;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\ApiResponse;
use App\Http\Resources\MakeResource;
use Illuminate\Validation\ValidationException;

class NotificationRepository implements NotificationInterface
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit', 15);
        $notifications = Notification::paginate($limit);

        return ApiResponse::sendSuccess("Notifications retrieved successfully", [
            "notifications" => MakeResource::collection($notifications),
            "meta" => [
                "current_page" => $notifications->currentPage(),
                "last_page" => $notifications->lastPage(),
                "per_page" => $notifications->perPage(),
                "total" => $notifications->total(),
            ],
        ]);
    }

    public function show(string $uuid)
    {
        $notification = Notification::where('id_notification', $uuid)->first();
        if (!$notification) {
            return ApiResponse::sendErrors("Notification not found", [], 404);
        }
        return ApiResponse::sendSuccess("Notification retrieved successfully", new MakeResource($notification));
    }

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $notifications = Notification::where('message', 'LIKE', "%{$query}%")->paginate(15);

        return ApiResponse::sendSuccess("Notifications found", [
            "notifications" => MakeResource::collection($notifications),
            "meta" => [
                "current_page" => $notifications->currentPage(),
                "last_page" => $notifications->lastPage(),
                "per_page" => $notifications->perPage(),
                "total" => $notifications->total(),
            ],
        ]);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_notification' => 'required|uuid|unique:notifications,id_notification',
                'id_user' => 'required|uuid|exists:users,id_user',
                'id_record' => 'required|uuid|exists:records,id_record',
                'status' => 'required|in:apr,rej',
                'message' => 'required|string|max:255',
                'is_read' => 'sometimes|boolean',
            ]);

            $validatedData['id_notification'] = Str::uuid();
            $notification = Notification::create($validatedData);

            return ApiResponse::sendSuccess("Notification created successfully", new MakeResource($notification), 201);
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }

    public function update(Request $request, string $uuid)
    {
        try {
            $notification = Notification::where('id_notification', $uuid)->first();
            if (!$notification) {
                return ApiResponse::sendErrors("Notification not found", [], 404);
            }

            $validatedData = $request->validate([
                'id_user' => 'sometimes|uuid|exists:users,id_user',
                'id_record' => 'sometimes|uuid|exists:records,id_record',
                'status' => 'sometimes|in:apr,rej',
                'message' => 'sometimes|required|string|max:255',
                'is_read' => 'sometimes|boolean',
            ]);

            $notification->update($validatedData);
            return ApiResponse::sendSuccess("Notification updated successfully", new MakeResource($notification));
        } catch (ValidationException $ex) {
            return ApiResponse::sendErrors("Validation errors", $ex->errors(), 422);
        }
    }
}
