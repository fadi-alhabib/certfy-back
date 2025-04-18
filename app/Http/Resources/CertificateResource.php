<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "fontSize" => $this->fontSize,
            "fontWeight" => $this->fontWeight,
            "textColor" => $this->textColor,
            "language" => $this->language,
            "textAlign" => $this->textAlign,
            "textWidth" => $this->textWidth,
            "textX" => $this->textX,
            "textY" => $this->textY,
            "image" => $this->image,
            "lat" => $this->when(isset($this->lat),  $this->lat),
            "long" => $this->when(isset($this->long), $this->long),
            "expiresAt" => $this->expiresAt,
            "createdAt" => $this->created_at,
            "customersCount" => $this->when(isset($this->customers_count), $this->customers_count),
        ];
    }
}
