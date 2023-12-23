<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use App\Models\Code;




class OrderController extends Controller
{





    public function createOrder(Request $request)
    {

        $discount=0;


        $order = new Order;

        $order->customerName=$request->input('customerName');
        $order->phoneNumber=$request->input('phoneNumber');
        $order->state=$request->input('state');

        ////////////////////////////////// To handle dilivery address

        if($request->input('address')!=null){

            $order->address=$request->input('address');

            $order->qadmousName=null;
            $order->qadmousNumber=null;
            $order->qadmousBranch=null;
        }
        else{

            $order->address=null;

            $order->qadmousName=$request->input('qadmousName');
            $order->qadmousNumber=$request->input('qadmousNumber');
            $order->qadmousBranch=$request->input('qadmousBranch');
        }



        $order->totalPrice=$request->input('totalPrice');
        $totPrice=$request->input('totalPrice');

         
        ////////////////////////////////// To handle discount code and price after discount

        if($request->input('code')!=null){

            $code =Code::where('code', '=', $request->input('code'))->first();

            $order->coachName=$code->coachName;
            $order->code=$code->code;

            $discount=$code->discount;
            $discount=$discount/100;
            
            $order->totalPriceAfterDiscount= $totPrice - ( $discount * $totPrice) ;

        }
        else{

            $order->coachName=null;
            $order->code=null;
            
            $order->totalPriceAfterDiscount= $request->input('totalPrice');


        }

        
        

        $order->status = "pending";

        $order->save();
        ////////////////////////////////// To handle products of the order and the subtotal prices

    
        foreach ($request->input('products') as $productData) {

            $product = Product::find($productData['product_id']);
            $price = $product->price;
            $quantity = $productData['quantity'];


            if($quantity > $product->stock){

                $order->delete();

                return response()->json([

                    'status' => 401,
                    'message' => 'not enough stock'
        
                ]);
            }



            
            $subtotal=$quantity * $price;
            $subtotalAfterDiscount = ($quantity * $price) - ( $discount * ($quantity * $price) );
            
            $product->stock=$product->stock - $quantity;
            $product->update();

            $order->products()->attach(
                $productData['product_id'],
                [
                    'quantity' => $quantity,
                    'size'=>$productData['size'],
                    'subtotal' => $subtotal,
                    'subtotalAfterDiscount'=>$subtotalAfterDiscount

                ]);

        }
    

    
        return response()->json([

            'status' => 200,
            'message' => 'تمت العملية بنجاح'


        ]);
    }
    


    public function updateOrderStatus(Request $request, string $id)
    {
        $order = order::findOrFail($id);

        $order->status = $request->input('status');

        $order->update();

        return response()->json([

            'status' => 200,
            'message' => 'order status updated successfully',


        ]);


    }



    public function getAllOrders(){


        $orders = Order::with([
            'products' => function ($query) {
                // Specify the attributes you want to retrieve for the Product model
                $query->select('name', 'gender', 'category', 'color', 'price', 'priceAfterCode',);
            }
        ])->get();

        return response()->json([

            'status' => 200,
            'orders' => $orders,


        ]);

    }
    



    public function getAllAcceptedOrders(){


        $acceptedOrders = Order::with('products')->where('status', '=' ,'accepted')->get();

        return response()->json([

            'status' => 200,
            'acceptedOrders' => $acceptedOrders,


        ]);

    }

    public function getAllRejectedOrders(){


        $rejectedOrders = Order::with('products')->where('status', '=' ,'rejected')->get();

        return response()->json([

            'status' => 200,
            'rejectedOrders' => $rejectedOrders,


        ]);

    }
}
