<?php
namespace App\Http\Helpers;

use App\UserMonthlyTarget;

class FunctionHelper {

    public function getMonthlyTarget($date, $user_id){
        $date = new \Datetime($date);
        $month = intval($date->format('m'));
        $year = $date->format('Y');
        $monthlyTarget = UserMonthlyTarget::where('user_id', $user_id)
                                    ->where('month', $month)
                                    ->where('year',$year)
                                    ->first();
        if(!($monthlyTarget instanceof UserMonthlyTarget)){
            $monthlyTarget = new UserMonthlyTarget();
            $monthlyTarget->month = $month;
            $monthlyTarget->year = $year;
            $monthlyTarget->user_id = $user_id;
            $monthlyTarget->save();
        }
        return $monthlyTarget;
    }
}
?>