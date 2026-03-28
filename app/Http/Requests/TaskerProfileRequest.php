<?php

namespace App\Http\Requests;

use App\Rules\NidNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskerProfileRequest extends FormRequest
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
            'nid_number' => ['required', new NidNumberRule()],
            'skills' => 'required|array|min:1',
            'skills.*' => 'string',
            'experience' => 'required|string|max:500',
            'district_id' => 'required|integer|exists:districts,id',
            'zila_id' => 'required|integer',
            'upozila_id' => 'required|integer',
            'bio' => 'required|string|max:150',
            'hourly_rate' => 'required|numeric|min:0',
            'nid_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'is_terms_and_condition_accept' => 'required|boolean|accepted',
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [    
            'nid_number.required' => 'এনআইডি নম্বর প্রদান করা আবশ্যক',
            'nid_number.numeric' => 'এনআইডি নম্বরটি সঠিক ফরম্যাটে প্রদান করুন',
            'nid_number.digits_between' => 'এনআইডি নম্বরটি ১০ থেকে ১৭ অংকের মধ্যে হতে হবে',
            
            'skills.required' => 'দক্ষতা নির্বাচন করা আবশ্যক',
            'skills.array' => 'দক্ষতা সঠিক ফরম্যাটে প্রদান করুন',
            'skills.min' => 'অন্তত একটি দক্ষতা নির্বাচন করুন',
            
            'experience.required' => 'অভিজ্ঞতার বিবরণ প্রদান করা আবশ্যক',
            'experience.max' => 'অভিজ্ঞতার বিবরণ ৫০০ অক্ষরের বেশি হতে পারবে না',
            
            'district_id.required' => 'বিভাগ নির্বাচন করা আবশ্যক',
            
            'zila_id.required' => 'জেলা নির্বাচন করা আবশ্যক',
            
            'upozila_id.required' => 'উপজেলা নির্বাচন করা আবশ্যক',
            
            'bio.required' => 'সম্পর্কে বিবরণ প্রদান করা আবশ্যক',
            'bio.max' => 'সম্পর্কে বিবরণ 300 অক্ষরের বেশি হতে পারবে না',
            
            'hourly_rate.required' => 'ঘন্টাভিত্তিক মূল্য নির্ধারণ করা আবশ্যক',
            'hourly_rate.numeric' => 'ঘন্টাভিত্তিক মূল্য সঠিক ফরম্যাটে প্রদান করুন',
            'hourly_rate.min' => 'ঘন্টাভিত্তিক মূল্য ০ টাকার কম হতে পারবে না',
            
            'nid_front.required' => 'এনআইডির সামনের ছবি আপলোড করা আবশ্যক',
            'nid_front.file' => 'এনআইডির সামনের ছবি সঠিক ফরম্যাটে আপলোড করুন',
            'nid_front.mimes' => 'এনআইডির সামনের ছবি jpg, jpeg, png বা pdf ফরম্যাটে হতে হবে',
            'nid_front.max' => 'এনআইডির সামনের ছবি ২ এমবির বেশি হতে পারবে না',
            
            'nid_back.required' => 'এনআইডির পিছনের ছবি আপলোড করা আবশ্যক',
            'nid_back.file' => 'এনআইডির পিছনের ছবি সঠিক ফরম্যাটে আপলোড করুন',
            'nid_back.mimes' => 'এনআইডির পিছনের ছবি jpg, jpeg, png বা pdf ফরম্যাটে হতে হবে',
            'nid_back.max' => 'এনআইডির পিছনের ছবি ২ এমবির বেশি হতে পারবে না',
            
            'is_terms_and_condition_accept.required' => 'শর্তাবলী গ্রহণ করা আবশ্যক',
            'is_terms_and_condition_accept.accepted' => 'শর্তাবলী গ্রহণ করতে হবে',
            'is_terms_and_condition_accept.boolean' => 'শর্তাবলী সঠিক ফরম্যাটে প্রদান করুন',
        ];
    }
}