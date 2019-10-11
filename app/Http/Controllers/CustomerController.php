<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  public function all()
   {
       $customers = Customer::all();
       return response()->json([
           "customers" => $customers
       ], 200);
   }
   public function getUserCustomer($id)
   {
        $customers = User::find($id)->customers;

        return response()->json([
            "customers" => $customers
        ],200);
   }
   public function get($id)
   {
       $customer = Customer::whereId($id)->first();
       return response()->json([
           "customer" => $customer
       ], 200);
   }
   public function new(Request $request)
   {

     $customer = Customer::create($request->only(["name", "email", "phone", "website","user_id"]));

      return response()->json([
          "customer" => $customer
      ], 200);
   }

   public function edit(Request $request)
   {
        $customer = Customer::find($request->id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->save();


        return response()->json([
            "customer" => $customer
        ],200);
    
   }

}
