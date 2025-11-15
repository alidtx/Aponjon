<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use App\Rules\BdPhoneNumberRule;

class RegisterUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true; 
    }

   
   public function rules(): array
{
    $identifier = $this->input('identifier');

    if (preg_match('/^\d+$/', $identifier)) {
        return [
            'name' => 'required|string|max:255',
            'identifier' => ['required', new BdPhoneNumberRule, 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
    return [
        'name' => 'required|string|max:255',
        'identifier' => 'required|email:rfc,dns|unique:users,email',
        'password' => ['required', 'confirmed', Password::defaults()],
    ];
}

public function messages(): array
{
    $identifier = $this->input('identifier');

    $commonMessages = [
        'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
        'password.required' => 'অনুগ্রহ করে একটি পাসওয়ার্ড লিখুন।',
        'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
    ];

    if (preg_match('/^\d+$/', $identifier)) {
        return $commonMessages + [
            'identifier.required' => 'অনুগ্রহ করে ফোন নম্বর লিখুন।',
            'identifier.unique' => 'এই ফোন নম্বর ইতিমধ্যেই নিবন্ধিত।',
        ];
    } else {
        return $commonMessages + [
            'identifier.required' => 'অনুগ্রহ করে ইমেইল লিখুন।',
            'identifier.email' => 'দয়া করে বৈধ ইমেইল ঠিকানা লিখুন।',
            'identifier.unique' => 'এই ইমেইল ইতিমধ্যেই নিবন্ধিত।',
        ];
    }
}

}
