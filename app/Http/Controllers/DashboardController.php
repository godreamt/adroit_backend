<?php

namespace App\Http\Controllers;

use App\Orders;
use App\Collections;
use App\ExpenseTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\FunctionHelper;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getSalesExecutive(Request $request){
        $helper = new FunctionHelper();
        $user = Auth::user();
        $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $user->id);

        $latestPurchase = Orders::leftJoin('users as soldUser', 'soldUser.id', 'orders.sold_by')
                        ->leftJoin('users as vendors', 'vendors.id', 'orders.vendor_id')
                        ->select('orders.*')
                        ->addSelect(DB::raw("CONCAT(soldUser.firstName,' ', COALESCE(soldUser.lastName,'')) as soldUserName"))
                        ->addSelect(DB::raw("CONCAT(vendors.firstName,' ', COALESCE(vendors.lastName,'')) as vendorUserName"))
                        ->where('soldUser.id', $user->id)
                        ->orderBy('created_at', 'DESC')->limit(5)->get();
        
        $latestCollection = Collections::leftJoin('users as collectUser', 'collectUser.id', 'collections.collect_by')
                        ->leftJoin('users as vendors', 'vendors.id', 'collections.vendor_id')
                        ->select('collections.*')
                        ->addSelect(DB::raw("CONCAT(collectUser.firstName,' ', COALESCE(collectUser.lastName,'')) as collectUserName"))
                        ->addSelect(DB::raw("CONCAT(vendors.firstName,' ', COALESCE(vendors.lastName,'')) as vendorUserName"))
                        ->orderBy('created_at', 'DESC')->limit(5)->get()
                        ->where('collect_by', $user->id);
        
        $latestExpense = ExpenseTracker::leftJoin('users', 'users.id', 'expense_trackers.user_id')
                        ->select('expense_trackers.*', 'users.id as userId')
                        ->addSelect(DB::raw("CONCAT(users.firstName,' ', COALESCE(users.lastName,'')) as userName"))
                        ->where('users.id', $user->id)
                        ->orderBy('created_at', 'DESC')->limit(5)->get();

        return response([
            'target' => $monthlyTarget,
            'purchase' => $latestPurchase,
            'collection' => $latestCollection,
            'expense' => $latestExpense
        ]);
    }
}
