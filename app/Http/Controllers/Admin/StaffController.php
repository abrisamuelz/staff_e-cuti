<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\WorkTypeLog;
use App\Models\InternDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {

        $query = Staff::query();
        $search = null;

        // Search by name or NRIC
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('nric', 'like', "%{$search}%");
        }

        // Paginate results
        $staff = $query->with('internDetails')->paginate(10);


        $viewData = [
            'staff' => $staff,
            'search' => $search,
        ];

        return view('admin.staff.index', $viewData);
    }


    public function create()
    {
        // get all staff name and id
        $staff = Staff::select('id', 'full_name')->get();

        $viewData = [
            'staff' => $staff,
        ];
        return view('admin.staff.create', $viewData);
    }

    public function store(Request $request)
    {

        // General Validation
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'nric' => 'required|string|unique:staff,nric',
            'starting_date' => 'required|date',
            'work_type' => 'required|in:full_time,part_time,contract,intern,terminated',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email_personal' => 'nullable|email|max:255',
            'email_company' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'additional_details' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            
            return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'Validation failed');
        }

        // Additional Validation for Interns
        if ($request->work_type === 'intern') {
            $internValidator = Validator::make($request->all(), [
                'university' => 'required|string|max:255',
                'internship_start_date' => 'required|date',
                'internship_end_date' => 'required|date|after_or_equal:internship_start_date',
                'supervisor_id' => 'nullable|exists:staff,id',
                'university_supervisor' => 'required|string|max:255',
                'university_supervisor_contact' => 'required|string|max:20',
            ]);

            if ($internValidator->fails()) {
                return redirect()->back()->withErrors($internValidator->errors())->withInput()->with('error', 'Validation failed');
            }
        }

        // Prepare data excluding file uploads
        $data = $request->except(['profile_image']);

        // Handle Profile Image Upload
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }

        // Create Staff Record
        $staff = Staff::create($data);
        Log::info('Staff Created Successfully:', $staff->toArray());

        // If Intern, Create Intern Details
        if ($request->work_type === 'intern') {
            InternDetail::create([
                'staff_id' => $staff->id,
                'university' => $request->university,
                'date_start' => $request->internship_start_date,
                'date_end' => $request->internship_end_date,
                'supervisor_id' => $request->supervisor_id,
                'university_supervisor' => $request->university_supervisor,
                'university_supervisor_contact' => $request->university_supervisor_contact,
                'other_details' => $request->additional_details,
            ]);
            Log::info('Intern Details Created for Staff ID: ' . $staff->id);
        }

        // Log Changes to Work Type
        WorkTypeLog::create([
            'staff_id' => $staff->id,
            'work_type' => $request->work_type,
            'reason' => $request->reason ?? 'Starting as ' . $request->work_type,
            'updated_by' => Auth::id(),
            'start_date' => $request->starting_date,
        ]);
        Log::info('Work Type Log Created');

        // If work type is terminated, update the staff's reason for termination
        if ($request->work_type === 'terminated') {
            $staff->update(['reason' => $request->reason]);
            Log::info('Termination Reason Updated for Staff ID: ' . $staff->id);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff created successfully.');
    }


    public function edit($id)
    {
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


        return view('admin.staff.edit', $viewData);
    }

    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $staff_old_worktype = $staff->work_type;

        // General Validation
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'nric' => 'required|string',
            'starting_date' => 'required|date',
            'work_type' => 'required|in:full_time,part_time,contract,intern,terminated',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'email_personal' => 'nullable|email|max:255',
            'email_company' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:15',
            'other_details' => 'nullable|string',
        ]);

        // dd($request->all() , $validator->fails(), $validator->errors());

        // If validation fails, return with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput()->with('error', 'Validation : ' . $validator->errors());
        }

        // Additional Validation for Intern
        if ($request->work_type === 'intern') {
            $internValidator = Validator::make($request->all(), [
                'university' => 'required|string|max:255',
                'date_start' => 'required|date',
                'date_end' => 'required|date|after_or_equal:date_start',
                'supervisor_id' => 'nullable|exists:staff,id',
                'university_supervisor' => 'required|string|max:255',
                'university_supervisor_contact' => 'required|string|max:20',
                'other_details' => 'nullable|string',
            ]);

            // If intern validation fails, return with errors
            if ($internValidator->fails()) {
                return redirect()->back()->withErrors($internValidator->errors())->withInput()->with('error', 'Validation : ' . $internValidator->errors());
            }
        }

        $data = $request->all();
        $data['additional_details'] = $request->input('other_details', null);

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

        // Log Changes to Work Type
        if ($staff->wasChanged('work_type')) {
            WorkTypeLog::create([
                'staff_id' => $staff->id,
                'work_type' => $request->work_type,
                'reason' => $request->reason ?? 'Updated from "' . $staff_old_worktype . '" to "' . $request->work_type . '"',
                'updated_by' => Auth::id(),
                'start_date' => $request->starting_date,
            ]);

            // If work type is terminated, update the staff's reason for termination
            if ($request->work_type === 'terminated') {
                $staff->update(['reason' => $request->reason]);
            }
        }



        // Handle Intern Details
        if ($request->work_type === 'intern') {
            $request->validate([
                'university' => 'required|string|max:255',
                'date_start' => 'required|date',
                'date_end' => 'required|date|after_or_equal:date_start',
                'supervisor_id' => 'nullable|exists:staff,id',
                'university_supervisor' => 'required|string|max:255',
                'university_supervisor_contact' => 'required|string|max:20',
                'other_details' => 'nullable|string',
            ]);

            InternDetail::updateOrCreate(
                ['staff_id' => $staff->id],
                [
                    'university' => $request->university,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                    'supervisor_id' => $request->supervisor_id,
                    'university_supervisor' => $request->university_supervisor,
                    'university_supervisor_contact' => $request->university_supervisor_contact,
                    'other_details' => $request->input('other_details', null),
                ]
            );
        } else {
            // If not an intern, remove any existing intern details
            InternDetail::where('staff_id', $staff->id)->delete();
        }

        // Redirect Back with Success Message
        return redirect()->route('admin.staff.edit', $staff->id)->with('success', 'Staff updated successfully.');
    }

    public function show($id)
    {
        // get all staff name and id
        $staffList = Staff::select('id', 'full_name')->get();

        // filter current staff
        $staffList = $staffList->filter(function ($value, $key) use ($id) {
            return $value->id != $id;
        });
        $staff = Staff::with('internDetails')->findOrFail($id);
        $changeLogs = WorkTypeLog::where('staff_id', $id)->orderBy('created_at', 'desc')->get();

        $viewData = [
            'staff' => $staff,
            'staffList' => $staffList,
            'changeLogs' => $changeLogs,
        ];

        return view('admin.staff.show', $viewData);
    }

    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted (soft delete) successfully.');
    }

    public function trashed()
    {
        $staff = Staff::onlyTrashed()->paginate(10);
        return view('admin.staff.trashed', compact('staff'));
    }

    public function restore($id)
    {
        $staff = Staff::onlyTrashed()->findOrFail($id);
        $staff->restore();

        return redirect()->route('admin.staff.trashed')->with('success', 'Staff restored successfully.');
    }
}
