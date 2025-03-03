<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use App\Models\LeaveConfig;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::all();
        $leaveConfigs = LeaveConfig::with('leaveType')->get();

        $viewData = [
            'leaveTypes' => $leaveTypes,
            'leaveConfigs' => $leaveConfigs,
        ];

        return view('admin.leave_management.index', $viewData);
    }


    public function create()
    {
        return view('admin.leave_management.types.create');
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'carry_forward' => 'required|boolean',
            'carry_forward_percentage' => 'numeric|min:0|max:100',
            'carry_forward_max_days' => 'numeric|min:0',
        ]);

        LeaveType::create(request()->all());

        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Type Created');
    }

    public function show($id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $viewData = ['leaveType' => $leaveType];

        return view('admin.leave_management.types.show', $viewData);
    }

    public function edit($id)
    {
        $leaveType = LeaveType::findOrFail($id);

        $viewData = ['leaveType' => $leaveType];

        return view('admin.leave_management.types.edit', $viewData);
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'carry_forward' => 'required|boolean',
            'carry_forward_percentage' => 'numeric|min:0|max:100',
            'carry_forward_max_days' => 'numeric|min:0',
        ]);

        $leaveType = LeaveType::findOrFail($id);
        $leaveType->update(request()->all());

        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Type Updated');
    }

    public function destroy($id)
    {
        LeaveType::findOrFail($id)->delete();
        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Type Deleted');
    }
}
