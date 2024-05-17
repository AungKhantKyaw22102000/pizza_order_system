<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // direct product list
    public function list(){
        $pizzas = Product::when(request('key'),function($query){
                    $query->where('name','like','%'.request('key').'%');
                })
                ->orderBy('created_at','desc')->paginate(3);
                $pizzas->appends(request()->all());
        return view('admin.product.pizzaList',compact('pizzas'));
    }

    // direct product create page
    public function createPage(){
        $categories = Category::select('id','name')->get();
        return view('admin.product.create', compact('categories'));
    }

    // product create
    public function create(Request $request){
        $this->productValidationCheck($request);
        $data = $this->requestProductInfo($request);
        $fileName = uniqid() . $request->file('productImage')->getClientOriginalName();
        $request->file('productImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('product#list');
    }

    // delete product
    public function delete($id){
        Product::where('id', $id)->delete();
        return back()->with(['deleteSuccess'=>'Product is Deleted Success...']);
    }

    // edit product
    public function edit($id){
        $pizza = Product::where('id',$id)->first();
        return view('admin.product.edit',compact('pizza'));
    }

    // request product info
    private function requestProductInfo($request){
        return [
            'category_id' => $request->productCategory,
            'name' => $request->productName,
            'description' => $request->productDescription,
            'price' => $request->productPrice,
            'waiting_time' => $request->waitingTime,
        ];
    }

    // product validation check
    private function productValidationCheck($request){
        Validator::make($request->all(),[
            'productName' => 'required|min:5|unique:products,name',
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productImage' => 'required|mimes:jpg,png,jpeg|file',
            'productPrice' => 'required',
            'waitingTime' => 'required',
        ],[])->validate();
    }
}
