<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class ConsultantController extends Controller
{
    public function index(Request $request){

        if ($request->ajax()) {
            $consultants = User::where("role","consultant")->get();
            return Datatables::of($consultants)
              ->toJson();
        }

        return view("admin.consultant.index");
    }

    public function approve(Request $request){

        $consultant = User::where("id",$request->userId)->first();
        $consultant->is_approved = $consultant->is_approved ? 0 : 1;
        $consultant->save();

        return response()->json(["success"=>true,"approved"=>$consultant->is_approved ]);

    }



}

