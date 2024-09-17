<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\CategoryDetailsResource;
use App\Http\Resources\Admin\ProductResource;
use App\Http\Resources\Admin\SearchResource;
use App\Models\Admin\Category;
use App\Models\Admin\Offers;
use App\Models\Admin\Product;
use App\Trait\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    use ResponseTrait;
    //
    public function general_search(Request $request){
        try{
            $request->validate([
                'search'=>'required|string|max:255',
            ]);

            $category= Category::whereHas('translations', function ($query) use($request) {
                $query->where('locale', '=', app()->getLocale())->where('name', 'LIKE', '%' . $request->search . '%');
            })->get();
            $products = Product::whereHas('translations', function ($query) use($request) {
                $query->where('locale', '=', app()->getLocale())->where('name', 'LIKE', '%' . $request->search . '%');
            })->get();

            $offers = Offers::whereHas('translations', function ($query) use($request) {
                $query->where('locale', '=', app()->getLocale())->where('name', 'LIKE', '%' . $request->search . '%');
            })->get();

            $this->res(true , 'All Serach ' , 200 , [
                'cateogories'=> CategoryDetailsResource::collection($category),
                'products'=>   ProductResource::collection($products),
                'offers'=>'tomowwer'
            ]);




        }catch(Exception $e){
            dd($e->getLine() , $e->getMessage());

        }
    }
}
