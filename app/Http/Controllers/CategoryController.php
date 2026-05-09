<?php

namespace App\Http\Controllers;
use App\Models\job_categorie;
 
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
 

use App\Http\Requests\CategoryupdateRequest;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data=job_categorie::latest();
        if($request->input('arcive')=='true'){
            $data=$data->onlyTrashed();
        }
        $data=$data->paginate(10)->onEachSide(1);
        return view('category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( CategoryRequest $request)
    {
        //
        $validatedData = $request->validated();
        job_categorie::create($validatedData);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)

    {
        $category = job_categorie::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( CategoryupdateRequest $request, string $id)
    {
        $category = job_categorie::findOrFail($id);
        $validatedData = $request->validated();

        $category->update($validatedData);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = job_categorie::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category  archived successfully.');
    }
    public function restore(string $id)
    {
        $category = job_categorie::withTrashed()->findOrFail($id);
        $category->restore();
        return back()->with('success', 'Category restored successfully!');
    }
}
