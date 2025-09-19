<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payrolls = Payroll::all();
        return view('hr_manager.payroll.list', compact('payrolls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = User::where('role', 3)->get();
        return view('hr_manager.payroll.partials.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'num_of_day_work' => 'required|string|min:0|max:31',
            'bonus' => 'nullable|string|min:0',
            'overtime' => 'nullable|string|min:0',
            'gross_salary' => 'required|string|min:0',
            'cash_advance' => 'nullable|string|min:0',
            'late_hours' => 'nullable|string|min:0',
            'absent_days' => 'nullable|string|min:0',
            'total_deduction' => 'required|string|min:0',
            'netpay' => 'required|string|min:0',
            'payroll_month' => 'required|date_format:Y-m-d',
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
            Payroll::create([
                'user_id' => $request['user_id'],
                'num_of_day_work' => $request['num_of_day_work'],
                'bonus' => $request['bonus'],
                'overtime' => $request['overtime'],
                'gross_salary' => $request['gross_salary'],
                'cash_advance' => $request['cash_advance'],
                'late_hours' => $request['late_hours'],
                'absent_days' => $request['absent_days'],
                'total_deduction' => $request['total_deduction'],
                'netpay' => $request['netpay'],
                'payroll_month' => $request['payroll_month'],
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('A New Payroll is Created Successfully');
            return redirect()->route('hr_manager.payroll');
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
        $employees = User::where('role', 3)->get();
        $payroll = Payroll::find($id);
        if (empty($payroll)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Payroll ID no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.payroll');
        }
        return view('hr_manager.payroll.partials.edit', compact('payroll', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $payroll = Payroll::find($id);
        if (empty($payroll)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Payroll ID no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.payroll');
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'num_of_day_work' => 'required|string|min:0|max:31',
            'bonus' => 'nullable|string|min:0',
            'overtime' => 'nullable|string|min:0',
            'gross_salary' => 'required|string|min:0',
            'cash_advance' => 'nullable|string|min:0',
            'late_hours' => 'nullable|string|min:0',
            'absent_days' => 'nullable|string|min:0',
            'total_deduction' => 'required|string|min:0',
            'netpay' => 'required|string|min:0',
            'payroll_month' => 'required|date_format:Y-m-d',
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
            $payroll->update([
                'user_id' => $request['user_id'],
                'num_of_day_work' => $request['num_of_day_work'],
                'bonus' => $request['bonus'],
                'overtime' => $request['overtime'],
                'gross_salary' => $request['gross_salary'],
                'cash_advance' => $request['cash_advance'],
                'late_hours' => $request['late_hours'],
                'absent_days' => $request['absent_days'],
                'total_deduction' => $request['total_deduction'],
                'netpay' => $request['netpay'],
                'payroll_month' => $request['payroll_month'],
            ]);

            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Payroll ID no: ' . $id . ' is Updated Successfully');
            return redirect()->route('hr_manager.payroll');
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
        $payroll = Payroll::find($id);
        if (empty($payroll)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Payroll ID no. ' . $id . ' not found!');
        }
        try {
            $payroll->delete();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Payroll ID no '. $id .' is Deleted Successfully');
            return redirect()->route('hr_manager.payroll');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
