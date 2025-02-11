<?php

namespace App\Http\Controllers\User;

use App\Models\Staff;
use App\Models\WorkTypeLog;
use App\Models\InternDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function edit($id)
    {
        if(!Staff::isStaffEmail($id)) {
            return redirect()->back()->with('error', ' URL is not valid.');
        }

        // get all staff name and id
        $staffList = Staff::select('id', 'full_name')->get();

        // filter current staff
        $staffList = $staffList->filter(function ($value, $key) use ($id) {
            return $value->id != $id;
        });

        $changeLogs = WorkTypeLog::where('staff_id', $id)->orderBy('created_at', 'desc')->get();

        $viewData = [
            'staffList' => $staffList,
            'staff' => Staff::with('internDetails')->findOrFail($id),
            'changeLogs' => $changeLogs,
        ];


        return view('user.staff.edit', $viewData);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        if(!Staff::isStaffEmail($id)) {
            return redirect()->back()->with('error', ' URL is not valid.');
        }

        // General Validation
        $validator = Validator::make($request->all(), [
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email_personal' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:15',
        ]);

        // dd($request->all() , $validator->fails(), $validator->errors());

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'Validation : ' . $validator->errors());
        }

        $data = $request->all();

        // Handle Profile Image Update
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($staff->profile_image) {
                Storage::disk('public')->delete($staff->profile_image);
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $data['profile_image'] = $imagePath;
        }
        // Update Staff Data
        $staff->update($data);

        // Redirect Back with Success Message
        return redirect()->route('staff.edit', $staff->id)->with('success', 'Staff updated successfully.');
    }

    public function show($id)
    {
        if(!Staff::isStaffEmail($id)) {
            return redirect()->back()->with('error', ' URL is not valid.');
        }
        // get all staff name and id
        $staffList = Staff::select('id', 'full_name')->get();

        // filter current staff
        $staffList = $staffList->filter(function ($value, $key) use ($id) {
            return $value->id != $id;
        });

        $staff = Staff::with('internDetails')->findOrFail($id);
        $changeLogs = WorkTypeLog::where('staff_id', $id)->orderBy('created_at', 'desc')->get();

        $viewData = [
            'staffList' => $staffList,
            'staff' => $staff,
            'changeLogs' => $changeLogs,
        ];

        return view('user.staff.show', $viewData);
    }
}
