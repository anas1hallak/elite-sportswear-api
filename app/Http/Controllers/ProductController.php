<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function createProduct(Request $request)
    {
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
            $image = $request->file('image');
            $imagePath = $image->store('product_images', 'public');

            $imageModel = new Image(['path' => $imagePath]);
            $product->image()->save($imageModel);
        }

        $product->load('image'); // Reload the relationship to get the full image details


        return response()->json([

            'status' => 200,
            'message' => 'product created successfully',


        ]);


    }

    public function getProduct(string $id){


        $product = Product::with('image')->findOrFail($id);

        return response()->json([

            'status' => 200,
            'product' => $product,


        ]);

    }

    public function getAllProducts(){


        $products = Product::with('image')->get();

        return response()->json([

            'status' => 200,
            'products' => $products,


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
