<?php
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

    // Display a paginated list of schedules
    public function index()
    {
        $schedules = Schedule::orderBy('date', 'desc')->paginate(10);
        return view('schedules.index', compact('schedules'));
    }

    // Show the form to create a new schedule
    public function create()
    {
        // Fetch distinct staff names and departments for dropdown selection
        $staffNames  = Schedule::distinct()->pluck('staff_name');
        $departments = Department::orderBy('name')->get();

        // Pass an empty schedule object for the form
        $schedule = new Schedule();

        return view('schedules.create', compact('staffNames', 'departments', 'schedule'));
    }

public function store(Request $request)
{
  $rules = [
    'staff_name'   => 'required|string|max:255',
    'role'         => 'required|string|max:100',
    'date'         => 'required|date',
    // arrays but NOT required up-front
    'shift_start'  => 'array',
    'shift_end'    => 'array',
    'include'      => 'array',
    'department'   => 'required|string|max:100',
    'start_day'    => 'required|string',
    'shift_length' => 'required|numeric',
];

foreach (['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day) {
    $rules["shift_start.$day"] = 'nullable|date_format:H:i|required_if:include.'.$day.',1';
    $rules["shift_end.$day"]   = 'nullable|date_format:H:i|after:shift_start.'.$day.'|required_if:include.'.$day.',1';
    $rules["include.$day"]     = 'nullable|boolean';
}

$data = $request->validate($rules);


Schedule::create([
    'staff_name'  => $data['staff_name'],
    'role'        => $data['role'],
    'date'        => $data['date'],
    'department'  => $data['department'],
    'start_day'   => $data['start_day'],
    'shift_length'=> $data['shift_length'],
    
    // Store the shift start and end times for each day of the week
    'shift_start_sunday'    => $data['shift_start']['Sunday'] ?? null,
    'shift_end_sunday'      => $data['shift_end']['Sunday'] ?? null,
    
    'shift_start_monday'    => $data['shift_start']['Monday'] ?? null,
    'shift_end_monday'      => $data['shift_end']['Monday'] ?? null,
    
    'shift_start_tuesday'   => $data['shift_start']['Tuesday'] ?? null,
    'shift_end_tuesday'     => $data['shift_end']['Tuesday'] ?? null,
    
    'shift_start_wednesday' => $data['shift_start']['Wednesday'] ?? null,
    'shift_end_wednesday'   => $data['shift_end']['Wednesday'] ?? null,
    
    'shift_start_thursday'  => $data['shift_start']['Thursday'] ?? null,
    'shift_end_thursday'    => $data['shift_end']['Thursday'] ?? null,
    
    'shift_start_friday'    => $data['shift_start']['Friday'] ?? null,
    'shift_end_friday'      => $data['shift_end']['Friday'] ?? null,
    
    'shift_start_saturday'  => $data['shift_start']['Saturday'] ?? null,
    'shift_end_saturday'    => $data['shift_end']['Saturday'] ?? null,

    // Store whether to include each day's shift
    'include_sunday'    => $data['include']['Sunday'] ?? 0,
    'include_monday'    => $data['include']['Monday'] ?? 0,
    'include_tuesday'   => $data['include']['Tuesday'] ?? 0,
    'include_wednesday' => $data['include']['Wednesday'] ?? 0,
    'include_thursday'  => $data['include']['Thursday'] ?? 0,
    'include_friday'    => $data['include']['Friday'] ?? 0,
    'include_saturday'  => $data['include']['Saturday'] ?? 0,
]);

    return redirect()->route('schedules.index')->with('success', 'Schedule added successfully.');
}

public function show(Schedule $schedule)
{
    try {
        // Return only the modal content view for AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return view('schedules.modal_content', compact('schedule'))->render();
        }
        
        // For regular requests, return full page view (optional)
        return view('schedules.show', compact('schedule'));
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Schedule show error: ' . $e->getMessage());
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'error' => 'Unable to load schedule details. Please try again.'
            ], 500);
        }
        
        return back()->withErrors(['error' => 'Unable to load schedule details.']);
    }
}


    // Show the form to edit an existing schedule
    public function edit(Schedule $schedule)
    {
        // Fetch staff names and departments for the dropdown selection
        $staffNames  = Schedule::distinct()->pluck('staff_name');
        $departments = Department::orderBy('name')->get();

        return view('schedules.edit', compact('schedule', 'staffNames', 'departments'));
    }
public function update(Request $request, Schedule $schedule)
{
$rules = [
    'staff_name'   => 'required|string|max:255',
    'role'         => 'required|string|max:100',
    'date'         => 'required|date',
    // arrays but NOT required up-front
    'shift_start'  => 'array',
    'shift_end'    => 'array',
    'include'      => 'array',
    'department'   => 'required|string|max:100',
    'start_day'    => 'required|string',
    'shift_length' => 'required|numeric',
];

foreach (['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $day) {
    $rules["shift_start.$day"] = 'nullable|date_format:H:i|required_if:include.'.$day.',1';
    $rules["shift_end.$day"]   = 'nullable|date_format:H:i|after:shift_start.'.$day.'|required_if:include.'.$day.',1';
    $rules["include.$day"]     = 'nullable|boolean';
}

$data = $request->validate($rules);


    // Update the schedule with the new data
 $schedule->update([
    'staff_name'       => $data['staff_name'],
    'role'             => $data['role'],
    'date'             => $data['date'],
    'department'       => $data['department'],
    'start_day'        => $data['start_day'],
    'shift_length'     => $data['shift_length'],

    // per-day times
    'shift_start_sunday'    => $data['shift_start']['Sunday']    ?? null,
    'shift_end_sunday'      => $data['shift_end']['Sunday']      ?? null,
    'shift_start_monday'    => $data['shift_start']['Monday']    ?? null,
    'shift_end_monday'      => $data['shift_end']['Monday']      ?? null,
    'shift_start_tuesday'   => $data['shift_start']['Tuesday']   ?? null,
    'shift_end_tuesday'     => $data['shift_end']['Tuesday']     ?? null,
    'shift_start_wednesday' => $data['shift_start']['Wednesday'] ?? null,
    'shift_end_wednesday'   => $data['shift_end']['Wednesday']   ?? null,
    'shift_start_thursday'  => $data['shift_start']['Thursday']  ?? null,
    'shift_end_thursday'    => $data['shift_end']['Thursday']    ?? null,
    'shift_start_friday'    => $data['shift_start']['Friday']    ?? null,
    'shift_end_friday'      => $data['shift_end']['Friday']      ?? null,
    'shift_start_saturday'  => $data['shift_start']['Saturday']  ?? null,
    'shift_end_saturday'    => $data['shift_end']['Saturday']    ?? null,

    // include flags
    'include_sunday'    => $data['include']['Sunday']    ?? 0,
    'include_monday'    => $data['include']['Monday']    ?? 0,
    'include_tuesday'   => $data['include']['Tuesday']   ?? 0,
    'include_wednesday' => $data['include']['Wednesday'] ?? 0,
    'include_thursday'  => $data['include']['Thursday']  ?? 0,
    'include_friday'    => $data['include']['Friday']    ?? 0,
    'include_saturday'  => $data['include']['Saturday']  ?? 0,
]);


    return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
}

    // Delete an existing schedule
    public function destroy(Schedule $schedule)
    {
        // Delete the schedule
        $schedule->delete();

        // Redirect to the index page with a success message
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted.');
    }
}
