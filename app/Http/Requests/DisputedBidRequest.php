<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisputedBidRequest extends FormRequest
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
            'dispute_reason' => 'required|string|min:5|max:100' // Changed from cancellation_reason to dispute_reason
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
            'dispute_reason' => 'বিতর্কের কারণ' // Changed to Bengali for dispute
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
            'dispute_reason.required' => 'বিতর্কের কারণ উল্লেখ করা আবশ্যক।',
            'dispute_reason.string' => 'বিতর্কের কারণ অবশ্যই টেক্সট হতে হবে।',
            'dispute_reason.min' => 'বিতর্কের কারণ কমপক্ষে ৫ অক্ষরের হতে হবে।',
            'dispute_reason.max' => 'বিতর্কের কারণ সর্বোচ্চ 100 অক্ষরের হতে পারে।',
        ];
    }
}