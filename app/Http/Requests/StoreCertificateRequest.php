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
            'name'       => "required|string", // D
            'language'   => "required|string|in:en,ar", // D
            'fontSize'   => 'nullable|integer', // D
            'fontWeight' => 'nullable|string', // D
            'family_id'  => 'nullable|exists:families,id', // D
            'textColor'  => 'nullable|string', // D
            'textAlign'  => 'nullable|string|in:left,right,center,justify', // D
            'textX'      => 'required|numeric', // D 
            'textY'      => 'required|numeric', // D
            'textWidth'  => 'required|numeric', // D
            'image'      => 'required|mimes:jpeg,jpg,png,webp,svg', // D
            'lat'        => 'nullable|numeric|required_with:long,range', // D
            'long'       => 'nullable|numeric|required_with:lat,range', // D
            'range'      => 'nullable|numeric|required_with:lat,long', // D
            'expiresAt'  => 'required|date', // D
        ];
    }
}
