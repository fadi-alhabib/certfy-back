<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerCertificateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'certificate_id' => $this->id,
            'certificate_name' => $this->name,
            'certificate_image' => $this->image,
            'customers' => $this->customers->map(function ($customer) {
                return [
                    'customer_name_en' => $customer->fullNameEn,
                    'customer_name_ar' => $customer->fullNameAr,
                    'customer_email' => $customer->email,
                    'pivot_id' => $customer->pivot->id,
                    'isRevoked' => $customer->pivot->isRevoked,
                    'issued_at' => $customer->pivot->created_at,
                ];
            })->sortByDesc('issued_at')->values(),
        ];
    }
}
