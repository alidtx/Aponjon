<?php

namespace App\Services;

use App\Models\TaskerProfile;
use Illuminate\Support\Facades\DB;
use App\Services\MediaService;
use App\Models\Bid;

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
             if ($request->hasFile('person_image')) {

                MediaService::deleteByName($tasker, 'Person Image');
            
                MediaService::upload(
                    file: $request->file('person_image'),
                    path: 'customer/documents',
                    name: 'Peron Image',
                    fileable: $tasker
                );
            }
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
  public static function TaskerDashboardOverView()  {

  $taskerDashboardoverView = Bid::with('tasker:id,name','task:id,title,location_address,status,budget')
    ->where('tasker_id', auth()->user()->id)
    ->select('id','task_id','tasker_id','estimated_hours','availability','amount')
    ->get();
   return $taskerDashboardoverView;

 }


}
