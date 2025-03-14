<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\LeaveType;
use App\Helpers\ApiHelper;
use App\Models\LeaveRecord;
use App\Models\WorkTypeLog;
use App\Models\InternDetail;
use Illuminate\Http\Request;
use App\Models\LeaveUserBalance;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        $query = Staff::query();
        $search = null;

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('nric', 'like', "%{$search}%");
            });
        }

        $staff = $query->with('internDetails')->paginate(10);

        $currentYear = date('Y');

        // Get leave balances for all listed staff for current year
        $leaveBalances = LeaveUserBalance::whereIn('staff_id', $staff->pluck('id'))
            ->where('year', $currentYear)
            ->get()
            ->groupBy('staff_id');

        $viewData = [
            'staff' => $staff,
            'search' => $search,
            'leaveBalances' => $leaveBalances,
            'currentYear' => $currentYear,
        ];

        return view('admin.staff.index', $viewData);
    }



    public function staffSync(Request $request)
    {

        $staffData = ApiHelper::fetchData('api/fetch-staff');

        if ($staffData != null) {
            // Process and store the fetched data in System B's database
            foreach ($staffData as $staff) {
                $staff_created = Staff::updateOrCreate(
                    ['nric' => $staff['nric']], // Unique constraint (use appropriate identifier)
                    [
                        'full_name' => $staff['full_name'],
                        'email_personal' => $staff['email_personal'],
                        'email_company' => $staff['email_company'],
                        'phone_number' => $staff['phone_number'],
                        'work_type' => $staff['work_type'],
                        'starting_date' => $staff['starting_date'],
                    ]
                );

                // intern details
                if ($staff['intern_details'] != null) {
                    $internDetails = $staff['intern_details'];

                    InternDetail::updateOrCreate(
                        ['staff_id' => $staff_created->id],
                        [
                            'university' => $internDetails['university'],
                            'date_start' => $internDetails['date_start'],
                            'date_end' => $internDetails['date_end'],
                            'supervisor_name' => $internDetails['supervisor_name'],
                            'university_supervisor' => $internDetails['university_supervisor'],
                            'university_supervisor_contact' => $internDetails['university_supervisor_contact'],
                            'other_details' => $internDetails['other_details'],
                        ]
                    );
                }
                Staff::linkStaff($staff_created->id);
            }

            return back()->with('success', 'Staff data has been successfully synced');
        } else {
            return back()->with('error', 'Failed to sync staff data : ' . $response->status());
        }
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
        $leave_types = LeaveType::all();

        $staff_leave_balance = LeaveUserBalance::where('staff_id', $id)->get();

        $viewData = [
            'staff' => $staff,
            'staffList' => $staffList,
            'leave_types' => $leave_types,
            'staff_leave_balance' => $staff_leave_balance,
        ];

        return view('admin.staff.show', $viewData);
    }

    //edit
    public function edit($id)
    {
        // get all staff name and id
        $staffList = Staff::select('id', 'full_name')->get();

        // filter current staff
        $staffList = $staffList->filter(function ($value, $key) use ($id) {
            return $value->id != $id;
        });
        $staff = Staff::with('internDetails')->findOrFail($id);
        $leave_types = LeaveType::all();

        $selectedYear = request()->get('year', date('Y'));

        $staff_leave_balance = LeaveUserBalance::where('staff_id', $id)->get()->groupBy('year');

        // Pass only the **selected year balance** to blade
        $currentYearBalance = $staff_leave_balance[$selectedYear] ?? collect();

        $viewData = [
            'staff' => $staff,
            'staffList' => $staffList,
            'leave_types' => $leave_types,
            'staff_leave_balance' => $staff_leave_balance,
            'current_year' => $selectedYear,
            'current_leave_balance' => $currentYearBalance->keyBy('leave_type_id') // Easier lookup in blade
        ];

        return view('admin.staff.edit', $viewData);
    }

    //update
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $data = json_decode($request->input('data'), true);

        foreach ($data['leave_records'] as $record) {
            if ($record['enabled']) {
                LeaveUserBalance::updateOrCreate(
                    [
                        'year' => $data['year'],
                        'staff_id' => $staff->id,
                        'leave_type_id' => $record['leave_type_id'],
                    ],
                    [
                        'annual_limit' => $record['annual_limit'],
                        'taken' => $record['taken'],
                        'carry_forward_leaves' => $record['carry_forward_leaves'],
                    ]
                );
            } else {
                LeaveUserBalance::where([
                    'year' => $data['year'],
                    'staff_id' => $staff->id,
                    'leave_type_id' => $record['leave_type_id'],
                ])->delete();
            }
        }

        return redirect()->route('admin.staff.show', $id)
            ->with('success', 'Staff leave configuration updated successfully.');
    }
}
