<?php

namespace App\Http\Controllers\hr_manager;

use App\Http\Controllers\Controller;
use App\Models\holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HolidaysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = holiday::all();
        return view('hr_manager.holidays.list', compact('holidays'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hr_manager.holidays.partials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:Gazetted,Observance,Restricted,Seasonal,Others'],
            'status' => ['required', 'in:Inactive,Active'],
        ]);

        if ($validator->fails()) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Error: ' . implode(', ', $validator->errors()->all()));
            return redirect()->back();
        }

        try {
            holiday::create([
                'name' => $request['name'],
                'day_of_week' => $request['day_of_week'],
                'date' => $request['date'],
                'description' => $request['description'],
                'type' => $request['type'],
                'status' => $request['status'],
            ]);
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->success('Holiday added successfully!');
            return redirect()->route('hr_manager.holidays');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back()->withInput();
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
        $holiday = holiday::find($id);
        if (empty($holiday)) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Holiday id no. ' . $id . ' not found!');
            return redirect()->back();
        }
        return view('hr_manager.holidays.partials.edit', compact('holiday'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $holiday = holiday::find($id);
        if (empty($holiday)) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Holiday id no. ' . $id . ' not found!');
            return redirect()->back();
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'day_of_week' => ['required', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'in:Gazetted,Observance,Restricted,Seasonal,Others'],
            'status' => ['required', 'in:Inactive,Active'],
         ]);
         if($validator->fails()) {
             flash()->options([
                 'timeout' => 3000,
                 'position' => 'bottom-right',
             ])->error('Error: ' . implode(', ', $validator->errors()->all()));
             return redirect()->back();
         }
         try {
             $holiday->update([
                 'name' => $request['name'],
                 'day_of_week' => $request['day_of_week'],
                 'date' => $request['date'],
                 'description' => $request['description'],
                 'type' => $request['type'],
                 'status' => $request['status'],
             ]);
             flash()->options([
                 'timeout' => 3000,
                 'position' => 'bottom-right',
             ])->success('Holiday id no. '. $id .' Updated successfully!');
             return redirect()->route('hr_manager.holidays');
         } catch (\Exception $e) {
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
        $holiday = holiday::find($id);
        if (empty($holiday)) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Holiday id no. ' . $id . ' not found!');
            return redirect()->back();
        }
        try {
            $holiday->delete();
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error('Holiday id no. ' . $id . ' Deleted Successfully!');
            return redirect()->route('hr_manager.holidays');

        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back();
        }
    }
}
