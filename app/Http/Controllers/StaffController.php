<?php

namespace App\Http\Controllers;

use App\Models\Staff; // 1. تم إضافة استدعاء الموديل
use App\Http\Requests\StaffStoreRequest;
use App\Http\Requests\StaffUpdataRequest;
use App\Http\Resources\StaffResource;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return StaffResource::collection(Staff::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffStoreRequest $request)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }

        $Staff = Staff::create($request->all()); 

        return StaffResource::make($Staff);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return StaffResource::make(Staff::findOrFail($id)); // تصحيح response و findOrFail
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }
        $staff = Staff::findOrFail($id);
            
        $staff->update($request->all());

        return StaffResource::make($staff); // تصحيح return
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->role !== "admin") {
            return response()->json([
                "message" => "Only admins can do this"
            ], 403);
        }
        Staff::findOrFail($id)->delete(); // تصحيح الاستدعاء بإزالة $

        return response()->json("Staff member deleted successfully.");
    }
}