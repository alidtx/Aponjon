<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class OtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'otp' => ['required', 'size:6'],
        ];
    }

  public function messages(): array
{
    return [
        'otp.required' => 'অনুগ্রহ করে ওটিপি লিখুন।',
        'otp.size' => 'ওটিপি অবশ্যই ৬ সংখ্যার হতে হবে।',
    ];
}
}
