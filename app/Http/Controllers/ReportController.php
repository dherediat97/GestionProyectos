<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{

    public function store(Request $request)
    {
        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $totalMins = $request->totalMins;

        $attributes = [
            'user_id' => $user_id,
            'project_id' => $project_id
        ];
        $events = Event::where('project_id', $project_id)->get();

        $projectSelected = Project::where('id', $project_id)->first();
        $userSelected = User::where('id', $user_id)->first();

        foreach ($events as $event) {
            // $event->start_date = date('d/m/Y H:m', strtotime($start_date));
            // $event->end_date = date('d/m/Y H:m', strtotime($end_date));
            $event->minutes = 60;
            $event->user_name = User::where('id', $user_id)->first()->name;
        }

        $pdf = Pdf::loadView('pdf', [
            'events' => $events,
            'startDate' => $start_date,
            'endDate' => $end_date,
            'project' => $projectSelected,
            'user' => $userSelected,
            'totalMins' => $totalMins,
        ]);

        return $pdf->download();
    }
}
