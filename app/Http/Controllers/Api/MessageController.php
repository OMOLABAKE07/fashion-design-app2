<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Get all messages
    public function getAllMessages()
    {
        return response()->json(Message::with('customer')->get(), 200);
    }

    // Create a new message
    public function createMessage(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'nullable|string',
        ]);

        $message = Message::create($validated);

        return response()->json($message, 201);
    }

    // Get a single message
    public function getSingleMessage($id)
    {
        return response()->json(
            Message::with('customer')->findOrFail($id),
            200
        );
    }

    // Update an existing message
    public function updateMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->all());

        return response()->json($message, 200);
    }

    // Delete a message
    public function deleteMessage($id)
    {
        Message::destroy($id);

        return response()->json(['message' => 'Message deleted'], 204);
    }
}
