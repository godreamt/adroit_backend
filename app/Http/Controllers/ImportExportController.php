<?php

namespace App\Http\Controllers;

use Excel;
use App\User;
use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    public function userImport(Request $request) {
        
        try {
            $path  = public_path('\seed\user.xls');
            $data = Excel::load($path)->get();
            $rejectedUsers = [];
            foreach($data as $user) {
                try {
                    User::updateOrCreate([
                        'firstName' => $user->firstname,
                        'lastName' => $user->lastname,
                        'email' => $user->email,
                        'mobileNumber' => $user->mobilenumber,
                        'address' => $user->address,
                        'roles' => $user->roles,
                        'monthlySalary' => $user->monthlysalary,
                        'collectionTarget' => $user->collectiontarget,
                        'password' => bcrypt('1234567')
                    ]);
                }catch(\Exception $e) {
                    $rejectedUsers[] = ['user' => $user, 'message' => $e->getMessage()];
                }
            }
            return $rejectedUsers;
        }catch(\Exception $e){
            return [$e->getMessage()];
        }
           
        // return back();
    }
}
