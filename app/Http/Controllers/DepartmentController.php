<?php
namespace App\Http\Controllers;

use App\Models\Department;  // you’ll create this
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    // Display form (queue/index still shows departments list)
    public function create()
    {
        return view('departments.create');
    }

    // Store new department
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Department::create(['name' => $request->name]);
        return redirect()->route('queue.index')
                         ->with('success','Department added.');
    }
}
