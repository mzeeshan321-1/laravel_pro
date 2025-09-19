<?php

namespace App\Http\Controllers\hr_manager;

use App\Models\department;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = department::all();
        return view('hr_manager.departments.list', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr_manager.departments.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255',
            'department_head' => 'required|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . department::class],
            'location' => 'required|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'total_employees' => 'nullable|integer|min:0',
            'contact_info' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Error: ' . implode(', ', $errors));
            return redirect()->back();
        }

        try {
            department::create([
                'department_name' => $request['department_name'],
                'department_head' => $request['department_head'],
                'email' => $request['email'],
                'location' => $request['location'],
                'status' => $request['status'],
                'total_employees' => $request['total_employees'],
                'contact_info' => $request['contact_info'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('A Department is Created Successfully');
            return redirect()->route('hr_manager.departments');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = department::find($id);
        if (empty($department)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Department id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.departments');
        }
        return view('hr_manager.departments.partials.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $department = department::find($id);
        if (empty($department)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Department id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.departments');
        }
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255',
            'department_head' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'location' => 'nullable|string|max:255',
            'status' => 'nullable|in:Active,Inactive',
            'total_employees' => 'nullable|integer|min:0',
            'contact_info' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Error: ' . implode(', ', $errors));
            return redirect()->back();
        }

        try {
            $department->update([
                'department_name' => $request['department_name'],
                'department_head' => $request['department_head'],
                'email' => $request['email'],
                'location' => $request['location'],
                'status' => $request['status'],
                'total_employees' => $request['total_employees'],
                'contact_info' => $request['contact_info'],
            ]);
            $UsersDepartment = User::with('userInfo')->whereHas('userInfo', function ($query) use ($id) {
                $query->where('department_id', $id);
            })->count();
            if (!empty($UsersDepartment) || $UsersDepartment != null) {
                $department->update([
                    'total_employees' => $UsersDepartment,
                ]);
            }
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('A Department id no: '. $id . ' is Updated Successfully');
            return redirect()->route('hr_manager.departments');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $department = department::find($id);
        if (empty($department)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Department id no. ' . $id . ' not found!');
        }
        try {
            $department->delete();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('A Department id no' . $id . 'is Deleted Successfully');
            return redirect()->route('hr_manager.departments');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
