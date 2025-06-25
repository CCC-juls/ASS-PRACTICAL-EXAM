<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PositionWebController extends Controller
{
    public function index()
    {
        $positions = Position::with('parent')
            ->orderBy('id','asc')
            ->get();

        return view('positions.index', compact('positions'));
    }


    public function createPosition(){

          $positions = Position::with('parent')
            ->orderBy('name')
            ->get();

        return view('positions.create',compact('positions'));
    }


    Public function editPosition($id) {

         $positions = Position::with('parent')
            ->orderBy('name')
            ->get();

        $position = Position::where('id',$id)->first();



        return view('positions.edit' ,compact('position','positions'));
    }


}
