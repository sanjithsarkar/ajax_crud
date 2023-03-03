<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

use function GuzzleHttp\Promise\all;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $data = Product::latest()->get();
        // return view('product.index');

        if ($request->ajax()) {
  
            $data = Product::latest()->get();
  
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editProduct">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product = Product::find($product->id);
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function storeProduct(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'name' => 'required|unique:products|max:255',
        ]);

        Product::insert([
            'name' => $request->name,
            'price' => $request->price,
            'created_at' => Carbon::now(),
        ]);

        return response()->json("done");
    }

    public function updateProduct(Request $request ,$id){

        $request->validate([
            'name' => 'required',
        ]);
        $product = Product::where("id", $id)->first();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();
        return response()->json($product);
    }

    public function deleteProduct($id){

        $product = Product::where("id", $id)->delete();
        return response()->json('deleted!!');
    }
}
