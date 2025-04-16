<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Services\Common\Contracts\ImageServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BusinessController extends Controller
{
    public function __construct(private readonly ImageServiceInterface $imageService) {}
    public function index()
    {
        $businesses = Business::all();
        return response()->json($businesses);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => "required|string|max:255",
            'logo'            => 'required|mimes:jpeg,jpg,png,webp,svg',
            // 'domainName'      => 'nullable|string|max:255',
            'linkedinProfile' => 'nullable|string|max:255',
            'email'           => 'required|email|unique:businesses',
            'password'        => 'required|string|min:6',
        ]);

        $business = new Business($data);
        $business->password = bcrypt($data['password']);
        $business->logo = $this->imageService->uploadImage($request->file('logo'), '/businesses');
        $business->save();
        return response()->json($business, 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|exists:businesses',
            'password' => 'required|string'
        ]);
        $business = Business::where('email', $data['email'])->first();
        if (!$business || !Hash::check($data['password'], $business->password)) {
            return $this->error("Invalid Credentials", 401);
        }
        $token = $business->createToken('business-token')->plainTextToken;
        return $this->success("Login Success", ["business" => $business, "token" => $token]);
    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return $this->noContent('Logged out successfully.');
    }
}
