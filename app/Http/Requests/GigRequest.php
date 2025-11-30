<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GigRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:100',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'emergency' => 'required|string|in:normal,urgent,emergency,other',
            'category_id' => 'required|exists:categories,id',
            'district_id' => 'required|exists:districts,id',
            'zila_id' => 'required|exists:zilas,id',
            'upozila_id' => 'required|exists:upozilas,id',
            'location_address' => 'required|string|max:500'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'টাস্কের শিরোনাম প্রয়োজন',
            'title.string' => 'টাস্কের শিরোনাম বৈধ হতে হবে',
            'title.max' => 'টাস্কের শিরোনাম ১০০ অক্ষরের বেশি হতে পারবে না',
            
            'description.required' => 'বিস্তারিত বর্ণনা প্রয়োজন',
            'description.string' => 'বিস্তারিত বর্ণনা বৈধ হতে হবে',
            
            'budget.required' => 'আনুমানিক বাজেট প্রয়োজন',
            'budget.numeric' => 'বাজেট একটি সংখ্যা হতে হবে',
            'budget.min' => 'বাজেট ১ টাকার বেশি হতে হবে',
            
            'emergency.required' => 'জরুরিতা নির্বাচন করুন',
            'emergency.string' => 'জরুরিতা বৈধ হতে হবে',
            'emergency.in' => 'বৈধ জরুরিতা নির্বাচন করুন',
            
            'category_id.required' => 'ক্যাটাগরি নির্বাচন করুন',
            'category_id.exists' => 'বৈধ ক্যাটাগরি নির্বাচন করুন',
            
            'district_id.required' => 'বিভাগ নির্বাচন করুন',
            'district_id.exists' => 'বৈধ বিভাগ নির্বাচন করুন',
            
            'zila_id.required' => 'জেলা নির্বাচন করুন',
            'zila_id.exists' => 'বৈধ জেলা নির্বাচন করুন',
            
            'upozila_id.required' => 'উপজেলা নির্বাচন করুন',
            'upozila_id.exists' => 'বৈধ উপজেলা নির্বাচন করুন',
            
            'location_address.required' => 'সম্পূর্ণ ঠিকানা প্রয়োজন',
            'location_address.string' => 'ঠিকানা বৈধ হতে হবে',
            'location_address.max' => 'ঠিকানা ২০০ অক্ষরের বেশি হতে পারবে না'
        ];
    }
}
