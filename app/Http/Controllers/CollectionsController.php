<?php

namespace App\Http\Controllers;

use App\User;
use App\Orders;
use App\Collections;
use App\Http\Helpers\FunctionHelper;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\AcceptCollectionRequest;
use App\Http\Requests\MakeNewCollectionRequest;

class CollectionsController extends Controller
{
    public function makeNewCollection(MakeNewCollectionRequest $request) {
        return \DB::transaction(function() use ($request) {
            try {
                $user = \Auth::user();

                if(empty($request->relatedInfo) && $request->paymentMethod != 'cash'){
                    return response(['Add cheque number/Neft/DD details'], 400);
                }
    
                $order = Orders::find($request->order_id);
                $vendor = User::find($order->vendor_id);
    
                $collection = new Collections();
                
                $lastAutoId = Collections::orderBy('id', 'DESC')->first();
                $collectionId=100000001;
                if($lastAutoId instanceof Collections){
                    $collectionId = ((int)$lastAutoId->autoId) + 1;
                }

                $collection->autoId = $collectionId;

                $collection->collectionAmount = $request->collectionAmount;
                $collection->paymentMethod = $request->paymentMethod;
                $collection->relatedInfo = $request->relatedInfo;
                $collection->paymentStatus = 'pending';
                $collection->comments = $request->comments;
                $collection->order_id = $order->id;
                $collection->vendor_id = $vendor->id;
                $collection->collect_by = $user->id;
                $collection->save();
                return response(["Collection saved successfully"]);
            }catch(\Exception $e) {
                return response(["Can not save collection now"],400);
            }
        });
    }

    public function getCollections(Request $request) {
        $user = \Auth::user();

        $collection = Collections::leftJoin('users as collectUser', 'collectUser.id', 'collections.collect_by')
                            ->leftJoin('users as vendors', 'vendors.id', 'collections.vendor_id')
                            ->select('collections.*')
                            ->addSelect(\DB::raw("CONCAT(collectUser.firstName,' ', COALESCE(collectUser.lastName,'')) as collectUserName"))
                            ->addSelect(\DB::raw("CONCAT(vendors.firstName,' ', COALESCE(vendors.lastName,'')) as vendorUserName"));

        if($user->roles == 'sales_executive') {
            $collection = $collection->where('collect_by', $user->id);
        }else if($user->roles == 'regional_head') {
            $underUsers = User::where('region_id', $user->region_id)->get();
            $collection = $collection->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('collect_by', $user->id);
                }
            });
        }else if($user->roles == 'state_head') {
            $underUsers = User::where('state_id', $user->state_id)->get();
            $collection = $collection->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('collect_by', $user->id);
                }
            });
        }else if($user->roles == 'country_head') {
            $underUsers = User::where('country_id', $user->country_id)->get();
            $collection = $collection->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('collect_by', $user->id);
                }
            });
        }else if($user->roles == 'vendors') {
            $collection = $collection->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('vendor_id', $user->id);
                }
            });
        }

        
        if(!empty($request->searchText)){
            $collection = $collection->where(function($query)use($request) {
                $query->where('collections.autoId', 'LIKE', '%'.$request->searchText."%");
            });
        }

        if(!empty($request->paymentStatus)) {
            $collection = $collection->where('paymentStatus', $request->paymentStatus);
        }

        if(!empty($request->collect_by)) {
            $collection = $collection->where('collect_by', $request->collect_by);
        }

        if(!empty($request->vendor_id)) {
            $collection = $collection->where('vendor_id', $request->vendor_id);
        }

        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $collection->orderBy('created_at', 'DESC')->paginate(15);
    }

    public function getSingleCollection(Request $request, $id) {
        $collection = Collections::find($id);
        $collection['vendor'] = User::leftJoin('countries', 'countries.id', 'users.country_id')
                                ->leftJoin('states', 'states.id', 'users.state_id')
                                ->leftJoin('regions', 'regions.id', 'users.region_id')
                                ->leftJoin('areas', 'areas.id', 'users.area_id')
                                ->select('users.*', 'states.state', 'countries.country', 'regions.region', 'areas.area')
                                ->where('users.id', $collection->vendor_id)
                                ->first();
        $collection['collector'] = User::find($collection->collect_by);
        $collection['order'] = Orders::find($collection->order_id);

        return $collection;
    }

    public function changeCollectionStatus(AcceptCollectionRequest $request) {
        return \DB::transaction(function() use ($request) {
            try {
                $collection = Collections::find($request->id);
                $vendor = User::find($collection->vendor_id);
                $collector = User::find($collection->collect_by);
                $order = Orders::find($collection->order_id);
                $helper = new FunctionHelper();
                $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $collector->id);
                $todaysDate = new \Datetime();
                $collectionDate = new \Datetime($order->deliveredDate);
                $difference = $todaysDate->diff($collectionDate);
                $differenceDays=$difference->days;
                //calculate incentives based on days diff
                if($collection->paymentStatus != 'pending'){
                    return response(['Collection process already closed'], 400);
                }
                if($request->status == 'processed') {
                    if((float)$collection->collectionAmount > (float)$order->balanceAmount) {
                        return response(["Check order pending amount"], 400);
                    }
                    $orderPoints = (int)$order->totalPoints;
                    if($differenceDays > 45 && $differenceDays <= 60){
                        $orderPoints = (int)$orderPoints * 0.2;
                    }else if($differenceDays > 60){
                        $orderPoints=0;
                    }
                    $currentPercentage = ((float)$collection->collectionAmount * 100)/(float)$order->totalOrderAmount;
                    $currentPoints = ($currentPercentage * $orderPoints)/100;
                    $this->handlePointDistribution($collector, $currentPoints);
                    $order->paidAmount = (float)$order->paidAmount + (float)$collection->collectionAmount;
                    $order->balanceAmount = (float)$order->balanceAmount - (float)$collection->collectionAmount;

                    $vendor->vendorBalanceAmount = (float)$vendor->vendorBalanceAmount - (float)$collection->collectionAmount;
                    $monthlyTarget->collectionTargetReached = (float)$monthlyTarget->collectionTargetReached + (float)$collection->collectionAmount;
                }
                $collection->paymentStatus = $request->status;
                $collection->save();
                $vendor->save();
                $monthlyTarget->save();
                $order->save();
                return response(["Collection processed successfully"]);
            }catch(exception $e) {
                return response(["Can not change the status now"], 400);
            }
        });
    }


    public function handlePointDistribution($user, $points){
        $helper = new FunctionHelper();
        if($user->roles == 'sales_executive'){
            $fiftyPercent = $points * 0.5;
            $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $user->id);
            $monthlyTarget->collectedPoints = (float)$monthlyTarget->collectedPoints + $fiftyPercent;
            $monthlyTarget->save();
            //find Regional managers

            $regionalHead = User::where('region_id', $user->region_id)->where('roles', 'regional_head')->get();
            $twentyPercent = $points*0.2;
            if(sizeof($regionalHead) > 0){
                $twentyPercent = $twentyPercent / sizeof($regionalHead);
                foreach($regionalHead as $head){
                    $headMonthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $head->id);
                    $headMonthlyTarget->collectedPoints = (float)$headMonthlyTarget->collectedPoints + $fiftyPercent;
                    $headMonthlyTarget->save();
                }
            }


            $stateHead = User::where('state_id', $user->state_id)->where('roles', 'state_head')->get();
            $twentyPercent = $points*0.1;
            if(sizeof($stateHead) > 0){
                $twentyPercent = $twentyPercent / sizeof($stateHead);
                foreach($stateHead as $head){
                    $headMonthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $head->id);
                    $headMonthlyTarget->collectedPoints = (float)$headMonthlyTarget->collectedPoints + $fiftyPercent;
                    $headMonthlyTarget->save();
                }
            }
        }else if($user->roles == 'regional_head'){
            $twentyPercent = $points * 0.2;
            $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $user->id);
            $monthlyTarget->collectedPoints = (float)$monthlyTarget->collectedPoints + $twentyPercent;
            $monthlyTarget->save();

            $stateHead = User::where('state_id', $user->state_id)->where('roles', 'state_head')->get();
            $twentyPercent = $points*0.1;
            if(sizeof($stateHead)){
                $twentyPercent = $twentyPercent / sizeof($stateHead);
                foreach($stateHead as $head){
                    $headMonthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $head->id);
                    $headMonthlyTarget->collectedPoints = (float)$headMonthlyTarget->collectedPoints + $fiftyPercent;
                    $headMonthlyTarget->save();
                }
            }
        }else if($user->roles == 'state_head'){
            $twentyPercent = $points * 0.1;
            $monthlyTarget = $helper->getMonthlyTarget((new \Datetime())->format('Y-m-d'), $user->id);
            $monthlyTarget->collectedPoints = (float)$monthlyTarget->collectedPoints + $twentyPercent;
            $monthlyTarget->save();
        }
    }
}
