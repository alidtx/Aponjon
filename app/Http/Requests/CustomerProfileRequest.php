<?php

namespace App\Http\Requests;

use App\Rules\NidNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerProfileRequest extends FormRequest
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
            'district_id' => 'required|integer|exists:districts,id',
            'zila_id' => 'required|integer',
            'upozila_id' => 'required|integer',
            'nid_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'nid_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'person_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
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

            'district_id.required' => 'বিভাগ নির্বাচন করা আবশ্যক',
            'zila_id.required' => 'জেলা নির্বাচন করা আবশ্যক',
            'upozila_id.required' => 'উপজেলা নির্বাচন করা আবশ্যক',
                     
            'nid_front.required' => 'এনআইডির সামনের ছবি আপলোড করা আবশ্যক',
            'nid_front.file' => 'এনআইডির সামনের ছবি সঠিক ফরম্যাটে আপলোড করুন',
            'nid_front.mimes' => 'এনআইডির সামনের ছবি jpg, jpeg, png ফরম্যাটে হতে হবে',
            'nid_front.max' => 'এনআইডির সামনের ছবি ২ এমবির বেশি হতে পারবে না',
            
            'nid_back.required' => 'এনআইডির পিছনের ছবি আপলোড করা আবশ্যক',
            'nid_back.file' => 'এনআইডির পিছনের ছবি সঠিক ফরম্যাটে আপলোড করুন',
            'nid_back.mimes' => 'এনআইডির পিছনের ছবি jpg, jpeg, png ফরম্যাটে হতে হবে',
            'nid_back.max' => 'এনআইডির পিছনের ছবি ২ এমবির বেশি হতে পারবে না',

            'person_image.required' => 'আপনার ব্যক্তিগত ছবি আপলোড করা আবশ্যক',
            'person_image.file' => 'ব্যক্তিগত ছবি সঠিক ফরম্যাটে আপলোড করুন',
            'person_image.mimes' => 'ব্যক্তিগত ছবি jpg, jpeg, png ফরম্যাটে হতে হবে',
            'person_image.max' => 'ব্যক্তিগত ছবি ২ এমবির বেশি হতে পারবে না',
        ];
    }
}