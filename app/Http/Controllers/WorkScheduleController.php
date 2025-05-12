<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        $schedules = Schedule::orderBy('date','desc')->paginate(10);
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'staff_name'  => 'required|string|max:255',
            'role'        => 'required|string|max:100',
            'date'        => 'required|date',
            'shift_start' => 'required|date_format:H:i',
            'shift_end'   => 'required|date_format:H:i|after:shift_start',
            'department'  => 'required|string|max:100',
        ]);

        Schedule::create($data);

        return redirect()->route('schedules.index')
                         ->with('success','Schedule added successfully.');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $request->validate([
            'staff_name'  => 'required|string|max:255',
            'role'        => 'required|string|max:100',
            'date'        => 'required|date',
            'shift_start' => 'required|date_format:H:i',
            'shift_end'   => 'required|date_format:H:i|after:shift_start',
            'department'  => 'required|string|max:100',
        ]);

        $schedule->update($data);

        return redirect()->route('schedules.index')
                         ->with('success','Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
                         ->with('success','Schedule deleted.');
    }
}
