<?php

namespace App\Http\Controllers;

use App\Products;
use App\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    public function updateProduct(ProductRequest $request) {
        if(empty($request->id)) {
            $product = new Products();
        }else {
            $product = Products::find($request->id);
        }

        $product->title = $request->title;
        $slugGenerate=true;
        $slug=strtolower(preg_replace('/\s+/', '-', $product->title));
        while($slugGenerate) {
            $db = Products::where('slug', $slug)->where('id', '<>', $request->id)->first();
            if($db instanceof Products) {
                $slug = strtolower($slug."-0");
            }else {
                $slugGenerate=false;
                $product->slug = strtolower($slug);
            }
        }
        $product->shortDescription = $request->shortDescription;
        $product->description = $request->description;
        $product->featureInfo = $request->featureInfo;
        $product->offerPrice = $request->offerPrice;
        $product->regularPrice = $request->regularPrice;
        $product->salesPoints = $request->salesPoints;
        $product->sub_category_id = $request->sub_category_id;
        $product->removeFromList = ($request->removeFromList=="yes")?true:false;
        $product->bestSeller = ($request->bestSeller=="yes")?true:false;
        
        
        if(!empty($request->featuredImage)) {
            $mimetype=mime_content_type($request['featuredImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->featuredImage, strpos($request->featuredImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $product->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/product/' . $imageName, $image);
            if(!empty($request->id) && !empty($product->featuredImage)) {
                unlink(public_path().$product->featuredImage);
            }
            $product->featuredImage='/uploads/product/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }else {
            if(empty($request->id)) {
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
        }

        if(!empty($request->coverageImage)) {
            $mimetype=mime_content_type($request['coverageImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->coverageImage, strpos($request->coverageImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $product->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/coverage/' . $imageName, $image);
            if(!empty($request->id) && !empty($product->coverageImage)) {
                unlink(public_path().$product->coverageImage);
            }
            $product->coverageImage='/uploads/coverage/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }

        if(!empty($request->shadeCardImage)) {
            $mimetype=mime_content_type($request['shadeCardImage']);
            if($mimetype != 'image/png' && $mimetype != "image/jpeg" && $mimetype != "image/jpg"){
                return response()->json(['errors'=>['data'=>["Please add png or jpeg image."]]], 500);
            }
            
            $base64_str = substr($request->shadeCardImage, strpos($request->shadeCardImage, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $product->slug.uniqid().".png";
            \File::put(public_path(). '/uploads/shadeCard/' . $imageName, $image);
            if(!empty($request->id) && !empty($product->shadeCardImage)) {
                unlink(public_path().$product->shadeCardImage);
            }
            $product->shadeCardImage='/uploads/shadeCard/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }

        if(!empty($request->brochureFile)) {
            $mimetype=mime_content_type($request['brochureFile']);
            if($mimetype != 'application/pdf'){
                return response()->json(['errors'=>['data'=>["Please add pdf file for brochure."]]], 500);
            }
            
            $base64_str = substr($request->brochureFile, strpos($request->brochureFile, ",")+1);
            $image = base64_decode($base64_str);
            $imageName = $product->slug.uniqid().".pdf";
            \File::put(public_path(). '/uploads/brochure/' . $imageName, $image);
            if(!empty($request->id) && !empty($product->brochureFile)) {
                unlink(public_path().$product->brochureFile);
            }
            $product->brochureFile='/uploads/brochure/' . $imageName;
            // file_put_contents($destinationPath.$category->slug.".png", $image);
        }

        try {
            $product->save();
            return response(["Product Updated successfully"], 200);
        }catch(\Exception $e) {
            return response()->json(['errors'=>['data'=>["Cannot update data error code : ".$e->getCode()]]], 500);
        }
    }
    
    public function getProducts(Request $request) {
        $product =  Products::leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
                        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
                        ->distinct()
                        ->select('products.id', 
                                'products.title', 
                                'products.slug', 
                                'products.shortDescription', 
                                'products.featuredImage', 
                                'products.offerPrice', 
                                'products.regularPrice', 
                                'bestSeller', 
                                'removeFromList', 
                                'salesPoints', 
                                'categories.title as categoryTitle', 
                                'categories.id as categoryId', 
                                'sub_categories.id as subCategoryId', 
                                'sub_categories.title as subCategoryTitle');

        if(!empty($request->searchText)) {
            $product =  $product->where('products.title', 'like', '%'.$request->searchText.'%');
        }

        if(!empty($request->category)) {
            $product =  $product->where('categories.id', $request->category);
        }

        if(!empty($request->subCategory)) {
            $product =  $product->where('sub_categories.id', $request->subCategory);
        }

        $listed = ($request->isListed == "listed")?false:($request->isListed == "unlisted")?true:"";
        if(!empty($listed)) {
            $product =  $product->where('products.removeFromList', $listed);
        }

        $bestSeller = ($request->isBestSeller == "bestseller")?true:false;
        if(!empty($bestSeller)) {
            $product =  $product->where('products.bestSeller', $bestSeller);
        }

        

        return $product->get();
    }

    public function getProduct(Request $request, $id) {
        $product = Products::find($id);
        $subCat = SubCategory::find($product->sub_category_id);
        $product['category_id']=$subCat->category_id;
        $product['bestSeller'] = ( $product['bestSeller'])?"yes":"no";
        $product['removeFromList'] = ( $product['removeFromList'])?"yes":"no";
        return $product;
    }

    public function getProductsWithPagination(Request $request) {
        $product =  Products::leftJoin('sub_categories', 'sub_categories.id', 'products.sub_category_id')
                        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
                        // ->distinct()
                        ->select('products.id', 
                                'products.title', 
                                'products.slug', 
                                'products.shortDescription', 
                                'products.featuredImage', 
                                'products.offerPrice', 
                                'products.regularPrice', 
                                'bestSeller', 
                                'removeFromList', 
                                'salesPoints', 
                                'categories.title as categoryTitle', 
                                'categories.id as categoryId', 
                                'sub_categories.id as subCategoryId', 
                                'sub_categories.title as subCategoryTitle');

        if(!empty($request->searchText)) {
            $product =  $product->where('products.title', 'like', '%'.$request->searchText.'%');
        }

        if(!empty($request->category)) {
            $product =  $product->where('categories.id', $request->category);
        }

        if(!empty($request->subCategory)) {
            $product =  $product->where('sub_categories.id', $request->subCategory);
        }

        $listed = ($request->isListed == "listed")?false:($request->isListed == "unlisted")?true:"";
        if(!empty($listed)) {
            $product =  $product->where('products.removeFromList', $listed);
        }

        $bestSeller = ($request->isBestSeller == "bestseller")?true:false;
        if(!empty($bestSeller)) {
            $product =  $product->where('products.bestSeller', $bestSeller);
        }

        $categories=$request->categories;
        if(is_array($categories) && sizeof($categories) > 0){
            $product = $product->whereIn('categories.id', $request->categories);
        }
        $subCategories=$request->subCategories;
        if(is_array($subCategories) && sizeof($subCategories) > 0){
            $product = $product->whereIn('sub_categories.id', $request->subCategories);
        }
        
        
        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        
        return $product->distinct('id')->paginate(20);

    }

    public function deleteProduct(Request $request, $id) {
        $product =  Products::find($id);
        try {
            $product->delete();
            return response(["Product deleted successfully."], 200);
        }catch(\Exception $e) {
            return response()->json(["Cannot delete data error code : ".$e->getCode()], 400);
        }
    }
}
