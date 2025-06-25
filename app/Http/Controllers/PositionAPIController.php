<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
         $query = Position::query()->with('parent');

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $positions = $query->orderBy('name')->get();

        return response()->json($positions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:positions',
            'reports_to' => 'nullable|exists:positions,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        $position = Position::create($request->all());

        return response()->json($position, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
            $position = Position::with('parent', 'children')->findOrFail($id);
        return response()->json($position);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
          $position = Position::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:positions,name,' . $position->id,
            'reports_to' => 'nullable|exists:positions,id'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }



        // Prevent circular references
        if ($request->reports_to == $position->id) {
            return response()->json(['error' => 'A position cannot report to itself'], 422);
        }

        $position->update($request->all());

        return response()->json($position);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy ($id)
    {
          $position = Position::findOrFail($id);

        // Check if this position is a parent to others
        if ($position->children()->count() > 0) {
            return response()->json(['error' => 'Cannot delete a position that has subordinates'], 422);
        }

        $position->delete();

        return response()->json(null, 204);
    }


      public function showAll()
    {


        $position = Position::with('parent', 'children')->get();


        return response()->json($position);
    }


}
