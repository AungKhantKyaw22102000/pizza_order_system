<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get all product list
    public function productList(){
        $products = Product::get();

        return response()->json($products, 200);
    }

    // get all category list
    public function categoryList(){
        $category = Category::orderBy('id','desc')->get();

        return response()->json($category, 200);
    }

    // create category
    public function createCategory(Request $request){
        $data = [
            'name' => $request->name ,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $response = Category::create($data);
        return response()->json($response, 200);
    }

    // create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);
        $response = Contact::create($data);
        $data = Contact::get();
        return response()->json($data,200);
    }

    // delete category
    public function deleteCategory(Request $request){
        $data = Category::where('id',$request->category_id)->first();
        if (isset($data)){
            Category::where('id',$request->category_id)->delete();
            return response()->json(['status' => true, 'message' => 'delete success'], 200);
        }
        return response()->json(['status' => false, 'message' => 'there is no category...'], 200);

    }

    //creat contact
    private function getContactData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'message' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
