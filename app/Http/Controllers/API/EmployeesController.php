<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;


class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $employees = Employee::orderBy('id', 'desc')->get();
        return response()->json($employees);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $employee = Employee::create($request->all());
        return response()->json($employee, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return response()->json($employee, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Employee::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
