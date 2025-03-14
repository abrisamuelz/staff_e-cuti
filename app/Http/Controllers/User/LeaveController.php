<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Helpers\ApiHelper;
use App\Models\LeaveConfig;
use App\Models\LeaveRecord;
use Illuminate\Http\Request;
use App\Models\LeaveUserBalance;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $current_date = Carbon::now();
        $currentMonth = $current_date->startOfMonth();

        // Get the selected month from the request or default to the current month
        $selectedMonth = $request->input('month') ? Carbon::parse($request->input('month')) : $currentMonth;

        // Calculate the previous and next month
        $previousMonth = $selectedMonth->copy()->subMonth();
        $nextMonth = $selectedMonth->copy()->addMonth();

        $takenLeave = LeaveRecord::where('staff_id', $user->id)->where('status', 'approved')->sum('duration');

        // get all user leave balance at year also get leave type name id
        $leaveBalances = LeaveUserBalance::where('staff_id', $user->id)
            ->where('year', $current_date->year)
            ->with('leaveType')  // eager load the leaveType relationship
            ->get();

        $approved_leave_records = LeaveRecord::where('staff_id', $user->id)
            ->where('status', 'approved')
            ->whereYear('start_date', $current_date->year)
            ->whereYear('end_date', $current_date->year)
            ->get();

        $pending_leave_records = LeaveRecord::where('staff_id', $user->id)
            ->where('status', 'pending')
            ->whereYear('start_date', $current_date->year)
            ->whereYear('end_date', $current_date->year)
            ->get();

        $holidays_raw = ApiHelper::fetchData('api/fetch-holidays-only/' . $current_date->year);

        $holidays = collect($holidays_raw['data'])->mapWithKeys(function ($holiday) {
            // Use Carbon to format the date as 'Y-m-d' and map it to the holiday name
            return [
                Carbon::parse($holiday['date'])->format('Y-m-d') => $holiday['name'],
            ];
        })->toArray();

        // Limit the holiday name to 10 characters
        $holidayNameLimit = 60;

        $weekendDays = [Carbon::SATURDAY, Carbon::SUNDAY];

        // Fetch leave records for calendar
        $leaveRecords = LeaveRecord::where('staff_id', $user->id)
            ->where('status', 'approved')
            ->get(['start_date', 'end_date']);

        $leaveConfigs = LeaveConfig::all();

        $viewData = [
            'leaveBalance' => $leaveBalances,
            'takenLeave' => $takenLeave,
            'holidays' => $holidays,
            'leaveRecords' => $leaveRecords,
            'leaveConfigs' => $leaveConfigs,
            'weekendDays' => $weekendDays,
            'previousMonth' => $previousMonth,
            'nextMonth' => $nextMonth,
            'selectedMonth' => $selectedMonth,
            'attendances' => null,
            'holidayNameLimit' => $holidayNameLimit,
        ];

        return view('user.leave.index', $viewData);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'leave_type' => 'required|exists:leave_config,id',
            'attachment' => 'nullable|file',
        ]);

        $leave = new LeaveRecord();
        $leave->user_id = Auth::id();
        $leave->leave_type = $request->leave_type;
        $leave->start_date = $request->start_date;
        $leave->end_date = $request->end_date;
        $leave->status = 'pending';
        $leave->save();

        return redirect()->route('user.leave.index')->with('success', 'Leave application submitted');
    }

    public function pending()
    {
        $pendingLeaves = LeaveRecord::where('status', 'pending')->get();
        return view('user.leave.pending', compact('pendingLeaves'));
    }

    public function approve($id)
    {
        $leave = LeaveRecord::findOrFail($id);
        $leave->status = 'approved';
        $leave->save();

        return back()->with('success', 'Leave approved successfully');
    }

    public function reject($id)
    {
        $leave = LeaveRecord::findOrFail($id);
        $leave->status = 'rejected';
        $leave->save();

        return back()->with('error', 'Leave rejected');
    }
}
