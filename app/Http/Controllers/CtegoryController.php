<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CtegoryStoreRequest;
use App\Http\Requests\CtegoryUpdateRequest;
use App\Http\Resources\CtegoryResource;

class CtegoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return CtegoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CtegoryStoreRequest $request)
    {
        $category = Category::create($request->validated());
        return CtegoryResource::make($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CtegoryResource($category->load("books"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());
        return CtegoryResource::make($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            "message" => "deleted"
        ]);
    }
}
