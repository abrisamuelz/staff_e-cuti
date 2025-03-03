<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveUserBalance extends Model
{
    use HasFactory;

    protected $table = 'leave_user_balance';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function getBalanceAttribute()
    {
        return $this->annual_limit + $this->carry_forward_leaves - $this->taken;
    }
}
