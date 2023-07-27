<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    public function store(Request $request){
        // try{
            // dd($request->all());
            $user = new User;
            $user->name = $request->name;
            $user->username = $request->username;
            $user->phone    = $request->phone;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            for ($x = 0; $x < count($request->product_name); $x++) {           
                $product = new Product;
                $product->name = $request->product_name[$x];
                $product->price = $request->product_price[$x];
                $product->quantity = $request->product_quantity[$x];
                $product->type = $request->product_type[$x];
                $product->discount = $request->discount[$x]??NULL;
                $product->user_id = $user->id;
                $product->save();
            }

        return back()->with('success','Item created successfully!');
        // }catch(\Exception $e){
        //     return back()->with('error','Something went wrong!');
        // }
    }
}
