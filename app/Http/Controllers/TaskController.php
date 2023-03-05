<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // $products = Task::select(['id', 'name', 'description', 'image']);
        // return DataTables::of($products)->make(true);

        if ($request->ajax()) {

            $data = Task::latest()->get();

            foreach ($data as $item) {
                $item->image = Storage::url($item->image);
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('task.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:tasks|max:255',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        if ($request->file('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imgPath = $image->storeAs('public/task', $imageName);

            //dd($request->all());
            Task::insert([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $imgPath,
                'created_at' => Carbon::now(),
            ]);
        } else {
            Task::insert([
                'name' => $request->name,
                'description' => $request->description,
                'created_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Task Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('task.edit')->with('task', $task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // $validatedData = $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
        //     'image' => 'required|image',
        // ]);

        //dd($request->all());

        $taskUp = Task::where('id', $task->id)->first();

        //dd($taskUp);

        if ($request->file('image')) {
            $image = $request->file('image');
            unlink(storage_path('app/'.$taskUp->image));
            $imageName = $image->getClientOriginalName();
            $imgPath = $image->storeAs('public/task', $imageName);

            $taskUp->name = $task->name;
            $taskUp->description = $task->description;
            $taskUp->image = $imgPath;
            $taskUp->save();
        } 

        $notification = array(
            'message' => 'Task Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $product = Task::where('id', $task->id)->first();

        // Delete the product's image from storage
        $imagePath = storage_path('app/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product and its associated image from the database
        $product->delete();

    }

    public function deleteTask($id){
        $product = Task::findOrFail($id);

        // Delete the product's image from storage
        $imagePath = storage_path('app/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product and its associated image from the database
        $product->delete();
    }
}
