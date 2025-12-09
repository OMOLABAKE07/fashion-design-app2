<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getAllCustomers()
    {
        return response()->json(Customer::all(), 200);
    }

    public function createCustomer(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:customers',
            'phone'      => 'required|string|max:20',
            'address'    => 'nullable|string',
            'gender'     => 'nullable|string',
            'notes'      => 'nullable|string',
            'status'     => 'nullable|string',
        ]);

        $customer = Customer::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'address'    => $request->address,
            'gender'     => $request->gender,
            'notes'      => $request->notes,
            'status'     => 'active',
        ]);

        return response()->json($customer, 201);
    }

    public function getCustomer($id)
    {
        return response()->json(Customer::findOrFail($id), 200);
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return response()->json($customer, 200);
    }

    public function deleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();
        return response()->json(['message' => 'Customer deleted'], 200);
    }
}
