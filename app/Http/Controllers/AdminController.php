<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;



class AdminController extends Controller
{
   



    public function createAdmin(Request $request)
    {
        $validated = $request->validate([


            'name'=>'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|max:24',

        ]);

        if(!$validated){

            return response()->json([

                'status' => 400,
                'message' => 'data enterd not valid'
    
    
            ]);

        }

        $admin = new admin;

        $admin->name = $request->input('name');
        $admin->email=$request->input('email');
        $password = Hash::make($request->input('password'));
        $admin->password=$password;

        $admin->save();


        return response()->json([

            'status' => 200,
            'message' => 'admin created successfully'


        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Authentication successful


            return response()->json([

                'status' => 200,
                'message' => 'Login successful',
                'admin' => $admin->name,
            ]);
        }

        return response()->json([

            'status' => 401,
            'message' => 'invalid credentials',
            
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }


}
