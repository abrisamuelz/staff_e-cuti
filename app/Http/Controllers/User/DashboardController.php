<?php

namespace App\Http\Controllers\User;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct() {}


    public function index()
    {
        $staff = Staff::where('email_personal', auth()->user()->email)
            ->orWhere('email_company', auth()->user()->email)
            ->first();

        if (!$staff) {
            $viewData = [
                'staff' => null,
            ];
            return view('user.dashboard', $viewData);
        }
        // Get oldest starting work log for the staff

        // Convert to Carbon instance if it's not null
        if ($staff->starting_working) {
            $startingDate = Carbon::parse($staff->starting_working);
            $staff->years_of_service = $startingDate->diff(now())->format('%y year, %m month, %d day');

            //format starting working date (d text yyyy)
            $staff->starting_working = $startingDate->format('d M Y');
        } else {
            $staff->years_of_service = null;
        }

        $viewData = [
            'staff' => $staff,
        ];

        return view('user.dashboard', $viewData);
    }
}
