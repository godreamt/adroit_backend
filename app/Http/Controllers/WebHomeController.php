<?php

namespace App\Http\Controllers;

use App\Career;
use App\OurTeam;
use App\Category;
use App\Products;
use App\SubCategory;
use App\CustomerReviews;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class WebHomeController extends Controller
{
    public function homePage(Request $request) {
        $categories = Category::all();
        $bestSellingProducts = Products::where('bestSeller', true)->where('removeFromList', false)->get();
        $bestSellingProducts = $bestSellingProducts->shuffle()->slice(0,4);
        $animate = [0.15, 0.40, 0.65, 0.90];
        foreach($bestSellingProducts as $key=>$value){
            $value['animate'] = $animate[$key];
        }
        // dd($bestSellingProducts);
        // dd($bestSellingProducts->toArray());
        $reviews = CustomerReviews::all();
        return view('home', [
            'title' => 'Home',
            'description' => 'description',
            'categories' => $categories,
            'bestSellingProducts' => $bestSellingProducts,
            'reviews' => $reviews
        ]);
    }

    public function aboutPage(Request $request) {
        $teams = OurTeam::orderBy('priority', 'ASC')->get();
        return view('about', [
            'title' => 'About',
            'description' => 'description',
            'teams' => $teams,
        ]);
    }

    public function productPage(Request $request) {
        $products = Products::leftJoin('sub_categories', 'products.sub_category_id', 'sub_categories.id')
                        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
                        ->select('products.*', 'categories.title as category', 'sub_categories.title as sub_category')    
                        ->where('removeFromList', false);

        if($request->get('bestSeller') == 'yes') {
            $products = $products->where('bestSeller', true);
        }
        $categories=$request->categories;
        if(is_array($categories) && sizeof($categories) > 0){
            $products = $products->whereIn('categories.id', $request->categories);
        }
        $subCategories=$request->subCategories;
        if(is_array($subCategories) && sizeof($subCategories) > 0){
            $products = $products->whereIn('sub_categories.id', $request->subCategories);
        }

        

        $currentPage = $request->pageNumber;
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });
        
        $products = $products->paginate(3);
        return view('product', [
            'title' => 'Product',
            'description' => 'description',
            'products' => $products,
        ]);
    }

    public function productDetailPage(Request $request, $slug) {
        $product = Products::where('slug', $slug)->first();
        if(!($product instanceof Products)) {
            return redirect('products');
        }
        $product['sub_category'] = SubCategory::find($product->sub_category_id);
        $product['category'] = Category::find($product['sub_category']->category_id);

        $relatedProducts = Products::leftJoin('sub_categories', 'products.sub_category_id', 'sub_categories.id')
                        ->leftJoin('categories', 'categories.id', 'sub_categories.category_id')
                        ->select('products.*', 'categories.title as category', 'sub_categories.title as sub_category')   
                        ->where('categories.id', $product['category']->id) 
                        ->where('products.id','<>', $product->id)
                        ->paginate(14);
        return view('product-detail', [
            'title' => $product->title,
            'description' => $product->shortDescription,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function careerPage(Request $request) {
        $careers = Career::orderBy('created_at', 'DESC')->get();
        return view('career', [
            'title' => 'Career',
            'description' => 'description',
            'careers' => $careers,
        ]);
    }

    public function contactPage(Request $request) {
        return view('contact');
    }

    public function privacyPage(Request $request) {
        return view('privacy');
    }
}
