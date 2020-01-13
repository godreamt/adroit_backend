<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\UserUpdateRequest;
use App\UserExtraInfo;

class UserController extends Controller
{
    public function userUpdate(UserUpdateRequest $request) {
        return \DB::transaction(function() use($request) {
            if(empty($request->id)){
                $user = new User();
                if(empty($request->password)){
                    return response(["Password is required"], 400);
                }
                $user->password = bcrypt($request->password);
            }else {
                $user = User::find($request->id);
                if(!empty($request->password)){
                    $user->password = bcrypt($request->password);
                }
            }
    
            $user->firstName = $request->firstName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->mobileNumber = $request->mobileNumber;
            $user->isActive = ($request->isActive=="yes")?true:false;
            $user->roles = $request->roles;
    
            //for others
            $roles = $request->roles;
    
            try {
                $user->save();
                if($roles != 'admin'){
    
                    if($roles != 'vendors') {
                        $user->monthlySalary = $request->monthlySalary;
                        $user->salesTarget = $request->salesTarget;
                        $user->collectionTarget = $request->collectionTarget;
                        $userExtra = UserExtraInfo::where('user_id', $user->id)->first();
                        if(!($userExtra instanceof UserExtraInfo))
                            $userExtra = new UserExtraInfo();
                        $userExtra->fatherName = $request->fatherName;
                        $userExtra->motherName = $request->motherName;
                        $userExtra->alternativeMobileNumber = $request->alternativeMobileNumber;
                        $userExtra->alternativeEmail = $request->alternativeEmail;
                        $userExtra->alternativeAddress = $request->alternativeAddress;
                        $userExtra->panNumber = $request->panNumber;
                        $userExtra->adharNumber = $request->adharNumber;
                        $userExtra->drivingLicence = $request->drivingLicence;
                        $userExtra->dateOfBirth = (empty($request->dateOfBirth))?null:new \Datetime($request->dateOfBirth);
                        $userExtra->user_id = $user->id;
                        $userExtra->save();
                    }
    
                    $user->country_id = $request->country_id;
                    $user->state_id = $request->state_id;
                    $user->region_id = $request->region_id;
                    $user->area_id = $request->area_id;
                    $user->address = $request->address;
                }
    
    
                $user->save();
                return response(["User saved successfully"]);
            }catch(\Exception $e){
                return response(["User can not be saved".$e->getMessage()], 400);
            }
        });
    }

    public function getUsers(Request $request) {
        $user = \Auth::user();
        $users = User::select('users.*');

        if(!empty($request->searchText)){
            $users = $users->where(function($query)use($request) {
                $query->where('users.firstName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.lastName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.email', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.mobileNumber', 'LIKE', '%'.$request->searchText."%");
            });
        }

        if(!empty($request->status)) {
            $status = ($request->status=="yes")?true:false;
            $users = $users->where('isActive', $status);
        }

        if(!empty($request->roles)) {
            $users = $users->where('roles', $request->roles);
        }

        if(!empty($request->country_id)) {
            $users = $users->where('country_id', $request->country_id);
        }

        if(!empty($request->state_id)) {
            $users = $users->where('state_id', $request->state_id);
        }

        if(!empty($request->region_id)) {
            $users = $users->where('region_id', $request->region_id);
        }

        if(!empty($request->area_id)) {
            $users = $users->where('area_id', $request->area_id);
        }

        if($user->roles == 'country_head') {
            $users = $users->where('country_id', $user->country_id);
        }

        if($user->roles == 'state_head') {
            $users = $users->where('state_id', $user->state_id);
        }

        if($user->roles == 'regional_head') {
            $users = $users->where('region_id', $user->region_id);
        }

        if($user->roles == 'sales_executive') {
            $users = $users->where('area_id', $user->area_id);
        }

        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        return $users->paginate(20);


    }

    public function getUsersWithoutPagination(Request $request) {
        $user = \Auth::user();
        $users = User::select('users.*');

        if(!empty($request->searchText)){
            $users = $users->where(function($query)use($request) {
                $query->where('users.firstName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.lastName', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.email', 'LIKE', '%'.$request->searchText."%")
                ->orWhere('users.mobileNumber', 'LIKE', '%'.$request->searchText."%");
            });
        }

        if(!empty($request->status)) {
            $status = ($request->status=="yes")?true:false;
            $users = $users->where('isActive', $status);
        }else {
            $users = $users->where('isActive', true);
        }

        if(!empty($request->roles)) {
            $users = $users->where('roles', $request->roles);
        }

        if(!empty($request->country_id)) {
            $users = $users->where('country_id', $request->country_id);
        }

        if(!empty($request->state_id)) {
            $users = $users->where('state_id', $request->state_id);
        }

        if(!empty($request->region_id)) {
            $users = $users->where('region_id', $request->region_id);
        }

        if(!empty($request->area_id)) {
            $users = $users->where('area_id', $request->area_id);
        }

        if($user->roles == 'country_head') {
            $users = $users->where('country_id', $user->country_id);
        }

        if($user->roles == 'state_head') {
            $users = $users->where('state_id', $user->state_id);
        }

        if($user->roles == 'regional_head') {
            $users = $users->where('region_id', $user->region_id);
        }

        if($user->roles == 'sales_executive') {
            $users = $users->where('area_id', $user->area_id);
        }
        return $users->orderBy('firstName', 'ASC')->get();


    }

    public function getUser(Request $request, $id) {
        $user = User::leftJoin('countries', 'countries.id', 'users.country_id')
                    ->leftJoin('states', 'states.id', 'users.state_id')
                    ->leftJoin('regions', 'regions.id', 'users.region_id')
                    ->leftJoin('areas', 'areas.id', 'users.area_id')
                    ->select('users.*', 'states.state', 'countries.country', 'regions.region', 'areas.area')
                    ->where('users.id', $id)
                    ->first();
        if($user instanceof User && $user->roles != 'admin') {
            $userExtraInfo = UserExtraInfo::where('user_id', $user->id)->first();
            $user['extraInfo']=$userExtraInfo;
        }

        return $user;
    }

    public function deleteUser(Request $request, $id) {
        try {
            $user = User::find($id);
            $user->delete();
            return response(["User deleted successfully"]);
        }catch(\Exception $e) {
            return response(["User cant be deleted"], 400);
        }
    }
}
