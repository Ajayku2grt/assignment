<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function product_list(){
        if(request()->ajax()){
            $User=User::when('filter',function($q){
				if(request()->has('username') && !empty(request('username'))){
                    $q->where('id',request('username'));
                }
                return $q;
			});
            return datatables()->of($User)->make(true);
        }
        $Users = User::all();
        return view('product',compact('Users'));
    }

    public function form(){
        return view('form');
    }

}
