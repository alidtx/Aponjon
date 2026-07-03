<?php

namespace App\Http\Requests;

use App\Models\Bid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class BidRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'task_id' => ['required', 'integer'],
            'bid_amount' => ['required', 'numeric', 'min:100', 'max:100000'],
            'availability' => ['required', 'in:today,tomorrow,specific'],
            'specific_date' => [
                'exclude_unless:availability,specific',
                'required',
                'date',
                'after_or_equal:today',
            ],
            'proposal' => ['nullable', 'string', 'max:3000'],
            'terms_accepted' => ['required', 'accepted'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $taskId = $this->input('task_id');
            $taskerId = $this->user()?->id;

            if (!$taskId || !$taskerId) {
                return;
            }

            $alreadyBid = Bid::where('task_id', $taskId)
                ->where('tasker_id', $taskerId)
                ->exists();

            if ($alreadyBid) {
                $validator->errors()->add('task_id', 'আপনি এই কাজটিতে ইতোমধ্যে আবেদন করেছেন। একই কাজের জন্য আবার বিড করা যাবে না।');
            }
        });
    }

    public function messages(): array
    {
        return [
            'task_id.required' => 'কোন কাজের জন্য বিড করছেন তা সঠিকভাবে পাওয়া যায়নি।',
            'bid_amount.required' => 'অনুগ্রহ করে আপনার প্রস্তাবিত টাকার পরিমাণ লিখুন।',
            'bid_amount.numeric' => 'প্রস্তাবিত টাকার পরিমাণ অবশ্যই সংখ্যা হতে হবে।',
            'bid_amount.min' => 'সর্বনিম্ন বিডের পরিমাণ ১০০ টাকা হতে হবে।',
            'bid_amount.max' => 'বিডের পরিমাণ সর্বোচ্চ ১০,০০,০০০ টাকার বেশি হতে পারবে না।',
            'availability.required' => 'কখন কাজ শুরু করতে পারবেন তা নির্বাচন করুন।',
            'availability.in' => 'অনুগ্রহ করে সঠিক সময়সূচী নির্বাচন করুন।',
            'specific_date.required' => 'নির্দিষ্ট তারিখ নির্বাচন করলে অবশ্যই একটি তারিখ দিতে হবে।',
            'specific_date.date' => 'অনুগ্রহ করে একটি সঠিক তারিখ নির্বাচন করুন।',
            'specific_date.after_or_equal' => 'নির্বাচিত তারিখ আজ বা তার পরের দিন হতে হবে।',
            'proposal.string' => 'প্রস্তাবনা অবশ্যই লেখার আকারে হতে হবে।',
            'proposal.max' => 'প্রস্তাবনা সর্বোচ্চ 3000 অক্ষরের মধ্যে হতে হবে।',
            'terms_accepted.required' => 'শর্তাবলী ও নীতিমালা মেনে নেওয়া আবশ্যক।',
            'terms_accepted.accepted' => 'বিড জমা দিতে হলে শর্তাবলী ও নীতিমালা মেনে নিতে হবে।',
        ];
    }
}
