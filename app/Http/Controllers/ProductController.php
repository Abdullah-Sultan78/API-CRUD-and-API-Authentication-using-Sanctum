<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){

            $products = Product::get();
            if($products-> count()>0)
            {
                return ProductResource::collection($products);
            }
            else
            {
                return response()->json(['message'=> 'No record available'],200);
            }
    }

    public function store(Request  $request)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
             'description' =>'required',
             'price' =>'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'message'=> 'All fields are mandatory',
                'error' => $validator->messages(),
            ],422);
        }
        // $request -> validate([
        //     'name' =>'required|string|max:255',
        //     'description' =>'required',
        //     'price' =>'required|integer',
        // ]);

        $product = Product::create([
            'name' =>$request->name,
            'description' =>$request->description,
            'price' =>$request->price,
        ]);
        return response()->json([
            'message' => 'Product created Successfully',
            'data' => new ProductResource($product)
        ],200);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(),[
            'name' =>'required|string|max:255',
             'description' =>'required',
             'price' =>'required|integer',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'message'=> 'All fields are mandatory',
                'error' => $validator->messages(),
            ],422);
        }

        $product -> update([
            'name' =>$request->name,
            'description' =>$request->description,
            'price' =>$request->price,
        ]);
        return response()->json([
            'message' => 'Product update Successfully',
            'data' => new ProductResource($product)
        ],200);
    }

    public function destroy(Product $product)
    {
        $product ->delete();
        return response()->json([
            'message'=>'Product Deleted Successfully',
        ],200);
    }
}
