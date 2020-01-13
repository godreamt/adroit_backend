<?php

namespace App\Http\Controllers;

use App\UserMonthlyTarget;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\MonthlyTargetRequest;

class MonthlyTargetController extends Controller
{
    public function updateMonthlyTarget(MonthlyTargetRequest $request) {
        if(empty($request->id)) {
            $target = new UserMonthlyTarget();
        }else {
            $target = UserMonthlyTarget::find($request->id);
        }

        $target->month = $request->month;
        $target->year = $request->year;
        $target->salesTarget = $request->salesTarget;
        $target->collectionTarget = $request->collectionTarget;
        $target->user_id = $request->user_id;

        try {
            $target->save();
            return response(["Target saved successfully"]);
        }catch(\Exception $e) {
            return response(["Target can not be saved".$e->getMessage()], 400);
        }
    }

    public function getMonthlyTarget(Request $request) {
        $target = UserMonthlyTarget::leftJoin('users', 'users.id', 'user_monthly_targets.id')
                                ->select('user_monthly_targets.*', 'users.firstName', 'users.lastName');

        if(!empty($request->user_id)) {
            $target = $target->where('user_monthly_targets.user_id', $request->user_id);
        }

        if(!empty($request->month)) {
            $target = $target->where('month', $request->month);
        }

        if(!empty($request->year)) {
            $target = $target->where('year', $request->year);
        }

        $target = $target->orderBy('year', 'DESC')->orderBy('month', 'DESC');
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $target->paginate(20);
    }

    public function deleteUserMonthlyTarget(Request $request, $id) {
        try {
            $target = UserMonthlyTarget::find($id);
            $target->delete();
            return response(["Target deleted successfully"]);
        }catch(\Exception $e) {
            return response(["Target can not be deleted"], 400);
        }
    }
}
