<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'short_name' => 'required|string|max:100|unique:departments,short_name',
            'name'       => 'required|string|max:255',
        ]);

        Department::create($data);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created.');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'short_name' => 'required|string|max:100|unique:departments,short_name,' . $department->id,
            'name'       => 'required|string|max:255',
        ]);

        $department->update($data);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department deleted.');
    }
}
