<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
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
    public function rules()
    {
        $user = $this->user();

        $baseRules = [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:11|min:10',
            'nickname' => 'required|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'occupation' => 'nullable|string|max:255',
        ];

        // Nếu đã là patient, thì không cho các trường quan trọng bị null
        if ($user->role->name === 'patient') {
            $baseRules['dob'] = 'required|date';
            $baseRules['gender'] = 'required|in:male,female,other';
            $baseRules['address'] = 'required|string';
            $baseRules['occupation'] = 'required|string|max:255';
        }

        return $baseRules;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
