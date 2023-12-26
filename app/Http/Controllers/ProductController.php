<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use App\Models\Product;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\validator;


class ProductController extends Controller
{

    public function createProduct(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'gender' => 'required',
            'category' => 'required',
            'color' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'priceAfterCode'=>'required',
            'sizeGuide'=>'required',
            //'image' => 'required|file|mimes:jpeg,png,jpg,gif', // Validate image type and size

          
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }
        $product = new product;

        $product->name=$request->input('name');
        $product->gender=$request->input('gender');
        $product->category=$request->input('category');
        $product->color=$request->input('color');
        $product->sizes=$request->input('sizes');
        $product->stock=$request->input('stock');
        $product->price=$request->input('price');
        $product->priceAfterCode=$request->input('priceAfterCode');
        $product->sizeGuide=$request->input('sizeGuide');


        $product->save();

        $imagePath = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $fileName = date('His') . $fileName;
            $path = $request->file('image')->storeAs('images', $fileName, 'public');
            $imageModel = new Image;
            $imageModel->path = $path; 
            $product->image()->save($imageModel);
        }
    
        $product->load('image');


        return response()->json([

            'status' => 200,
            'message' => 'product created successfully',
            'path'=>$path

        ]);


    }

    public function getProduct(string $id){


        $product = Product::with('image')->findOrFail($id);

        $productData = [];

        
            $imagePaths = [];
            
            foreach ($product->image as $image) {
                $imagePath = asset('public/storage/' . $image->path);
                $imagePaths[] = $imagePath;
            }
    
            $productData[] = [
                'id' => $product->id,
                'name' => $product->name,
                'gender' => $product->gender,
                'category' => $product->category,
                'color' => $product->color,
                'sizes' => $product->sizes,
                'stock' => $product->stock,
                'price' => $product->price,
                'priceAfterCode' => $product->priceAfterCode,
                'sizeGuide' => $product->sizeGuide,
                'imagePaths' => $imagePaths,
            ];
        
    
        return response()->json([
            'status' => 200,
            'message' => 'Products retrieved successfully',
            'products' => $productData,
        ]);
    }

    public function getAllProducts(){

        $products = Product::with('image')->get();

        $productData = [];

        foreach ($products as $product) {
            $imagePaths = [];

        foreach ($product->image as $image) {
            $imagePath = asset('public/storage/' . $image->path);
            $imagePaths[] = $imagePath;
        }

        $productData[] = [
            'id' => $product->id,
            'name' => $product->name,
            'gender' => $product->gender,
            'category' => $product->category,
            'color' => $product->color,
            'sizes' => $product->sizes,
            'stock' => $product->stock,
            'price' => $product->price,
            'priceAfterCode' => $product->priceAfterCode,
            'sizeGuide' => $product->sizeGuide,
            'imagePaths' => $imagePaths,
        ];
    }

    return response()->json([
        'status' => 200,
        'message' => 'Products retrieved successfully',
        'products' => $productData,
    ]);

    }


    public function EditProductInfo(Request $request, string $id)
    {
        $product = Product::findOrFail($id);


        $product->name=$request->input('name');
        $product->gender=$request->input('gender');
        $product->category=$request->input('category');
        $product->color=$request->input('color');
        $product->sizes=$request->input('sizes');
        $product->stock=$request->input('stock');
        $product->price=$request->input('price');
        $product->priceAfterCode=$request->input('priceAfterCode');
        $product->sizeGuide=$request->input('sizeGuide');

        $product->update();

        return response()->json([

            'status' => 200,
            'message' => 'order status updated successfully',


        ]);


    }



    public function deleteProduct(string $id)
    {
        $product = Product::findOrFail($id);
        $imagePaths = $product->image->pluck('path')->toArray();

        // Delete images from the database
        $product->image()->delete();
    
        // Delete image files from storage
        foreach ($imagePaths as $path) {
            Storage::delete('public/' . $path);
        }
        $product->delete();

        return response()->json([

            'status' => 200,
            'message' => 'Product deleted successfully'


        ]);
    }
}
