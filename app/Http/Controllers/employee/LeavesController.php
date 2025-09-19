<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveTypes = LeaveType::with([
            'leaves',
            'leaveBalances' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->get();
        $leaves = Leave::with('leaveType')->where('user_id', auth()->user()->id)->get();
        return view('employee.leaves.list', compact('leaveTypes', 'leaves'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $leaveTypes = LeaveType::with([
            'leaves',
            'leaveBalances' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->get();
        $leave_types = LeaveType::all();
        $leave = User::with('leaves')->get();
        return view('employee.leaves.partials.create', compact('leave_types', 'leave', 'leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'total_days' => 'required|numeric|min:1',
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Error: ' . implode(', ', $validator->errors()->all()));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $totalDays = $request->total_days;
            $leaveType = LeaveType::findOrFail($request->leave_type_id);
            $user = auth()->id();

            // Check if leave period overlaps with existing Approved leaves
            $overlappingApprovedLeave = Leave::where('user_id', $user)
                ->where('leave_type_id', $request->leave_type_id)
                ->where('status', 'Approved')
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $end_date);
                        });
                })->first();

            if ($overlappingApprovedLeave) {
                DB::rollBack();
                flash()->options([
                    'timeout' => 3000,
                    'position' => 'bottom-right',
                ])->error('Conflicting leave request found. Please select a different date range.');
                return redirect()->back();
            }

            // Fetch Leave Balance
            $leaveBalance = LeaveBalance::where('user_id', $user)
                ->where('leave_type_id', $request->leave_type_id)
                ->first();

            if ($leaveBalance != null) {
                if ($leaveBalance->remaining_days == 0 && $leaveBalance->used_days == $leaveType->max_days) {
                    DB::rollBack();
                    flash()->options([
                        'timeout' => 3000,
                        'position' => 'bottom-right',
                    ])->error('You have exhausted all "' . $leaveType->name . '" leave days.');
                    return redirect()->back();
                } elseif ($leaveBalance->remaining_days < $totalDays) {
                    DB::rollBack();
                    flash()->options([
                        'timeout' => 3000,
                        'position' => 'bottom-right',
                    ])->error('You do not have enough ' . $leaveType->name . ' days remaining.');
                    return redirect()->back();
                }

                // Deduct leave days
                $leaveBalance->remaining_days -= $totalDays;
                $leaveBalance->used_days += $totalDays;
                $leaveBalance->save();
            } else {
                $leaveBalance = LeaveBalance::create([
                    'user_id' => $user,
                    'leave_type_id' => $request->leave_type_id,
                    'remaining_days' => $leaveType->max_days - $totalDays,
                    'used_days' => $totalDays,
                ]);
            }

            // Check for existing pending leave request
            $existingPendingLeave = Leave::where('user_id', $user)
                ->where('leave_type_id', $request->leave_type_id)
                ->where('status', 'Pending')
                ->exists();

            if ($existingPendingLeave) {
                DB::rollBack();
                flash()->options([
                    'timeout' => 3000,
                    'position' => 'bottom-right',
                ])->error('You already have a pending leave request for this leave type.');
                return redirect()->back();
            }

            if ($totalDays > $leaveType->max_days) {
                DB::rollBack();
                flash()->options([
                    'timeout' => 3000,
                    'position' => 'bottom-right',
                ])->error('You cannot apply for more than ' . $leaveType->max_days . ' days for ' . $leaveType->name . ' leave type.');
                return redirect()->back();
            }

            // Create Leave Request
            Leave::create([
                'user_id' => $user,
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
            ]);

            DB::commit();

            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->success('Leave request sent successfully!');
            return redirect()->route('employee.leaves');

        } catch (\Exception $e) {
            DB::rollBack();

            flash()->options([
                'timeout' => 3000,
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
        $leaveTypes = LeaveType::with([
            'leaves',
            'leaveBalances' => function ($query) {
                $query->where('user_id', auth()->id());
            }
        ])->get();
        $leave_types = LeaveType::all();
        $leave = Leave::find($id);
        if (empty($leave)) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Leave id no. ' . $id . ' not found!');
            return redirect()->back();
        }
        return view('employee.leaves.partials.edit', compact('leave', 'leaveTypes', 'leave_types'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $leave = Leave::find($id);
        if (!$leave) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Leave ID ' . $id . ' not found!');
            return redirect()->back();
        }

        $validator = Validator::make($request->all(), [
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date_format:d-m-Y',
            'end_date' => 'required|date_format:d-m-Y|after_or_equal:start_date',
            'total_days' => 'required|numeric|min:1',
            'reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Error: ' . implode(', ', $validator->errors()->all()));
            return redirect()->back();
        }

        DB::beginTransaction();

        try {
            $start_date = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
            $end_date = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
            $totalDays = $request->total_days;
            $leaveType = LeaveType::findOrFail($request->leave_type_id);
            $user = auth()->id();

            // Check if leave period overlaps with existing Approved leaves
            $overlappingApprovedLeave = Leave::where('user_id', $user)
                ->where('leave_type_id', $request->leave_type_id)
                ->where('status', 'Approved')
                ->where(function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('start_date', [$start_date, $end_date])
                        ->orWhereBetween('end_date', [$start_date, $end_date])
                        ->orWhere(function ($query) use ($start_date, $end_date) {
                            $query->where('start_date', '<=', $start_date)
                                ->where('end_date', '>=', $end_date);
                        });
                })
                ->first();
                
            if ($overlappingApprovedLeave) {
                DB::rollBack();
                flash()->options([
                    'timeout' => 3000,
                    'position' => 'bottom-right',
                ])->error('Conflicting leave request found. Please select a different date range.');
                return redirect()->back();
            }

            // Fetch Current Leave Balance
            $leaveBalance = LeaveBalance::where('user_id', $user)
                ->where('leave_type_id', $leave->leave_type_id)
                ->first();

            // Restore Balance if previous leave was Rejected
            if ($leaveBalance) {
                $leaveBalance->remaining_days += $leave->total_days;
                $leaveBalance->used_days -= $leave->total_days;

                // Delete record if all used days are restored
                if ($leaveBalance->used_days <= 0) {
                    $leaveBalance->delete();
                } else {
                    $leaveBalance->save();
                }
            }

            // 🔹 Fetch new Leave Balance
            $newLeaveBalance = LeaveBalance::where('user_id', $user)
                ->where('leave_type_id', $request->leave_type_id)
                ->first();

            if ($newLeaveBalance) {
                if ($newLeaveBalance->remaining_days == 0 && $newLeaveBalance->used_days == $leaveType->max_days) {
                    DB::rollBack();
                    flash()->options([
                        'timeout' => 3000,
                        'position' => 'bottom-right',
                    ])->error('You have exhausted all "' . $leaveType->name . '" leave days.');
                    return redirect()->back();
                } elseif ($newLeaveBalance->remaining_days < $totalDays) {
                    DB::rollBack();
                    flash()->options([
                        'timeout' => 3000,
                        'position' => 'bottom-right',
                    ])->error('You do not have enough ' . $leaveType->name . ' days remaining.');
                    return redirect()->back();
                }

                // Deduct new leave days
                $newLeaveBalance->remaining_days -= $totalDays;
                $newLeaveBalance->used_days += $totalDays;
                $newLeaveBalance->save();
            } else {
                $newLeaveBalance = LeaveBalance::create([
                    'user_id' => $user,
                    'leave_type_id' => $request->leave_type_id,
                    'remaining_days' => $leaveType->max_days - $totalDays,
                    'used_days' => $totalDays,
                ]);
            }

            if ($totalDays > $leaveType->max_days) {
                DB::rollBack();
                flash()->options([
                    'timeout' => 3000,
                    'position' => 'bottom-right',
                ])->error('You cannot apply for more than ' . $leaveType->max_days . ' days for ' . $leaveType->name . ' leave type.');
                return redirect()->back();
            }

            // 🔹 Update Leave Request
            $leave->update([
                'user_id' => $user,
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_days' => $totalDays,
                'reason' => $request->reason,
            ]);

            DB::commit();

            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->success('Leave ID ' . $id . ' updated successfully!');
            return redirect()->route('employee.leaves');

        } catch (\Exception $e) {
            DB::rollBack();
            flash()->options([
                'timeout' => 3000,
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
        $leave = Leave::find($id);
        if (empty($leave)) {
            flash()->options(['timeout' => 3000, 'position' => 'bottom-right'])
                ->error('Leave id no. ' . $id . ' not found!');
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            // Restore previous leave balance before deleting leave request
            $leaveBalance = LeaveBalance::where('user_id', $leave->user_id)
                ->where('leave_type_id', $leave->leave_type_id)
                ->first();
            // Restore Balance if previous leave was Rejected
            if ($leaveBalance) {
                $leaveBalance->remaining_days += $leave->total_days;
                $leaveBalance->used_days -= $leave->total_days;

                // Delete record if all used days are restored
                if ($leaveBalance->used_days <= 0) {
                    $leaveBalance->delete();
                } else {
                    $leaveBalance->save();
                }
            }

            $leave->delete();
            DB::commit();
            flash()->options(['timeout' => 3000, 'position' => 'bottom-right'])
                ->success('Leave id no. ' . $id . ' deleted successfully!');
            return redirect()->route('employee.leaves');

        } catch (\Throwable $e) {
            DB::rollBack();
            flash()->options(['timeout' => 3000, 'position' => 'bottom-right'])
                ->error($e->getMessage());
            return redirect()->back();
        }
    }
}