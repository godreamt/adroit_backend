<?php

namespace App\Http\Controllers;

use App\User;
use App\Orders;
use App\Products;
use App\OrderItem;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    public function makeOrder(OrderRequest $request) {
        return \DB::transaction(function() use ($request) {
            try {
                $order = new Orders();


                $vendor = User::find($request->vendor_id);
                if($vendor->roles != 'vendors'){
                    return response(["Invalid vendor selected"], 400);
                }

                $lastAutoId = Orders::orderBy('id', 'DESC')->first();
                $orderId=100000001;
                if($lastAutoId instanceof Orders){
                    $orderId = ((int)$lastAutoId->autoId) + 1;
                }

                $order->autoId = $orderId;
                $order->vendor_id = $vendor->id;
                $order->sold_by = \Auth::user()->id;
                $order->save();
                $grandTotal = 0;
                $grandPointsTotal = 0;
                foreach($request->items as $item) {
                    $product = Products::leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
                                    ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
                                    ->select('products.*', 'categories.title as category', 'categories.id as catId', 'sub_categories.id as suCatId', 'sub_categories.title as subCategory')
                                    ->where('products.id',$item['product_id'])
                                    ->first();
                    if(!empty($product)) {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->productDetails = json_encode(
                            [
                                'id'=>$product->id,
                                'productName' => $product->title,
                                'offerPrice' => $product->offerPrice,
                                'regularPrice' => $product->regularPrice,
                                'salesPoints' => $product->salesPoints,
                                'featuredImage' => $product->featuredImage,
                                'catId' => $product->catId,
                                'subCatId' => $product->suCatId,
                                'category' => $product->category,
                                'subCategory' => $product->subCategory,
                            ]);
                        $orderItem->productPrice = $product->regularPrice;
                        $orderItem->quantity = $item['quantity'];
                        $orderItem->totalPrice = ((float)$orderItem->productPrice) * ((int)$orderItem->quantity);
                        $grandTotal += $orderItem->totalPrice; 
                        $grandPointsTotal += (float) $product->salesPoints * ((int)$orderItem->quantity); 
                        $orderItem->save();
                    }
                }

                $order->totalAmount = $grandTotal;
                $order->totalOrderAmount = $grandTotal;
                $order->balanceAmount = $order->totalOrderAmount;
                $order->totalPoints = $grandPointsTotal;
                $order->comments = $request->comments;

                $order->save();
                return \response(["Order made successfully"]);
            }catch(\Exception $e) {
                return response(["Can not make order".$e->getMessage()], 400);
            }
        });
    }

    public function updateOrderStatus(UpdateOrderStatusRequest $request){
        return \DB::transaction(function() use ($request) {
            try {
                $user = \Auth::user();
                if($user->roles != 'admin') {
                    return response(["Unauthorised access"], 400);
                }
                $order = Orders::find($request->id);
                if($order->orderStatus != 'new' && $order->orderStatus != 'approved') {
                    return response(["Can not change status of old order"], 400);
                }
                if($order->orderStatus == 'new' && $request->status == 'approved') {
                    $order->approvedDate = new \Datetime();
                    $vendor = User::find($order->vendor_id);
                    $vendor->vendorBalanceAmount = ((float) $vendor->vendorBalanceAmount) + ((float)$order->totalOrderAmount);
                    $vendor->save();
                    $order->orderStatus = $request->status;
                }else if($order->orderStatus == 'approved' && $request->status == 'delivered') {
                    $order->deliveredDate = new \Datetime();
                    $order->orderStatus = $request->status;
                }else if($order->orderStatus == 'new'){
                    $order->orderStatus = $request->status;
                }
                $order->save();
                return response(["Status changed successfully"]);
            }catch(\Exception $e) {
                return response(["Can not change the status"], 400);
            }
        });
    }

    public function getOrders(Request $request) {
        $user = \Auth::user();

        $orders = Orders::leftJoin('users as soldUser', 'soldUser.id', 'orders.sold_by')
                    ->leftJoin('users as vendors', 'vendors.id', 'orders.vendor_id')
                    ->select('orders.*')
                    ->addSelect(\DB::raw("CONCAT(soldUser.firstName,' ', COALESCE(soldUser.lastName,'')) as soldUserName"))
                    ->addSelect(\DB::raw("CONCAT(vendors.firstName,' ', COALESCE(vendors.lastName,'')) as vendorUserName"));

        if($user->roles == 'sales_executive') {
            $orders = $orders->where('soldUser.id', $user->id);
        }else if($user->roles == 'regional_head') {
            $underUsers = User::where('region_id', $user->region_id)->get();
            $orders = $orders->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('soldUser.id', $user->id);
                }
            });
        }else if($user->roles == 'state_head') {
            $underUsers = User::where('state_id', $user->state_id)->get();
            $orders = $orders->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('soldUser.id', $user->id);
                }
            });
        }else if($user->roles == 'country_head') {
            $underUsers = User::where('country_id', $user->country_id)->get();
            $orders = $orders->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('soldUser.id', $user->id);
                }
            });
        }else if($user->roles == 'vendors') {
            $orders = $orders->where(function($query) use ($underUsers) {
                foreach($underUsers as $user){
                    $query = $query->orWhere('vendors.id', $user->id);
                }
            });
        }

        if(!empty($request->searchText)){
            $orders = $orders->where(function($query)use($request) {
                $query->where('orders.autoId', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('vendors.firstName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('vendors.lastName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('soldUser.firstName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('soldUser.lastName', 'LIKE', '%'.$request->searchText."%");
            });
        }

        if(!empty($request->orderStatus)) {
            $orders = $orders->where('orderStatus', $request->orderStatus);
        }

        if(!empty($request->vendor_id)) {
            $orders = $orders->where('vendor_id', $request->vendor_id);
        }

        if(!empty($request->sold_by)) {
            $orders = $orders->where('sold_by', $request->sold_by);
        }


        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        return $orders->orderBy('created_at', 'DESC')->paginate(15);
    }

    public function getSingleOrder(Request $request, $id) {
        
        $user = \Auth::user();

        $orders = Orders::leftJoin('users as soldUser', 'soldUser.id', 'orders.sold_by')
                    ->leftJoin('users as vendors', 'vendors.id', 'orders.vendor_id')
                    ->select('orders.*')
                    ->addSelect(\DB::raw("CONCAT(soldUser.firstName,' ', COALESCE(soldUser.lastName,'')) as soldUserName"))
                    ->addSelect(\DB::raw("CONCAT(vendors.firstName,' ', COALESCE(vendors.lastName,'')) as vendorUserName"))
                    ->where('orders.id', $id)
                    ->first();
        
        $orderItems = OrderItem::where('order_id', $id)->get();
        $vendor = $user = User::leftJoin('countries', 'countries.id', 'users.country_id')
                        ->leftJoin('states', 'states.id', 'users.state_id')
                        ->leftJoin('regions', 'regions.id', 'users.region_id')
                        ->leftJoin('areas', 'areas.id', 'users.area_id')
                        ->select('users.*', 'states.state', 'countries.country', 'regions.region', 'areas.area')
                        ->where('users.id', $orders->vendor_id)
                        ->first();
        $orderItems = OrderItem::where('order_id', $id)->get();

        foreach($orderItems as $item) {
            $item['productDetails'] = json_decode($item['productDetails']);
        }

        $orders['orderItems'] = $orderItems;
        $orders['vendor'] = $vendor;

        return $orders;

    }


    public function getActiveVendors(Request $request) {
        $user = \Auth::user();

        $vendors = User::where('roles', 'vendors')
                        ->where('isActive', true);


        if($user->roles == 'country_head') {
            $vendors = $vendors->where('country_id', $user->country_id);
        }

        if($user->roles == 'state_head') {
            $vendors = $vendors->where('state_id', $user->state_id);
        }

        if($user->roles == 'regional_head') {
            $vendors = $vendors->where('region_id', $user->region_id);
        }

        if($user->roles == 'sales_executive') {
            $vendors = $vendors->where('area_id', $user->area_id);
        }

        return $vendors->orderBy('firstName','ASC')->get();
    }
}
