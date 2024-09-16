<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Gallary;
use App\Models\Admin\Lang;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    protected $langs;
    public function __construct()
    {
        $this->langs = Lang::all();
    }

    //
    public function index()
    {
        return view('admin.products.index' , ['langs'=>$this->langs , 'products'=> Product::all() , 'categories'=> Category::all()]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.add' , ['categories' => $categories , 'langs'=> $this->langs]);

    }

    public function store(StoreProductRequest $request)
    {

        try{
            DB::beginTransaction();
              $product =  new Product();
              $product->category_id = ($request->category != '0' ) ? $request->category : null;
              $product->price = $request->price;
              $product->star = $request->star;
              $product->discount = $request->discount;
              $product->old_price = $request->old_price;
            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }
            $product->save();
            DB::commit();
            Alert::success('Success', 'Product Added Successfully !');
            return redirect()->route('admin.products.index');
        }catch(\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');

        }


    }

    public function update(StoreProductRequest $request , $id)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            $product->update([
                'price'       =>        $request->price,
                'category_id' => $request->category,
                'star'       => $request->star
            ]);
            foreach ($this->langs as $lang) {
                $product->{'name:'.$lang->code}  = $request->name[$lang->code];
                $product->{'des:'.$lang->code}  = $request->des[$lang->code];
                $product->{'meta_des:'.$lang->code}  = $request->meta_des[$lang->code];
                $product->{'meta_title:'.$lang->code}  = $request->meta_title[$lang->code];
                $product->{'slug:'.$lang->code}  = $request->slug[$lang->code];
            }

            $product->save();
            DB::commit();
            Alert::success('Success', 'Product Updated Successfully !');
            return redirect()->route('admin.products.index');
        }catch (\Exception $e){
            dd($e->getLine() , $e->getMessage());
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');
        }

    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.update' , ['langs'=>$this->langs , 'categories'=> $categories , 'product'=>$product]);

    }

    public function gallery($id){
        $product = Product::with('gallery')->findOrFail($id);
        return view('admin.products.Gallary' , ['product'=>$product]);
    }

    public function store_gallery(Request $request , $id){

        $product = Product::findOrFail($id);
        $request->validate([
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp'
        ]);

        if($request->has('photo')){
            $image_name = $request->photo->getClientOriginalName();
            $request->photo->move(public_path('uploads/images/gallery'), $image_name);
            $gallery = new Gallary();
            $gallery->product_id = $product->id;
            $gallery->photo = $image_name;
            $gallery->save();
            Alert::success('Success', 'Product Gallery Added Successfully !');
            return redirect()->route('admin.products.index');
        }
        Alert::error('error', 'Tell The Programmer To solve Error');
        return redirect()->route('admin.products.index');


    }

    public function delete_gallery($id){

        try {
            DB::beginTransaction();
            $gallery = Gallary::findOrFail($id);
            if (isset($gallery->photo) &&file_exists(public_path('uploads/images/gallery/' .$gallery->photo))) {
                unlink(public_path('uploads/images/gallery/' .$gallery->photo));
            }
            $gallery->delete();
            DB::commit();
            Alert::success('Success', 'Product Gallery Added Successfully !');
            return redirect()->route('admin.products.index');
        }catch (\Exception $e){
            DB::rollBack();
            Alert::error('error', 'Tell The Programmer To solve Error');
            return redirect()->route('admin.products.index');
        }

    }
}
