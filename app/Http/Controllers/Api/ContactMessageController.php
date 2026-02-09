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
    /**
     *  Contact Messages
     *
     * @unauthenticated

     *
     * @localizationHeader
     */
    public function store(ContactMessageRequest $request)
    {
        try {
            $validated = $request->validated();
            $message = ContactMessage::create($validated);

            return new JsonResponse([
                'success' => true,
                'data' => new ContactMessageResource($message),
            ], 201);

        } catch (Exception $e) {
            return new JsonResponse([
                'success' => false,
                'error_message' => $e->getMessage(),
                //       'code' => ErrorMessage::CONTACT_MESSAGE_FAILED->value,
            ], 400);
        }
    }
}
