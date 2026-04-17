<?php

namespace App\Services;

use App\Models\CustomerProfile;
use Illuminate\Support\Facades\DB;
use App\Services\MediaService;


class CustomerService
{   
 public static function storeCustomerProfile($request)
    {
        DB::beginTransaction();
        try {
            $customer = CustomerProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'nid_number' => $request->nid_number,
                    'district_id' => $request->district_id,
                    'zila_id' => $request->zila_id,
                    'upozila_id' => $request->upozila_id,
                ]
            );

            if ($request->hasFile('person_image')) {

                MediaService::deleteByName($customer, 'Person Image');
            
                MediaService::upload(
                    file: $request->file('person_image'),
                    path: 'customer/documents',
                    name: 'Peron Image',
                    fileable: $customer
                );
            }

            if ($request->hasFile('nid_front')) {

                MediaService::deleteByName($customer, 'NID Front');
            
                MediaService::upload(
                    file: $request->file('nid_front'),
                    path: 'customer/documents',
                    name: 'NID Front',
                    fileable: $customer
                );
            }

            if ($request->hasFile('nid_back')) {
                MediaService::deleteByName($customer, 'NID Back');

                MediaService::upload(
                    file: $request->file('nid_back'),
                    path: 'customer/documents',
                    name: 'NID Back',
                    fileable: $customer
                );
            }
            auth()->user()->update(['is_profile_completed' => true]);
            
            DB::commit();
            
            return $customer;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
