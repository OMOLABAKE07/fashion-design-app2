<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SyncQueue;
use Illuminate\Http\Request;

class SyncQueueController extends Controller
{
    // Get all sync queue records
    public function getAllSyncQueueRecords()
    {
        return response()->json(SyncQueue::all(), 200);
    }

    // Add a new sync queue entry
    public function createSyncQueueRecord(Request $request)
    {
        $request->validate([
            'operation' => 'required|in:create,update,delete',
            'entity_type' => 'required|in:customer,measurement,design,message',
            'data' => 'required|array',
            'status' => 'nullable|string',
        ]);

        $queue = SyncQueue::create([
            'operation' => $request->operation,
            'entity_type' => $request->entity_type,
            'data' => $request->data,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json($queue, 201);
    }

    // Update a sync queue record
    public function updateSyncQueueRecord(Request $request, $id)
    {
        $queue = SyncQueue::findOrFail($id);
        $queue->update($request->all());

        return response()->json($queue, 200);
    }

    // Delete a sync queue record
    public function deleteSyncQueueRecord($id)
    {
        SyncQueue::destroy($id);

        return response()->json(['message' => 'Sync queue record deleted'], 204);
    }
}
