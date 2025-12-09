<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Models\Measurement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeasurementController extends Controller
{
    public function getAllMeasurements()
    {
        return response()->json(
            Measurement::latest()->get(),
            200
        );
    }

    public function getMeasurement($id)
    {
        return response()->json(
            Measurement::findOrFail($id),
            200
        );
    }

    public function getCustomerMeasurements($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer->measurements, 200);
    }

    public function createMeasurement(Request $request)
    {
        $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'customer_name'    => 'required|string|max:200',
            'measurement_date' => 'required|date',
            'measurements'     => 'required|array',
            'categories'       => 'nullable|array',
            'notes'            => 'nullable|string',
        ]);

        $measurement = Measurement::create([
            'customer_id'      => $request->customer_id,
            'customer_name'    => $request->customer_name,
            'measurement_date' => $request->measurement_date,
            'measurements'     => $request->measurements,
            'categories'       => $request->categories ?? null,
            'notes'            => $request->notes ?? null,
        ]);

        return response()->json([
            'message' => 'Measurement saved successfully!',
            'data' => $measurement
        ], 201);
    }

    public function updateMeasurement(Request $request, $id)
    {
        $measurement = Measurement::findOrFail($id);

        $validated = $request->validate([
            'measurement_date' => 'nullable|date',
            'measurements'     => 'nullable|array',
            'categories'       => 'nullable|array',
            'notes'            => 'nullable|string',
        ]);

        $measurement->update($validated);

        return response()->json([
            'message' => 'Measurement updated successfully!',
            'data' => $measurement
        ], 200);
    }

    public function deleteMeasurement($id)
    {
        Measurement::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Measurement deleted successfully.'
        ], 200);
    }
}
