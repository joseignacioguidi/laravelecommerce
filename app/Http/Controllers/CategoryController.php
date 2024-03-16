<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    public function getCategories(){
        try{
            $categories = Category::all();
            return response()->json(['message'=>$categories],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function getCategory($id){
        try{
            $category = Category::find($id);
            if($category == null){
                return response()->json(['message' => 'Category not found'],404);
            }
            return response()->json(['message'=>$category],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function createCategory(Request $request){
        try{
            $validatior = Validator::make($request->all(),[
                'name' => 'required',
                'parent_id' => 'integer',
                'image' => 'url'
            ]);
            if($validatior->fails()){
                return response()->json(['message' => $validatior->errors()],400);
            }
            $category = new Category();
            $category->name = $request->name;
            if($request->parent_id){
                $category->parent_id = $request->parent_id;
            }
            $category->image = $request->image;
            $category->save();
            return response()->json(['message' => $category],201);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }

    public function updateCategory(Request $request,$id){
        try{
            $category = Category::find($id);
            if($category == null){
                return response()->json(['message' => 'Category not found'],404);
            }
            $validatior = Validator::make($request->all(),[
                'name' => 'required',
                'parent_id' => 'integer',
                'image' => 'url'
            ]);
            if($validatior->fails()){
                return response()->json(['message' => $validatior->errors()],400);
            }
            $category->name = $request->name;
            if($request->parent_id){
                $category->parent_id = $request->parent_id;
            }
            $category->image = $request->image;
            $category->save();
            return response()->json(['message' => $category],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
    public function deleteCategory(Request $request,$id){
        try{
            $category = Category::find($id);
            if($category == null){
                return response()->json(['message' => 'Category not found'],404);
            }
            $category->delete();
            return response()->json(['message' => $category],200);
        }catch(\Exception $e){
            return response()->json(['message' => $e->getMessage()],500);
        }
    }
}
