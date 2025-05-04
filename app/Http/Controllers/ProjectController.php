<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::orderBy('last_used_date', 'DESC')->get();
        return response()->json($projects);
    }
}
