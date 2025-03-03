<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveConfig extends Model
{
    use HasFactory;

    protected $table = 'leave_config';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}
