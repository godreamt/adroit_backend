<?php

namespace App\Http\Controllers;

use App\Career;
use App\Enquiry;
use App\OurTeam;
use App\Products;
use App\ContactUs;
use App\CustomerReviews;
use Illuminate\Http\Request;
use App\Http\Requests\CareerRequest;
use App\Http\Requests\ReviewRequest;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\EnquiryRequest;
use App\Http\Requests\OurTeamRequest;

class SiteManagerController extends Controller
{
    public function updateEnquiry(EnquiryRequest $request) {
        if(empty($request->id)) {
            $enquiry = new Enquiry();

            $oldEnquiry = Enquiry::where('email', $request->email)->where('status', 'new')->get();
            if(sizeof($oldEnquiry) > 0) {
                return response()->json(['errors'=>['data'=>["Enquiry submitted already."]]], 400);
            }
        }else {
            $enquiry = Enquiry::find($request->id);
        }

        $enquiry->fullName=$request->fullName;
        $enquiry->email=$request->email;
        $enquiry->mobileNumber=$request->mobileNumber;
        $enquiry->customerInfo=$request->customerInfo;
        $enquiry->enquiryText=$request->enquiryText;
        $enquiry->status=$request->status;
        try {
            $enquiry->save();
            return response(["Enquiry #".$enquiry->id." submitted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot update data error code : ".$e->getCode()], 200);
        }
    }

    public function getEnquiries(Request $request) {
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        return Enquiry::orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getEnquiry(Request $request, $id) {
        $enquiry = Enquiry::find($id);
        return $enquiry;
    }

    public function deleteEnquiry(Request $request, $id) {
        $enquiry =  Enquiry::find($id);
        try {
            $enquiry->delete();
            return response(["Enquiry #".$enquiry->id." deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }

    public function updateReview(ReviewRequest $request) {
        if(empty($request->id)) {
            $review = new CustomerReviews();
        }else {
            $review = CustomerReviews::find($request->id);
        }

        $review->stars = ($request->stars)?$request->stars:0;
        $review->name = $request->name;
        $review->subTitle = $request->subTitle;
        $review->review = $request->review;
        try {
            $review->save();
            return response(["Review updated successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot update data error code : ".$e->getMessage()], 400);
        }
    }

    public function getReviews(Request $request) {
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
            
        return CustomerReviews::select('*')->orderBy('created_at','DESC')->paginate(20);
    }

    public function getReview(Request $request, $id) {
        return CustomerReviews::find($id);
    }

    public function deleteCustomerReviews(Request $request, $id) {
        $enquiry =  CustomerReviews::find($id);
        try {
            $enquiry->delete();
            return response(["Customer Reviews deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }

    public function updateContactUs(ContactRequest $request) {
        if(empty($request->id)) {
            $contact = new ContactUs();
            $oldEnquiry = ContactUs::where('email', $request->email)->where('status', 'new')->get();
            if(sizeof($oldEnquiry) > 0) {
                return response()->json(['errors'=>['data'=>["Contact request submitted already."]]], 400);
            }
        }else {
            $contact = ContactUs::find($request->id);
        }


        $contact->fullName=$request->fullName;
        $contact->email=$request->email;
        $contact->mobileNumber=$request->mobileNumber;
        $contact->reasonText=$request->reasonText;
        $contact->status=$request->status;
        try {
            $contact->save();
            return response(["Contact request #".$contact->id." submitted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot update data error code : ".$e->getCode()], 400);
        }
    }

    public function getContactUs(Request $request) {
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
            
        return ContactUs::select('*')->orderBy('created_at','DESC')->paginate(20);
    }

    public function getContact(Request $request, $id) {
        return ContactUs::find($id);
    }

    public function deleteContactRequest(Request $request, $id) {
        $contact =  ContactUs::find($id);
        try {
            $contact->delete();
            return response(["Contact request deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }

    public function updateOurTeam(OurTeamRequest $request) {
        if(empty($request->id)) {
            $ourTeam = new OurTeam();
        }else {
            $ourTeam = OurTeam::find($request->id);
        }

        $ourTeam->fullName = $request->fullName;
        $ourTeam->designation = $request->designation;
        $ourTeam->shortDescription = $request->shortDescription;
        $ourTeam->experience = $request->experience;
        $ourTeam->priority = $request->priority;
        
        if(!empty($request->profileImage)) {
            $mimetype=mime_content_type($request['profileImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->profileImage, strpos($request->profileImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $ourTeam->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/ourTeam/' . $imageName, $image);
            if(!empty($request->id) && !empty($ourTeam->profileImage)) {
                unlink(public_path().$ourTeam->profileImage);
            }
            $ourTeam->profileImage='/uploads/ourTeam/' . $imageName;
        }else {
            if(empty($request->id)) {
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
        }

        try {
            $ourTeam->save();
            return response(["Team member updated successfully"], 200);
        }catch(\Exception $e) {
            return response()->json(['errors'=>['data'=>["Cannot update data error code : ".$e->getCode()]]], 500);
        }
    }

    public function getOurTeams(Request $request) {

        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
            
        return OurTeam::select('*')->orderBy('priority','ASC')->paginate(20);
    }

    public function getTeamMember(Request $request, $id) {
        return OurTeam::find($id);
    }

    public function deleteTeamMember(Request $request, $id) {
        $ourTeam =  OurTeam::find($id);
        try {
            $ourTeam->delete();
            return response(["Contact request deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }

    public function updateCareer(CareerRequest $request) {
        if(empty($request->id)) {
            $career = new Career();
        }else {
            $career = Career::find($request->id);
        }

        $career->title=$request->title;
        $career->experience=$request->experience;
        $career->info=$request->info;
        $career->description=$request->description;
        try {
            $career->save();
            return response(["Career submitted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot update data error code : ".$e->getCode()], 200);
        }
    }

    public function getCareers(Request $request) {
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        return Career::orderBy('created_at', 'DESC')->paginate(20);
    }

    public function getCareer(Request $request, $id) {
        $career = Career::find($id);
        return $career;
    }

    public function deleteCareer(Request $request, $id) {
        $career =  Career::find($id);
        try {
            $career->delete();
            return response(["Career  deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }
}
