<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Code;

class CodeController extends Controller
{



    public function createCode(Request $request)
    {
        $code = new code;

        $code->coachName=$request->input('coachName');
        $code->code=$request->input('code');
        $code->discount=$request->input('discount');


        $code->save();

        return response()->json([

            'status' => 200,
            'message' => 'code created successfully',


        ]);


    }

    public function getAllCodes(){


        $codes = Code::all();

        return response()->json([

            'status' => 200,
            'codes' => $codes,


        ]);

    }

    public function checkCode(Request $request)
    {
        

        $code = Code::where('code', $request->code)->first();
    
        if ($code) {

            
            return response()->json([

                'code'=>200,
                'message' => 'Discount code valid',
                'discountCode'=>$code
               
              
            ]);
        } 
        
        else {

            return response()->json([

                'code'=>401,
                'message' => 'Invalid code'

            ]);
        }
    }




    public function deleteCode(string $id)
    {
        $code = code::findOrFail($id);
        $code->delete();

        return response()->json([

            'status' => 200,
            'message' => 'code deleted successfully'


        ]);
    }
}
