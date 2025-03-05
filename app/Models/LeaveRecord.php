<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRecord extends Model
{
    protected $table = 'leave_record';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function leaveConfig()
    {
        return $this->belongsTo(LeaveConfig::class, 'leave_config_id');
    }
}
