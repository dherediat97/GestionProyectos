<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {

        $projects = new Project();
        return response()->json($projects->get());
    }
}
