<?php

namespace App\Http\Controllers\hr_manager;

use App\Models\department;
use App\Models\Leave;
use App\Models\position;
use App\Models\country;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('userInfo')
            ->where('role', 3)
            ->orderBy('id', 'asc')
            ->get();

        foreach ($users as $user) {
            // Check if the user is on leave
            $activeLeave = Leave::where('user_id', $user->id)
                ->where('status', 'Approved')
                ->whereDate('start_date', '<=', Carbon::today())
                ->whereDate('end_date', '>=', Carbon::today())
                ->first();
            if ($activeLeave) {
                $user->userInfo->status = 'On Leave';
                $user->userInfo->save();
            }
            // Check if the user has logged in recently (example: within the last 1 days)
            elseif (isset($user->userInfo->last_login) && Carbon::parse($user->userInfo->last_login)->gt(Carbon::now()->subDays(1))) {
                $user->userInfo->status = 'Active';
                $user->userInfo->save();
            } else {
                $user->userInfo()->update([
                    'status' => 'Inactive',
                ]);
            }
        }

        return view(
            'hr_manager.employees.list',
            compact('users')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $positions = position::orderBy('id', 'asc')->get();
        $countries = country::orderBy('name', 'asc')->get();
        $departments = department::orderBy('department_name', 'asc')->get();

        return view(
            'hr_manager.employees.partials.create_employees',
            compact('positions', 'countries', 'departments')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()],
            'joining_date' => 'required|date',
            'status' => 'required|in:Inactive,Active,On Leave',
            'designation' => 'nullable|string|max:255',
            'positions' => 'nullable|exists:positions,id',
            'phone' => 'required|string|max:15',
            'address' => 'nullable|string|max:500',
            'departments' => 'nullable|exists:departments,id',
            'countries' => 'required|exists:countries,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Validation failed: ' . implode(', ', $errors));
            return redirect()->back();
        }

        try {
            DB::transaction(function () use ($request, $validator) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
                if (!file_exists(public_path('images'))) {
                    mkdir(public_path('images'), 0755, true); // Create the directory if it doesn't exist
                }
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $sanitizedOriginalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                    $imageName = $sanitizedOriginalName . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('images');
                    $image->move($destinationPath, $imageName);
                } else {
                    $imageName = null;
                }

                $user->userInfo()->create([
                    'user_id' => $user->id,
                    'joining_date' => $request->joining_date,
                    'status' => $request->status,
                    'designation' => $request->designation,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'department_id' => $request->departments,
                    'country_id' => $request->countries,
                    'position_id' => $request->positions,
                    'image' => $imageName,
                ]);
            });
            $departmentId = $request->input('departments');
            $department = Department::find($departmentId);
            if ($department) {
                $department->update([
                    'total_employees' => $department->userInfos()->count(),
                ]);
            }
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Employee created successfully!');
            return redirect()->route('hr_manager.employees');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $positions = position::orderBy('id', 'asc')->get();
        $countries = country::orderBy('name', 'asc')->get();
        $departments = department::orderBy('department_name', 'asc')->get();
        $user = User::with(['userInfo.department'])->find($id);
        if (empty($user)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Employee id no: ' . $id . ' not found!');
            return redirect()->route('hr_manager.employees');
        }
        return view(
            'hr_manager.employees.partials.edit_employees',
            compact('user', 'positions', 'countries', 'departments')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::with('userInfo.department')->find($id);
        if (empty($user)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error('Employee id no: ' . $id . ' not found!');
            return redirect()->route('hr_manager.employees');
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            // 'password' => ['nullable', Rules\Password::defaults()],
            'joining_date' => 'nullable|date',
            'status' => 'nullable|in:Inactive,Active,On Leave',
            'designation' => 'nullable|string|max:255',
            'positions' => 'nullable|exists:positions,id',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'departments' => 'nullable|exists:departments,id',
            'countries' => 'nullable|exists:countries,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
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
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->name,
                    // 'email' => $request->email,
                    // 'password' => $request->password ? Hash::make($request->password) : $user->password,
                ]);

                if ($request->hasFile('image')) {
                    $userImage = $user->userInfo?->image;
                    $imageName = null;
                    if (!empty($userImage)) {
                        $existingImage = public_path('images/' . $userImage);
                        if (file_exists($existingImage)) {
                            unlink($existingImage);
                        }
                    }
                    $image = $request->file('image');
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $sanitizedOriginalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                    $imageName = $sanitizedOriginalName . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('images');
                    $image->move($destinationPath, $imageName);
                } else {
                    $imageName = $user->userInfo?->image;
                }
                $user->userInfo()->updateOrCreate(
                    ['user_id' => $user->id], // Search by user_id
                    [
                        'user_id' => $user->id,
                        'joining_date' => $request->joining_date,
                        'status' => $request->status,
                        'designation' => $request->designation,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'department_id' => $request->departments,
                        'country_id' => $request->countries,
                        'position_id' => $request->positions,
                        'image' => $imageName,
                    ]
                );
            });
            $oldDepartmentId = $user->userInfo->department_id ?? null;
            $newDepartmentId = $request->departments ?? null;

            if ($oldDepartmentId != $newDepartmentId) {
                if ($oldDepartmentId) {
                    $oldDepartment = department::find($oldDepartmentId);
                    if ($oldDepartment) {
                        $oldDepartment->update([
                            'total_employees' => $oldDepartment->userInfos()->count(),
                        ]);
                    }
                }
                if ($newDepartmentId) {
                    $newDepartment = department::find($newDepartmentId);
                    if ($newDepartment) {
                        $newDepartment->update([
                            'total_employees' => $newDepartment->userInfos()->count(),
                        ]);
                    }
                }
            }
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Employee id no: ' . $id . ' Updated successfully!');
            return redirect()->route('hr_manager.employees');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->route('hr_manager.employees')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::with('userInfo.department')->find($id);
        if (empty($user)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Employee id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.employees');
        }
        try {
            DB::transaction(function () use ($user) {
                if (!empty($user->userInfo->image)) {
                    $imagePath = public_path('images/' . $user->userInfo->image);

                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Delete the image
                    }
                }
                if ($user->userInfo) {
                    $user->userInfo->delete();
                }
                $user->delete();
            });
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Employee id no' . $id . 'Deleted successfully!');
            return redirect()->route('hr_manager.employees');
        } catch (\Exception $e) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->error($e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function ShowEmployeeProfile(string $id)
    {
        $user = User::with(['userInfo.department', 'userInfo.position', 'userInfo.country'])->find($id);
        if (empty($user)) {
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->info('Employee id no. ' . $id . ' not found!');
            return redirect()->route('hr_manager.employees');
        }
        return view('hr_manager.employees.partials.Employee_profile', compact('user'));
    }
}
