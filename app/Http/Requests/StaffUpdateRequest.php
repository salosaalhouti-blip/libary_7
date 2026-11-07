<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StaffUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"         => "sometimes|required|string", // تصحيح =>
            "email"        => "sometimes|required|email|unique:staff,email," . $staff->id,
            "password"     => "sometimes|required|string|min:8", // تصحيح min:8
            "role"         => "sometimes|required|string",
            "phone_number" => "sometimes|required|string|unique:staff,phone_number," . $staff->id,
        ];
    }
}
