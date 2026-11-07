<?php

namespace App\Http\Controllers;

use App\Models\Staff; // 1. تم إضافة استدعاء الموديل
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Staff::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $Staff = Staff::create($request->all()); // تصحيح اسم المتغير وحالة الأحرف

        return response()->json($Staff);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Staff::findOrFail($id)); // تصحيح response و findOrFail
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        $request->validate([
            "name"         => "sometimes|required|string", // تصحيح =>
            "email"        => "sometimes|required|email|unique:staff,email," . $staff->id,
            "password"     => "sometimes|required|string|min:8", // تصحيح min:8
            "role"         => "sometimes|required|string",
            "phone_number" => "sometimes|required|string|unique:staff,phone_number," . $staff->id,
        ]);

        $staff->update($request->all());

        return response()->json($staff); // تصحيح return
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Staff::findOrFail($id)->delete(); // تصحيح الاستدعاء بإزالة $

        return response()->json("Staff member deleted successfully.");
    }
}