<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;

class ProductController extends Controller
{
    
    public function getProducts(Request $request):JsonResponse
    {
       try{
            $query = Product::query(); 
            if($request->query('idCategory')){
                $query->where('idCategory',$request->query('idCategory'));
            }
            if($request->query('name')){
                $query->where('name','LIKE',$request->query('name') . '%');
            }

            if($request->query('sortBy')){
                if($request->query('order')==='desc'){
                    $query->orderBy($request->query('sortBy'),'desc');
                }else{
                    $query->orderBy($request->query('sortBy'));
                }
            }
            $products = $query->get();
            return response()->json(['message'=>$products],200);
       }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
       }
    }
    public function getProduct($id):JsonResponse
    {
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message' => 'Product not found'],404);
        }
        return response()->json(['message'=>$product],200);
    }

    public function createProduct(Request $request):JsonResponse
    {
        $validatior = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'stock' => 'required|integer',
            'idCategory' => 'required|integer'
        ]);

        if($validatior->fails()){
            return response()->json(['message' => $validatior->errors()],400);
        }
        if(Category::find($request->idCategory) == null){
            return response()->json(['message' => 'Category not found'],404);
        }
        try{
            $product = Product::create($request->all());
            if($request->hasFile('images')){
                foreach($request->file('images') as $image){
                   ProductImage::create([
                       'idProduct' => $product->id,
                       'image' => $image
                   ]);
                }
            }
            return response()->json(['message'=>$product],201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function updateProduct(Request $request, $id):JsonResponse{
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message' => 'Product not found'],404);
        }
        $validatior = Validator::make($request->all(),[
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'stock' => 'required|integer',
            'idCategory' => 'required|integer'
        ]);

        if($validatior->fails()){
            return response()->json(['message' => $validatior->errors()],400);
        }
        if(Category::find($request->idCategory) == null){
            return response()->json(['message' => 'Category not found'],404);
        }
        try{
            $product->update($request->all());
            if($request->has('images')){
                ProductImage::where('idProduct',$product->id)->delete();
                foreach($request->file('images') as $image){
                    ProductImage::create([
                        'idProduct' => $product->id,
                        'image' => $image
                    ]);
                }
            }
            return response()->json(['message'=>$product],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function deleteProduct($id):JsonResponse{
        $product = Product::find($id);
        if($product == null){
            return response()->json(['message' => 'Product not found'],404);
        }
        try{
            $product->delete();
            return response()->json(['message'=>$product],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}

