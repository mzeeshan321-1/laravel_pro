<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\country;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $countries = country::all();
        return view('employee.profile.edit', [
            'user' => $request->user(),
            'countries' => $countries,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): JsonResponse
    {
        $id = Auth::user()->id;
        $user = User::where(['id' => $id, 'role' => 3])->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => ['error' => 'User not found or unauthorized']
            ]);
        }

        $action = $request->remove_image; // Get the action from the request
        if ($action == "1") {
            $imageName = $user->userInfo->image; // Default to existing image
            if (!empty($imageName)) {
                $existingImage = public_path('images/' . $imageName);
                if (file_exists($existingImage)) {
                    unlink($existingImage);
                }
                $imageName = null;
            }

            $user->userInfo()->update(['image' => $imageName]);
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->success('Profile image removed successfully!');
            return response()->json([
                'status' => true,
                'message' => 'Profile image removed successfully!'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'joining_date' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'country' => 'nullable|exists:countries,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->all()
            ]);
        }
        try {
            DB::transaction(function () use ($request, $user) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);

                $imageName = $user->userInfo->image; // Default to existing image
                if ($request->hasFile('image')) {
                    // Upload new image if file is provided
                    if (!empty($imageName)) {
                        $existingImage = public_path('images/' . $imageName);
                        if (file_exists($existingImage)) {
                            unlink($existingImage);
                        }
                    }
                    $image = $request->file('image');
                    $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $sanitizedOriginalName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $originalName);
                    $imageName = $user->id . '_' . $sanitizedOriginalName . '_' . time() . '.' . $image->getClientOriginalExtension();
                    $destinationPath = public_path('images');
                    $image->move($destinationPath, $imageName);
                }

                $user->userInfo()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'user_id' => $user->id,
                        'joining_date' => $request->joining_date,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'country_id' => $request->country,
                        'image' => $imageName,
                    ]
                );
            });
            flash()->options([
                'timeout' => 3000,
                'position' => 'bottom-right',
            ])->success('Profile Edited Successfully!');
            return response()->json([
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => ['error' => $e->getMessage()]
            ]);
        }
    }

    public function ChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'CurrentPassword' => 'required',
            'NewPassword' => 'required|min:8',
            'Re-newPassword' => 'required|same:NewPassword'
        ]);
        $id = Auth::user()->id;
        $Employee = User::where(['id' => $id, 'role' => 3])->first();
        if (!Hash::check($request->CurrentPassword, $Employee->password)) {
            return response()->json([
                'status' => false,
                'error' => ['CurrentPassword' => 'Current Password is Incorrect, Please try again.']
            ]);
        }
        if ($validator->passes()) {
            User::where('id', $Employee->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);
            flash()->options([
                'timeout' => 3000, // 3 seconds
                'position' => 'bottom-right',
            ])->success('Password Updated Successfully!.');
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ]);
        }
    }
}