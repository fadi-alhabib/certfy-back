<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertfyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fullNameEn" => "nullable|string|max:255",
            "fullNameAr" => "nullable|string|max:255",
            "email"      => "required|email|unique:customers,email",
            "lat"        => "required|numeric",
            "long"       => "required|numeric",
        ];
    }
}
