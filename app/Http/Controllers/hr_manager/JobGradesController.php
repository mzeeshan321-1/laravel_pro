<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\JobGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobGradesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobGrades = JobGrade::all();
        return view('hr_manager.job_grades.list', compact('jobGrades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr_manager.job_grades.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade' => 'required|string|max:255',
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
            JobGrade::create([
                'grade' => $request['grade'],
                'min_salary' => $request['min_salary'],
                'max_salary' => $request['max_salary'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Grade Created Successfully');
            return redirect()->route('hr_manager.job_grades');
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
        $jobGrade = JobGrade::find($id);
        if (empty($jobGrade)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job Grade id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_grades');
        }
        return view('hr_manager.job_grades.partials.edit', compact('jobGrade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobGrade = JobGrade::find($id);
        if (empty($jobGrade)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job Grade id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_grades');
        }

        $validator = Validator::make($request->all(), [
            'grade' => 'required|string|max:255',
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
            $jobGrade->update([
                'grade' => $request['grade'],
                'min_salary' => $request['min_salary'],
                'max_salary' => $request['max_salary'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Grade Updated Successfully');
            return redirect()->route('hr_manager.job_grades');
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
        $jobGrade = JobGrade::find($id);
        if (empty($jobGrade)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job Grade id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_grades');
        }

        try {
            $jobGrade->delete();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job Grade Deleted Successfully');
            return redirect()->route('hr_manager.job_grades');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
