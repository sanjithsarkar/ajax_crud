<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Psy\VersionUpdater\Downloader;

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

            foreach ($data as $item) {
                $item->image = Storage::url($item->image);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit mr-2 btn btn-primary btn-sm editProduct">Edit</a>';

                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct">Delete</a>';

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

        $validator =  Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
            'image' => 'required|image',
            'price' => 'required',
            //'image' => 'required|mimes:pdf|max:2048',
        ]);

        //------------------------ Store Data without Image

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()]);
        // } else {

        //     Product::insert([
        //         'name' => $request->name,
        //         'price' => $request->price,
        //         'created_at' => Carbon::now(),
        //     ]);

        //     return response()->json(['success' => 'Validation passed']);
        // }


        //------------------------ Store Data with Image

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imgPath = $image->storeAs('public/images', $imageName);

            //dd($request->all());
            Product::insert([
                'name' => $request->name,
                'price' => $request->price,
                'image' => $imgPath,
                'created_at' => Carbon::now(),
            ]);

            return response()->json(['success' => 'Validation passed']);
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $validator =  Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required|image',
            'price' => 'required',
            //'image' => 'required|mimes:pdf|max:2048',
        ]);

        //dd($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        } else {

            $product = Product::where("id", $id)->first();
            if ($request->file('image')) {
                $image = $request->file('image');
                unlink(storage_path('app/' . $product->image));
                $imageName = $image->getClientOriginalName();
                $imgPath = $image->storeAs('public/images', $imageName);

                $product->name = $request->name;
                $product->price = $request->price;
                $product->image = $imgPath;
                $product->save();
            }
        }
    }

    public function deleteProduct($id)
    {

        // $product = Product::where("id", $id)->delete();

        $product = Product::findOrFail($id);

        // Delete the product's image from storage
        $imagePath = storage_path('app/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product and its associated image from the database
        $product->delete();

        return response()->json('deleted!!');
    }
}
