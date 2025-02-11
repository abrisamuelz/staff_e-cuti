<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'nric',
        'starting_date',
        'work_type',
        'reason',
        'additional_details',
        'profile_image',
        'email_personal',
        'email_company',
        'phone_number',
    ];

    public function internDetails()
    {
        return $this->hasOne(InternDetail::class, 'staff_id');
    }

    public function workTypeLogs()
    {
        return $this->hasMany(WorkTypeLog::class, 'staff_id');
    }

    // check if current user email is same as staff email ($id)
    public static function isStaffEmail($id)
    {
        return Staff::where('email_personal', auth()->user()->email)
            ->orWhere('email_company', auth()->user()->email)
            ->where('id', $id)
            ->exists();
    }
}
