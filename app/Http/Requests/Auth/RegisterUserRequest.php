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
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email:rfc,dns|unique:users,email',
            'phone' => ['required', new BdPhoneNumberRule, 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages(): array
    {
        return [
        'name.required' => 'আপনার পূর্ণ নাম লিখুন।',
        'name.string' => 'নাম অবশ্যই সঠিক ফরম্যাটে লিখতে হবে।',
        'name.max' => 'নাম ২৫৫ অক্ষরের বেশি হতে পারবে না।',
        'email.required' => 'অনুগ্রহ করে একটি ইমেইল ঠিকানা লিখুন।',
        'email.email' => 'সঠিক ইমেইল ঠিকানা প্রদান করুন।',
        'email.unique' => 'এই ইমেইলটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
        'phone.required' => 'অনুগ্রহ করে একটি ফোন নম্বর লিখুন।',
        'phone.unique' => 'এই ফোন নম্বরটি ইতিমধ্যে ব্যবহার করা হয়েছে।',
        'password.required' => 'অনুগ্রহ করে একটি পাসওয়ার্ড লিখুন।',
        'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
    ];
    }
}
