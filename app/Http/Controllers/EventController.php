<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Project;
use DateTime;

class EventController extends Controller
{
    public function show($id)
    {
        $events = Event::where('user_id', $id)->get();
        $projects = Project::where('user_id', $id)->get();

        foreach ($events as $event) {
            $event->projectName = Project::where('id', $event->project_id)->first()->name;
        }

        return response()->json([
            "myEvents" => $events,
            "myProjects" => $projects
        ]);
    }

    public function store(Request $request)
    {

        $event = new Event();
        $event->text = strip_tags($request->text);
        $event->start_date = DateTime::createFromFormat('d/m/Y H:i', $request->start_date);
        $event->end_date = DateTime::createFromFormat('d/m/Y H:i', $request->end_date);
        $event->project_id = $request->project_id;
        $event->user_id = 1;
        $event->save();

        return response()->json([
            "action" => "created successfully",
            "event" => $event
        ]);
    }

    public function update($id, Request $request)
    {
        $event = Event::find($id);

        $event->text = strip_tags($request->text);
        $event->start_date = $request->start_date;
        $event->end_date = $request->end_date;
        $event->save();

        return response()->json([
            "action" => "updated successfully",
            "event" => $event
        ]);
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();

        return response()->json([
            "action" => "deleted successfully"
        ]);
    }
}
