<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_type';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function configs()
    {
        return $this->hasMany(LeaveConfig::class, 'leave_type_id');
    }

    public function records()
    {
        return $this->hasMany(LeaveRecord::class, 'leave_type_id');
    }

    public function userBalances()
    {
        return $this->hasMany(LeaveUserBalance::class, 'leave_type_id');
    }

}
