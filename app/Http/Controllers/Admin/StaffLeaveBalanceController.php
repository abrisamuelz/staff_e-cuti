<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffLeaveBalance;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffLeaveBalanceController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y')); // Default to current year
        $balances = StaffLeaveBalance::where('year', $year)->with('staff')->get();

        return view('admin.staff_leave.index', compact('balances', 'year'));
    }

    public function create()
    {
        $staffs = Staff::all();
        return view('admin.staff_leave.create', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'leave_type' => 'required|string|max:255',
            'total_leaves' => 'required|integer|min:0',
            'carry_forward_leaves' => 'nullable|integer|min:0',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        StaffLeaveBalance::create($request->all());

        return redirect()->route('admin.staff-leaves.index')
            ->with('success', 'Leave balance added successfully.');
    }

    public function show($id)
    {
        $balance = StaffLeaveBalance::with('staff')->findOrFail($id);
        return view('admin.staff_leave.show', compact('balance'));
    }

    public function edit($id)
    {
        $balance = StaffLeaveBalance::with('staff')->findOrFail($id);
        return view('admin.staff_leave.edit', compact('balance'));
    }

    public function update(Request $request, $id)
    {
        $balance = StaffLeaveBalance::findOrFail($id);

        $request->validate([
            'total_leaves' => 'required|integer|min:0',
            'used_leaves' => 'required|integer|min:0',
            'carry_forward_leaves' => 'nullable|integer|min:0',
        ]);

        $balance->update($request->only(['total_leaves', 'used_leaves', 'carry_forward_leaves']));

        return redirect()->route('admin.staff-leaves.index')
            ->with('success', 'Leave balance updated successfully.');
    }

    public function destroy($id)
    {
        StaffLeaveBalance::findOrFail($id)->delete();

        return redirect()->route('admin.staff-leaves.index')
            ->with('success', 'Leave balance deleted successfully.');
    }
}
