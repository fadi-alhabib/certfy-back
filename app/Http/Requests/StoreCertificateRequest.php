<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => "required|string",
            'language'   => "required|string|in:en,ar",
            'fontSize'   => 'nullable|integer',
            'fontWeight' => 'nullable|string',
            'family_id'  => 'nullable|exists:families,id',
            'textColor'  => 'nullable|string',
            'textAlign'  => 'nullable|string|in:left,right,center,justify',
            'textX'      => 'required|numeric',
            'textY'      => 'required|numeric',
            'textWidth'  => 'required|numeric',
            'image'      => 'required|mimes:jpeg,jpg,png,webp,svg',
            'lat'        => 'nullable|numeric|required_with:long,range',
            'long'       => 'nullable|numeric|required_with:lat,range',
            'range'      => 'nullable|numeric|required_with:lat,long',
            'expiresAt'  => 'required|date',
        ];
    }
}
