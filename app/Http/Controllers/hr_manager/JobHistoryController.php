<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\department;
use App\Models\JobGrade;
use App\Models\JobHistory;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class JobHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobHistories = JobHistory::all();
        return view('hr_manager.job_history.list', compact('jobHistories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', '3')->get();
        $jobPositions = JobPosition::all();
        $departments = department::all(); 
        $jobGrades = JobGrade::all();   
        return view('hr_manager.job_history.partials.create', compact('users', 'jobPositions', 'departments', 'jobGrades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'job_position_id' => 'required|exists:job_positions,id',
            'job_grade_id' => 'required|exists:job_grades,id',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
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
            $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            JobHistory::create([
                'user_id' => $request['user_id'],
                'job_position_id' => $request['job_position_id'],
                'job_grade_id' => $request['job_grade_id'],
                'department_id' => $request['department_id'],
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job History Created Successfully');
            return redirect()->route('hr_manager.job_history');
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
        $users = User::where('role', '3')->get();
        $jobPositions = JobPosition::all();
        $departments = department::all(); 
        $jobGrades = JobGrade::all();
        $job_history = JobHistory::find($id);
        if (empty($job_history)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job History id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_history');
        }
        return view('hr_manager.job_history.partials.edit', compact('job_history', 'users', 'jobPositions', 'departments', 'jobGrades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job_history = JobHistory::find($id);
        if (empty($job_history)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job History id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_history');
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'job_position_id' => 'required|exists:job_positions,id',
            'job_grade_id' => 'required|exists:job_grades,id',
            'department_id' => 'required|exists:departments,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
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
            $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $job_history->update([
                'user_id' => $request['user_id'],
                'job_position_id' => $request['job_position_id'],
                'job_grade_id' => $request['job_grade_id'],
                'department_id' => $request['department_id'],
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job History Updated Successfully');
            return redirect()->route('hr_manager.job_history');
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
        $job_history = JobHistory::find($id);
        if (empty($job_history)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Job History id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.job_history');
        }

        try {
            $job_history->delete();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Job History Deleted Successfully');
            return redirect()->route('hr_manager.job_history');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
