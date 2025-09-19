<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\department;
use App\Models\JobPosition;
use Illuminate\Support\Facades\Validator;
use App\Models\position;
use Illuminate\Http\Request;

class JobPositionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobPosition::all();
        return view('hr_manager.jobs.list', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = department::all();
        $positions = position::all();
        return view('hr_manager.jobs.partials.create', compact('departments', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'min_salary' => 'required|string|min:0',
            'max_salary' => 'required|string|min:0',
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
            JobPosition::create([
                'title' => $request['title'],
                'department_id' => $request['department_id'],
                'position_id' => $request['position_id'],
                'min_salary' => $request['min_salary'],
                'max_salary' => $request['max_salary'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Created Successfully');
            return redirect()->route('hr_manager.jobs');
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
        $departments = department::all();
        $positions = position::all();
        $job = JobPosition::find($id);
        if (empty($job)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.jobs');
        }
        return view('hr_manager.jobs.partials.edit', compact('job', 'departments', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = JobPosition::find($id);
        if (empty($job)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.jobs');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'position_id' => 'required|exists:positions,id',
            'min_salary' => 'required|string|min:0',
            'max_salary' => 'required|string|min:0',
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
            $job->update([
                'title' => $request['title'],
                'department_id' => $request['department_id'],
                'position_id' => $request['position_id'],
                'min_salary' => $request['min_salary'],
                'max_salary' => $request['max_salary'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Updated Successfully');
            return redirect()->route('hr_manager.jobs');
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
        $job = JobPosition::find($id);
        if (empty($job)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.jobs');
        }

        try {
            $job->delete();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Deleted Successfully');
            return redirect()->route('hr_manager.jobs');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
