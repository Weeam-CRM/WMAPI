<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function index()
    {
        $developers = Developer::orderBy('id', 'desc')->get();
        return response()->json($developers);
    }

    public function store(Request $request)
    {
        $developer = Developer::create($request->all());
        return response()->json($developer, 201);
    }

    public function show($id)
    {
        $developer = Developer::findOrFail($id);
        return response()->json($developer);
    }

    public function update(Request $request, $id)
    {
        $developer = Developer::findOrFail($id);
        $developer->update($request->all());
        return response()->json($developer, 200);
    }

    public function destroy($id)
    {
        Developer::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
