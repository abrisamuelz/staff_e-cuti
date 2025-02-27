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
        'oauth_group_id',
    ];

    public function internDetails()
    {
        return $this->hasOne(InternDetail::class, 'staff_id');
    }

    // check if current user email is same as staff email ($id)
    public static function isStaffEmail(int $staff_id = null, $user = null): int
    {
        $user = $user ?? auth()->user();
        if (!$user) {
            return 0; // Not authenticated
        }

        $staff = Staff::where('email_personal', $user->email)
            ->orWhere('email_company', $user->email)
            ->orWhere('id', $staff_id)
            ->first();

        if (!$staff) {
            return 0; // Staff not found
        }

        // Update staff user_id if null
        if ($staff->user_id === null) {
            $staff->user_id = $user->id;
            $staff->linked_at = now();
            $staff->save();
        }

        // Check user_id match
        return $staff->user_id === $user->id ? 1 : 2;
    }

    // connect to user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
