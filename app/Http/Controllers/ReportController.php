<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $project_id = $request->project_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $totalMins = 0;
        $events = Event::where([
            ['user_id', $user_id],
            ['project_id', $project_id]
        ])->get();

        $projectSelected = Project::where('id', $project_id)->first();
        $userSelected = User::where('id', $user_id)->first();

        foreach ($events as $event) {
            $startDate = Carbon::createFromFormat("Y-m-d H:i:s", $event->start_date);
            $endDate = Carbon::createFromFormat("Y-m-d H:i:s",  $event->end_date);
            $event->minutes = $startDate->diffInMinutes($endDate);
            $totalMins += $event->minutes;
            $event->user_name = User::where('id', $user_id)->first()->name;
        }
        $pdfFilename = 'eventReport.pdf';

        $pdfFile = Pdf::loadView('layouts.reportEvents', [
            'events' => $events,
            'startDate' => $start_date,
            'endDate' => $end_date,
            'totalMins' => $totalMins,
            'project' => $projectSelected,
            'user' => $userSelected,
        ]);

        $pdfFile->save($pdfFilename);

        Storage::disk('local')->put($pdfFilename, $pdfFile->stream());

        return response()->json(['action' => 'success']);
    }
}
