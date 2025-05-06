<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public function index()
    {
        $projects = Project::orderBy('last_used_date', 'DESC')->get();
        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $projectName = $request->name;
        $userId = $request->user_id;

        $project = new Project();
        $project->user_id = $userId;
        $project->active = 1;
        $project->created_at = date("Y-m-d h:i:s");
        $project->updated_at = date("Y-m-d h:i:s");
        $project->last_used_date = date("Y-m-d h:i:s");
        $project->name = $projectName;
        $project->save();

        return response()->json(["action" => 'created']);
    }
}
