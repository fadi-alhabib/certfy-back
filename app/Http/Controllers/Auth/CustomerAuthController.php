<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    /**
     * Log in a customer and issue a Sanctum token.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',  // Assuming customers log in with email; adjust accordingly
            'password' => 'required|string',
        ]);

        // Find the customer by email (or another identifier)
        $customer = Customer::where('email', $credentials['email'])->first();

        if (!$customer || !Hash::check($credentials['password'], $customer->password)) {
            return response()->json(['message' => 'Invalid credentials.'], 401);
        }

        // Issue a token (e.g., named 'customer-token')
        $token = $customer->createToken('customer-token')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token'    => $token,
        ]);
    }

    /**
     * Log out the customer (revoke token).
     */
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }
}
