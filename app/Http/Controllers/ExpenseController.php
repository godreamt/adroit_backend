<?php

namespace App\Http\Controllers;

use App\ExpenseTracker;
use Illuminate\Http\Request;
use App\Http\Helpers\FunctionHelper;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ExpenseAddRequest;
use App\Http\Requests\ExpenseStatusChangeRequest;

class ExpenseController extends Controller
{
    public function makeExpense(ExpenseAddRequest $request) {
        return \DB::transaction(function() use ($request) {
            try {
                $expense = new ExpenseTracker();
                $expense->title = $request->title;
                $expense->description = $request->description;
                $expense->expenseAmount = $request->expenseAmount;
                $expense->expenseDate = new \Datetime();
                $expense->user_id = (empty($request->user_id))?\Auth::user()->id:$request->user_id;
                 
                if(!empty($request->documentImage)) {
                    $mimetype=mime_content_type($request['documentImage']);
                    if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                        return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
                    }
                    
                    $base64_str = substr($request->documentImage, strpos($request->documentImage, ",")+1);
                    $image = base64_decode($base64_str);
                    $imageName = "expense_doc".uniqid().".png";
                    \File::put(public_path(). '/uploads/expense/' . $imageName, $image);
                    $expense->documentImage='/uploads/expense/' . $imageName;
                    // file_put_contents($destinationPath.$category->slug.".png", $image);
                }else {
                    if(empty($request->id)) {
                        return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
                    }
                }

                $expense->save();
                return \response(["Expense requested successfully"]);
            }catch(\Exception $e) {
                return response(["Can not request expense".$e->getMessage()], 400);
            }
        });
    }

    public function getAllExpenses(Request $request) {
        $user = \Auth::user();

        $expense = ExpenseTracker::leftJoin('users', 'users.id', 'expense_trackers.user_id')
                                ->select('expense_trackers.*', 'users.id as userId')
                                ->addSelect(\DB::raw("CONCAT(users.firstName,' ', COALESCE(users.lastName,'')) as userName"));

        if($user->roles != 'admin') {
            $expense = $expense->where('users.id', $user->id);
        }

        if(!empty($request->searchText)){
            $expense = $expense->where(function($query)use($request) {
                $query->where('expense_trackers.title', 'LIKE', '%'.$request->searchText."%");
            });
        }

        if(!empty($request->approvedStatus)) {
            $expense = $expense->where('status', $request->approvedStatus);
        }

        if(!empty($request->user_id)) {
            $expense = $expense->where('user_id', $request->user_id);
        }

        if(!empty($request->month)) {
            $expense = $expense->whereMonth('expenseDate', $request->month);
        }

        if(!empty($request->year)) {
            $expense = $expense->whereYear('expenseDate', $request->year);
        }

        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $expense->orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getSingleExpense(Request $request, $id) {
        return ExpenseTracker::leftJoin('users', 'users.id', 'expense_trackers.user_id')
                        ->select('expense_trackers.*', 'users.id as userId')
                        ->addSelect(\DB::raw("CONCAT(users.firstName,' ', COALESCE(users.lastName,'')) as userName"))
                        ->where('expense_trackers.id', $id)
                        ->first();
    }

    public function changeStatusOfExpense(ExpenseStatusChangeRequest $request) {
        return \DB::transaction(function() use ($request) {
            try {
                $helper = new FunctionHelper();
                $expense = ExpenseTracker::find($request->id);
                $expense->status = $request->status;

                if($request->status == 'approved'){
                    if(empty($request->allocatedAmount)){
                        return response(["Please enter allocated amount"], 400);
                    }

                    $expense->allocatedAmount = $request->allocatedAmount;
                    $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $expense->user_id);
                    $monthlyTarget->expenseAmount = (float)$monthlyTarget->expenseAmount + (float)$request->allocatedAmount;
                    $monthlyTarget->save();
                }
                $expense->save();
                return response(["Status updated successfully"]);
            }catch(\Exception $e){
                return response(["Can not change status"], 400);
            }
        });
    }
}
