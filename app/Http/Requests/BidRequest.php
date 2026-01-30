<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'bid_amount'       => ['required', 'numeric', 'min:100', 'max:1000000'],
            'availability'     => ['required', 'in:today,tomorrow,specific'],
            'specific_date'    => ['required_if:availability,specific', 'date', 'after_or_equal:today'],
            'proposal'         => ['nullable', 'string', 'max:3000'],
            'terms_accepted'   => ['required', 'accepted'],
        ];
    }

    /**
     * Custom Bangla validation messages
     */
    public function messages(): array
    {
        return [
            'bid_amount.required' => 'অনুগ্রহ করে আপনার প্রস্তাবিত টাকার পরিমাণ লিখুন।',
            'bid_amount.numeric'  => 'প্রস্তাবিত টাকার পরিমাণ অবশ্যই সংখ্যা হতে হবে।',
            'bid_amount.min'      => 'সর্বনিম্ন বিডের পরিমাণ ১০০ টাকা হতে হবে।',
            'bid_amount.max'      => 'বিডের পরিমাণ সর্বোচ্চ ১০,০০,০০০ টাকার বেশি হতে পারবে না।',

            'availability.required' => 'কখন কাজ শুরু করতে পারবেন তা নির্বাচন করুন।',
            'availability.in'       => 'অনুগ্রহ করে সঠিক সময়সূচী নির্বাচন করুন।',

            'specific_date.required_if' => 'নির্দিষ্ট তারিখ নির্বাচন করলে অবশ্যই একটি তারিখ দিতে হবে।',
            'specific_date.date'        => 'অনুগ্রহ করে একটি সঠিক তারিখ নির্বাচন করুন।',
            'specific_date.after_or_equal' => 'নির্বাচিত তারিখ আজ বা তার পরের দিন হতে হবে।',


            'proposal.string' => 'প্রস্তাবনা অবশ্যই লেখার আকারে হতে হবে।',
            'proposal.max'    => 'প্রস্তাবনা সর্বোচ্চ 300 অক্ষরের মধ্যে হতে হবে।',

            'terms_accepted.required' => 'শর্তাবলী ও নীতিমালা মেনে নেওয়া আবশ্যক।',
            'terms_accepted.accepted' => 'বিড জমা দিতে হলে শর্তাবলী ও নীতিমালা মেনে নিতে হবে।',
        ];
    }
}
