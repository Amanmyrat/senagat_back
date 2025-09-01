<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessageRequest;
use App\Http\Resources\ContactMessageResource;
use App\Models\ContactMessage;
use Exception;
use Illuminate\Http\JsonResponse;

class ContactMessageController extends Controller
{
    public function store(ContactMessageRequest $request)
    {
        try {
            $validated = $request->validated();
            $message = ContactMessage::create($validated);

            return (new ContactMessageResource($message))
                ->additional([
                    'success' => true,
                ])
                ->response()
                ->setStatusCode(201);

        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Message not send',
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
