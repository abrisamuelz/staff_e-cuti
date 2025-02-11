<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkTypeLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'work_type',
        'reason',
        'updated_by',
        'start_date',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
