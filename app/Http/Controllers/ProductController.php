<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    // direct product list
    public function list(){
        $pizzas = Product::select('products.*','categories.name as category_name')
                ->when(request('key'),function($query){
                    $query->where('products.name','like','%'.request('key').'%');
                })
                ->leftJoin('categories','products.category_id','categories.id')
                ->orderBy('products.created_at','desc')
                ->paginate(3);
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
        $this->productValidationCheck($request,"create");
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
        $pizza = Product::select('products.*','categories.name as category_name')
                 ->where('products.id',$id)
                 ->leftJoin('categories','products.category_id','categories.id')
                 ->first();
        return view('admin.product.edit',compact('pizza'));
    }

    // update product direct route
    public function updatePage($id){
        $pizza = Product::where('id',$id)->first();
        $category = Category::get();
        return view('admin.product.update',compact('pizza', 'category'));
    }

    // update product
    public function update(Request $request){
        $this->productValidationCheck($request, 'update');
        $data = $this->requestProductInfo($request);

        if($request->hasFile('productImage')){
            $oldImageName = Product::where('id',$request->pizzaId)->first();
            $oldImageName = $oldImageName->image;

            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }
            $fileName = uniqid().$request->file('productImage')->getClientOriginalName();
            $request->file('productImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }
        Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list');
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
    private function productValidationCheck($request, $action){
        $validationRule = [
            'productName' => 'required|min:5|unique:products,name,'.$request->pizzaId,
            'productCategory' => 'required',
            'productDescription' => 'required|min:10',
            'productPrice' => 'required',
            'waitingTime' => 'required',
        ];
        $validationRule['productImage'] = $action == "create" ? "required|mimes:jpg,png,jpeg|file" : "mimes:jpg,png,jpeg|file";

        Validator::make($request->all(),$validationRule,[])->validate();
    }
}
