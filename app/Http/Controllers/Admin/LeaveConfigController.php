<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveConfig;
use App\Models\LeaveType;

class LeaveConfigController extends Controller
{
    public function create()
    {
        $leaveTypes = LeaveType::all();

        $viewData = ['leaveTypes' => $leaveTypes];

        return view('admin.leave_management.configs.create', $viewData);
    }

    public function store()
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'leave_type_id' => 'required|exists:leave_type,id',
            'rate' => 'required|numeric|min:0',
            'notice_period' => 'numeric|min:0',
            'max_continuous_days' => 'numeric|min:0',
            'attachment_required' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        LeaveConfig::create(request()->all());

        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Config Created');
    }

    public function show($id)
    {
        $leaveConfig = LeaveConfig::with('leaveType')->findOrFail($id);

        $viewData = ['leaveConfig' => $leaveConfig];

        return view('admin.leave_management.configs.show', $viewData);
    }

    public function edit($id)
    {
        $leaveConfig = LeaveConfig::findOrFail($id);
        $leaveTypes = LeaveType::all();

        $viewData = [
            'leaveConfig' => $leaveConfig,
            'leaveTypes' => $leaveTypes,
        ];

        return view('admin.leave_management.configs.edit', $viewData);
    }

    public function update($id)
    {
        request()->validate([
            'name' => 'required|string|max:255',
            'leave_type_id' => 'required|exists:leave_type,id',
            'rate' => 'required|numeric|min:0',
            'notice_period' => 'numeric|min:0',
            'max_continuous_days' => 'numeric|min:0',
            'attachment_required' => 'required|boolean',
            'active' => 'required|boolean',
        ]);

        $leaveConfig = LeaveConfig::findOrFail($id);
        $leaveConfig->update(request()->all());

        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Config Updated');
    }

    public function destroy($id)
    {
        LeaveConfig::findOrFail($id)->delete();
        return redirect()->route('admin.leave-management.index')->with('success', 'Leave Config Deleted');
    }
}
