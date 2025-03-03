<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        // Seed leave_type table (master types)
        $leaveTypes = [
            ['name' => 'Annual Leave', 'carry_forward' => 1, 'carry_forward_percentage' => 50, 'carry_forward_max_days' => 5],
            ['name' => 'Medical Leave', 'carry_forward' => 1, 'carry_forward_percentage' => 100, 'carry_forward_max_days' => 15],
            ['name' => 'Compassionate Leave', 'carry_forward' => 0, 'carry_forward_percentage' => 0, 'carry_forward_max_days' => 0],
            ['name' => 'Maternity Leave', 'carry_forward' => 0, 'carry_forward_percentage' => 0, 'carry_forward_max_days' => 0],
            ['name' => 'Paternity Leave', 'carry_forward' => 0, 'carry_forward_percentage' => 0, 'carry_forward_max_days' => 0],
            ['name' => 'Leave for Unsatisfied Work Hours', 'carry_forward' => 0, 'carry_forward_percentage' => 0, 'carry_forward_max_days' => 0],
        ];

        foreach ($leaveTypes as $type) {
            $type['created_at'] = now();
            $type['updated_at'] = now();
            DB::table('leave_type')->insert($type);
        }

        // Get leave_type_id for each type (needed for leave_config)
        $leaveTypeIds = DB::table('leave_type')->pluck('id', 'name');

        // Seed leave_config table (sub-config for each leave type)
        $leaveConfigs = [
            // Annual Leave Configs
            [
                'name' => 'Full Day',
                'leave_type_id' => $leaveTypeIds['Annual Leave'],
                'rate' => 1,
                'notice_period' => 3,
                'max_continuous_days' => 5,
                'attachment_required' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Half Day',
                'leave_type_id' => $leaveTypeIds['Annual Leave'],
                'rate' => 0.5,
                'notice_period' => 1,
                'max_continuous_days' => 2,
                'attachment_required' => 0,
                'active' => 1,
            ],
            [
                'name' => 'Time Off (2 Hours)',
                'leave_type_id' => $leaveTypeIds['Annual Leave'],
                'rate' => 0.25,
                'notice_period' => 1,
                'max_continuous_days' => 0, // Not restricted
                'attachment_required' => 0,
                'active' => 1,
            ],

            // Medical Leave Configs
            [
                'name' => 'Full Day (MC Required)',
                'leave_type_id' => $leaveTypeIds['Medical Leave'],
                'rate' => 1,
                'notice_period' => 0,
                'max_continuous_days' => 5,
                'attachment_required' => 1,
                'active' => 1,
            ],
            [
                'name' => 'Half Day (MC Required)',
                'leave_type_id' => $leaveTypeIds['Medical Leave'],
                'rate' => 0.5,
                'notice_period' => 0,
                'max_continuous_days' => 2,
                'attachment_required' => 1,
                'active' => 1,
            ],

            // Compassionate Leave Config
            // [
            //     'name' => 'Full Day',
            //     'leave_type_id' => $leaveTypeIds['Compassionate Leave'],
            //     'rate' => 1,
            //     'notice_period' => 0,
            //     'max_continuous_days' => 3,
            //     'attachment_required' => 0,
            //     'active' => 1,
            // ],

            // Maternity Leave Config
            [
                'name' => 'Full Maternity Leave',
                'leave_type_id' => $leaveTypeIds['Maternity Leave'],
                'rate' => 1,
                'notice_period' => 30,
                'max_continuous_days' => 90,
                'attachment_required' => 1,
                'active' => 1,
            ],

            // Paternity Leave Config
            [
                'name' => 'Full Paternity Leave',
                'leave_type_id' => $leaveTypeIds['Paternity Leave'],
                'rate' => 1,
                'notice_period' => 7,
                'max_continuous_days' => 7,
                'attachment_required' => 0,
                'active' => 1,
            ],

            // Leave for Unsatisfied Work Hours
            // [
            //     'name' => 'Deduction Leave',
            //     'leave_type_id' => $leaveTypeIds['Leave for Unsatisfied Work Hours'],
            //     'rate' => 1,
            //     'notice_period' => 3,
            //     'max_continuous_days' => 2,
            //     'attachment_required' => 0,
            //     'active' => 1,
            // ],
        ];

        foreach ($leaveConfigs as $config) {
            $config['created_at'] = now();
            $config['updated_at'] = now();
            DB::table('leave_config')->insert($config);
        }
    }
}
