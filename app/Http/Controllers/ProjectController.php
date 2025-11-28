<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = $request->user()->project()->get();

        return response()->json([
            'success' => true,
            'message' => 'Project retrieved successfully',
            'data' => $projects,
        ], 200);
    }

    public function create(Request $request) {
        
    }

    public function edit(Request $request, $id) {

    }

    public function delete(Request $request, $id) {

    }
}
