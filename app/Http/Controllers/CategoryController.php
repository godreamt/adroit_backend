<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\SubCategoryRequest;

class CategoryController extends Controller
{
    public function updateCategory(CategoryRequest $request) {
        if(empty($request->id)) {
            $category = new Category();
        }else {
            $category = Category::find($request->id);
        }

        $category->title = $request->title;
        $slugGenerate=true;
        $slug=strtolower(preg_replace('/\s+/', '-', $category->title));
        while($slugGenerate) {
            $db = Category::where('slug', $slug)->where('id', '<>', $request->id)->first();
            if($db instanceof Category) {
                $slug = strtolower($slug."-0");
            }else {
                $slugGenerate=false;
                $category->slug = strtolower($slug);
            }
        }
        $category->shortDescription = $request->shortDescription;
        $category->description = $request->description;
        
        // $image = $request->file('featuredImage');
        // if($image instanceof UploadedFile){
        //     $imageName = time().'.'.$image->getClientOriginalExtension();
        //     $destinationPath = public_path('/uploads/category');
        //     $image->move($destinationPath, $imageName);
        //     $category->featuredImage = '/uploads/category/'.$imageName;
        // }
        if(!empty($request->featuredImage)) {
            $mimetype=mime_content_type($request['featuredImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->featuredImage, strpos($request->featuredImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $category->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/category/' . $imageName, $image);
            if(!empty($request->id) && !empty($category->featuredImage)) {
                unlink(public_path().$category->featuredImage);
            }
            $category->featuredImage='/uploads/category/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }else {
            if(empty($request->id)) {
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
        }

        try {
            $category->save();
            return response(["Category Updated successfully"], 200);
        }catch(\Exception $e) {
            return response()->json(['errors'=>['data'=>["Cannot update data error code : ".$e->getCode()]]], 500);
        }


    }
    public function updateSubCategory(SubCategoryRequest $request) {
        if(empty($request->id)) {
            $subCategory = new SubCategory();
        }else {
            $subCategory = SubCategory::find($request->id);
        }

        $subCategory->title = $request->title;
        $slugGenerate=true;
        $slug=strtolower(preg_replace('/\s+/', '-', $subCategory->title));
        while($slugGenerate) {
            $db = SubCategory::where('slug', $slug)->where('id', '<>', $request->id)->first();
            if($db instanceof SubCategory) {
                $slug = strtolower($slug."-0");
            }else {
                $slugGenerate=false;
                $subCategory->slug = strtolower($slug);
            }
        }
        $subCategory->shortDescription = $request->shortDescription;
        $subCategory->description = $request->description;
        $subCategory->category_id = $request->category_id;
        
        if(!empty($request->featuredImage)) {
            $mimetype=mime_content_type($request['featuredImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->featuredImage, strpos($request->featuredImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $subCategory->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/sub-category/' . $imageName, $image);
            if(!empty($request->id) && !empty($subCategory->featuredImage)) {
                unlink(public_path().$subCategory->featuredImage);
            }
            $subCategory->featuredImage='/uploads/sub-category/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }else {
            if(empty($request->id)) {
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
        }

        try {
            $subCategory->save();
            return response(["Sub Category Updated successfully"], 200);               

        }catch(\Exception $e) {
            return response()->json(['errors'=>['data'=>["Cannot update data error code : ".$e->getCode()]]], 500);
        }
    }

    public function getCategory(Request $request) {
        return Category::select('title', 'slug', 'id')->get();
    }

    public static function getCat() {
        return Category::select('title', 'slug', 'id')->get();
    }

    public function getCategoryWithPagination(Request $request) {
        $category = Category::select('*');

        if(!empty($request->searchText)) {
            $category = $category->where('title', 'like', '%'.$request->searchText."%");
        }

        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        
        return $category->orderBy('title', 'ASC')->paginate(20);
    }

    public function getCategoryById(Request $request, $id) {
        return Category::find($id);
    }

    public function getSubCategory(Request $request) {
        return SubCategory::select('title', 'id')->get();
    }

    public function getSubCategoryWithPagination(Request $request) {
        $category = SubCategory::leftJoin('categories', 'categories.id', 'sub_categories.category_id')->select('sub_categories.*', 'categories.title as category');

        if(!empty($request->searchText)) {
            $category = $category->where('title', 'like', '%'.$request->searchText."%");
        }

        if(!empty($request->category_id)) {
            $category = $category->where('category_id', $request->category_id);
        }
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        
        return $category->orderBy('title', 'ASC')->paginate(20);
    }

    public function getSubCategoryById(Request $request, $id) {
        return SubCategory::find($id);
    }

    public function getSubCategoryByCategory(Request $request, $id) {
        return SubCategory::where('category_id', $id)->orderBy('title', 'ASC')->get();
    }

    public function deleteCategory(Request $request, $id) {
        $category = Category::find($id);
        
        try {
            $category->delete();
            return response(["Category deleted successfully"], 200);
        }catch(\Exception $e) {
            return response()->json(['errors'=>['data'=>["Cannot delete data error code : ".$e->getCode()]]], 500);
        }
    }

    public function deleteSubCategory(Request $request, $id) {
        $subCategory = SubCategory::find($id);
        
        try {
            $subCategory->delete();
            return response(["Sub Category deleted successfully"], 200);
        }catch(\Exception $e) {
            return response("Cannot delete data error code : ".$e->getCode(), 400);
        }
    }

    public function getSubCategoryByCatList(Request $request) {
        if(sizeof($request->catList) > 0){
            return SubCategory::whereIn('category_id', $request->catList)->orderBy('title', 'ASC')->get();
        }else {
            return [];
        }
    }
}
