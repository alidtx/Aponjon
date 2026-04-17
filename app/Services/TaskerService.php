<?php

namespace App\Services;

use App\Models\TaskerProfile;
use Illuminate\Support\Facades\DB;
use App\Services\MediaService;


class TaskerService
{   
 public static function storeTaskerProfile($request)
    {
        DB::beginTransaction();
        try {
            $tasker = TaskerProfile::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'nid_number' => $request->nid_number,
                    'bio' => $request->bio,
                    'skill' => $request->skills,
                    'experience' => $request->experience,
                    'district_id' => $request->district_id,
                    'zila_id' => $request->zila_id,
                    'upozila_id' => $request->upozila_id,
                    'hourly_rate' => $request->hourly_rate,
                    'document' => $request->document,
                ]
            );

            if ($request->hasFile('nid_front')) {

                MediaService::deleteByName($tasker, 'NID Front');
            
                MediaService::upload(
                    file: $request->file('nid_front'),
                    path: 'tasker/documents',
                    name: 'NID Front',
                    fileable: $tasker
                );
            }

            if ($request->hasFile('nid_back')) {
                MediaService::deleteByName($tasker, 'NID Back');

                MediaService::upload(
                    file: $request->file('nid_back'),
                    path: 'tasker/documents',
                    name: 'NID Back',
                    fileable: $tasker
                );
            }
            auth()->user()->update(['is_profile_completed' => true]);
            
            DB::commit();
            
            return $tasker;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
