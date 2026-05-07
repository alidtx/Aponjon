<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelBidRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust authorization logic as needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cancellation_reason' => 'required|string|min:5|max:100'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'cancellation_reason' => 'বাতিলের কারণ'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'cancellation_reason.required' => 'বাতিলের কারণ উল্লেখ করা আবশ্যক।',
            'cancellation_reason.string' => 'বাতিলের কারণ অবশ্যই টেক্সট হতে হবে।',
            'cancellation_reason.min' => 'বাতিলের কারণ কমপক্ষে ৫ অক্ষরের হতে হবে।',
            'cancellation_reason.max' => 'বাতিলের কারণ সর্বোচ্চ ১০০ অক্ষরের হতে পারে।',
        ];
    }
}