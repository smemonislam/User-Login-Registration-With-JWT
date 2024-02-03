<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $perPage = $request->input('perPage') ?? 5;

        $query = Customer::query();

        if ($query) {
            $query->where('name', 'like', '%' . $keyword . '%');
            $query->orWhere('email', 'like', '%' . $keyword . '%');
        }

        return $query->orderByDesc('id')->paginate($perPage)->withQueryString();
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:customers,email|string|max:100',
            'mobile' => 'required|string|max:100',
        ]);


        Customer::create($validated);

        return response()->json(['success', 'Data is added successfully.']);

    }


    public function edit(Customer $customer)
    {
        return response()->json($customer);
    }


    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|string|max:100|unique:customers,email, ' . $customer->id,
            'mobile' => 'required|string|max:100',
        ]);

        $customer->update($validated);

        return response()->json(['success', 'Data is updated successfully.']);
    }


    public function destory(Customer $customer)
    {
        $customer->delete();
        return response()->json(['success', 'Data is deleted successfully.']);
    }
}
