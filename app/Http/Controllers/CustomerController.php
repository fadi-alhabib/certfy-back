<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCertificateResource;
use App\Models\Certificate;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $user = auth('business')->user();
        $certificates = Certificate::where('business_id', $user->id)
            ->with(['customers' => function ($query) {
                $query->select('customers.id', 'fullNameEn', 'fullNameAr', 'email')
                    ->withPivot('id', 'isRevoked', 'created_at');
            }])
            ->get();
        return $this->success("Fetched", CustomerCertificateResource::collection($certificates));
    }


    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'fullNameAr' => 'required|string|max:255',
    //         'fullNameEn' => 'required|string|max:255',
    //         // 'email' => 'required|string|max:255|email',
    //         // 'password'   => 'nullable|string|min:6',
    //     ]);

    //     // if (isset($data['password'])) {
    //     //     $data['password'] = bcrypt($data['password']);
    //     // }

    //     $customer = Customer::create($data);
    //     return response()->json($customer, 201);
    // }


    // public function show($id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     return response()->json($customer);
    // }

    // public function update(Request $request, $id)
    // {
    //     $customer = Customer::findOrFail($id);

    //     $data = $request->validate([
    //         'fullNameAr' => 'sometimes|required|string|max:255',
    //         'fullNameEn' => 'sometimes|required|string|max:255',
    //         'password'   => 'sometimes|nullable|string|min:6',
    //     ]);

    //     if (isset($data['password'])) {
    //         $data['password'] = bcrypt($data['password']);
    //     }

    //     $customer->update($data);
    //     return response()->json($customer);
    // }

    // public function destroy($id)
    // {
    //     $customer = Customer::findOrFail($id);
    //     $customer->delete();
    //     return response()->json(null, 204);
    // }
}
