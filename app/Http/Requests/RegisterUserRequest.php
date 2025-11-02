<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true; 
    }

   
    public function rules(): array
    {
        $identifier = $this->input('identifier');

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return [
                'name' => 'required|string|max:255',
                'identifier' => 'required|email|unique:users,email',
                'password' => ['required', 'confirmed', Password::defaults()],
            ];
        } else {
            return [
                'name' => 'required|string|max:255',
                'identifier' => 'required|regex:/^01[0-9]{9}$/|unique:users,phone',
                'password' => ['required', 'confirmed', Password::defaults()],
            ];
        }
    }

   
    public function messages(): array
    {
        return [
            'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
            'identifier.required' => 'অনুগ্রহ করে ইমেইল বা ফোন নম্বর লিখুন।',
            'identifier.email' => 'দয়া করে বৈধ ইমেইল ঠিকানা লিখুন।',
            'identifier.regex' => 'দয়া করে বৈধ ১১ অঙ্কের বাংলাদেশি ফোন নম্বর লিখুন।',
            'identifier.unique' => 'এই ইমেইল বা ফোন নম্বর ইতিমধ্যেই নিবন্ধিত।',
            'password.required' => 'অনুগ্রহ করে একটি পাসওয়ার্ড লিখুন।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ];
    }
}
