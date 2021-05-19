<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
class CustomerController extends Controller
{
    //
public  function listCustomers()
{
    $customerdata= Customer::all();
    return response()->json(['data'=>$customerdata,'message'=>'data get successfully']);
}

public  function addCustomer(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required'
    ]);

    $customer = new Customer();

    $customer->name=$request->name;
    $customer->email=$request->email;
    $customer->phone=$request->phone;
    $customer->save();
}

public function deleteCustomer($customerId)
{
    Customer::destroy($customerId);
  //  $customer->delete();

    return response()->json([
        'message' => 'Customer has been removed successfully.',
    ]);
}

public  function  updateCustomer(Request $request)
{
    $customer = Customer::where('id', $request->id)->first();
    $customer->name=$request->name;
    $customer->email=$request->email;
    $customer->phone=$request->phone;
    $customer->save();

    return response()->json([
        'message' => "Customer has been updated successfully"
    ]);

}




}
