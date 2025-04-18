<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertfyRequest;
use App\Http\Requests\StoreCertificateRequest;
use App\Http\Resources\CertificateResource;
use App\Http\Services\ImageServiceInterface;
use App\Models\Certificate;
use App\Models\Customer;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function __construct(private readonly ImageServiceInterface $imageService) {}
    public function index(Request $request)
    {
        $user = auth('sanctum')->user();
        $certificates = Certificate::where('business_id', $user->id)->with('family')->withCount('customers')->get();
        return $this->success("Certificates Fetched Successfuly", CertificateResource::collection($certificates), 200);
    }

    public function store(StoreCertificateRequest $request)
    {
        $user = auth('sanctum')->user();
        $data = $request->validated();

        $certificate = new Certificate($data);
        $imagePath = $this->imageService->uploadImage($request->file('image'), '/certificates');
        $certificate->image = $imagePath;
        $certificate->business_id = $user->id;
        $certificate->save();

        return $this->success(
            message: "Certificate Created Successfully",
            data: ["link" => "https://certfy.me/certificates/" . $certificate->id],
            statusCode: 201,
        );
    }


    public function show($id)
    {
        $user = auth('sanctum')->user();
        $certificate = Certificate::where('business_id', $user->id)
            ->where('id', $id)
            ->with('family')
            ->withCount('customers')
            ->first();
        return $this->success("fetched", CertificateResource::make($certificate));
    }


    public function certfy(CertfyRequest $request, $id)
    {

        $data = $request->validated();
        $customer = Customer::create([
            'fullNameEn' => $data['fullNameEn'],
            'fullNameAr' => $data['fullNameAr'],
            'email'      => $data['email'],
        ]);
        $certificate = Certificate::with('family')->findOrFail($id);


        if (Carbon::now()->greaterThan($certificate->expiresAt)) {
            return response()->json([
                'message' => 'This certificate has expired and cannot be assigned.'
            ], 400);
        }

        if (!is_null($certificate->lat) && !is_null($certificate->long) && !is_null($certificate->range)) {

            $userLat  = $data['lat'];
            $userLong = $data['long'];


            $earthRadius = 6371;


            $dLat = deg2rad($userLat - $certificate->lat);
            $dLon = deg2rad($userLong - $certificate->long);


            $certLatRad = deg2rad($certificate->lat);
            $userLatRad = deg2rad($userLat);


            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos($certLatRad) * cos($userLatRad) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;


            if ($distance > $certificate->range) {
                return response()->json([
                    'message' => 'Your location is outside the allowed range for this certificate.',
                    'distance' => $distance,
                    'allowed_range' => $certificate->range,
                ], 400);
            }
        }

        $customer->certificates()->attach($id);
        return $this->success("You got certified", [
            'customer' => $customer,
            'certificate' => CertificateResource::make($certificate)
        ], 200);
    }


    // public function update(Request $request, $id)
    // {
    //     $certificate = Certificate::findOrFail($id);

    //     $data = $request->validate([
    //         'fontSize'   => 'sometimes|nullable|integer',
    //         'fontWeight' => 'sometimes|nullable|string',
    //         'family_id'  => 'sometimes|nullable|exists:families,id',
    //         'textColor'  => 'sometimes|nullable|string',
    //         'image'      => 'sometimes|nullable|string',
    //         'lat'        => 'sometimes|nullable|numeric',
    //         'long'       => 'sometimes|nullable|numeric',
    //         'expiresAt'  => 'sometimes|nullable|date',
    //     ]);

    //     $certificate->update($data);
    //     return response()->json($certificate);
    // }

    // public function destroy($id)
    // {
    //     $certificate = Certificate::findOrFail($id);
    //     $certificate->delete();
    //     return response()->json(null, 204);
    // }
}
