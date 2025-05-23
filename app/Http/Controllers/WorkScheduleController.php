<?php
// app/Http/Controllers/WorkScheduleController.php 
namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\Department;

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
    $staffNames  = Schedule::distinct()->pluck('staff_name');
    $departments = Department::orderBy('name')->get();

    // pass an *empty* Schedule so $schedule is always defined
    $schedule = new Schedule();

    return view(
      'schedules.create',
      compact('staffNames','departments','schedule')
    );
}
public function store(Request $request)
{
    $rules = [
        'staff_name'  => 'required|string|max:255',
        'role'        => 'required|string|max:100',
        'date'        => 'required|date',
        // enforce exactly HH:mm (24-hour)…
        'shift_start' => 'required|date_format:H:i',
        'shift_end'   => 'required|date_format:H:i|after:shift_start',
        'department'  => 'required|string|max:100',
    ];

    $messages = [
        'shift_start.date_format' => 'Use 24-hour time, e.g. 14:30.',
        'shift_end.date_format'   => 'Use 24-hour time, e.g. 14:30.',
        'shift_end.after'         => 'The shift end time must be after the shift start time.',
    ];

    $data = $request->validate($rules, $messages);

    Schedule::create($data);

    return redirect()
        ->route('schedules.index')
        ->with('success','Schedule added successfully.');
}


public function edit(Schedule $schedule)
{
    $staffNames  = Schedule::distinct()->pluck('staff_name');
    $departments = Department::orderBy('name')->get();

    return view(
      'schedules.edit',
      compact('schedule','staffNames','departments')
    );
}

 public function update(Request $request, Schedule $schedule)
{
    $rules = [
        'staff_name'  => 'required|string|max:255',
        'role'        => 'required|string|max:100',
        'date'        => 'required|date',
        'shift_start' => 'required|date_format:H:i',
        'shift_end'   => 'required|date_format:H:i|after:shift_start',
        'department'  => 'required|string|max:100',
    ];
    $messages = [
        'shift_start.date_format' => 'Use 24-hour time, e.g. 14:30.',
        'shift_end.date_format'   => 'Use 24-hour time, e.g. 14:30.',
        'shift_end.after'         => 'The shift end time must be after the shift start time.',
    ];

    $data = $request->validate($rules, $messages);
    $schedule->update($data);

    return redirect()
        ->route('schedules.index')
        ->with('success','Schedule updated successfully.');
}

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')
                         ->with('success','Schedule deleted.');
    }
}
