<?php

namespace App\Http\Controllers\Admin;

use App\Models\Staff;
use App\Models\WorkTypeLog;
use App\Models\InternDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {

        $query = Staff::query();
        $search = null;

        // Search by name or NRIC
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('nric', 'like', "%{$search}%");
        }

        // Paginate results
        $staff = $query->with('internDetails')->paginate(10);


        $viewData = [
            'staff' => $staff,
            'search' => $search,
        ];

        return view('admin.staff.index', $viewData);
    }


    public function staffSync(Request $request)
    {

        $clientId = config('services.oauth.client_id');
        $clientSecret = config('services.oauth.client_secret');
        $serverUrl = config('services.oauth.server_url');

        $response = Http::withHeaders([
            'X-Client-ID' => $clientId,
            'X-Client-Secret' => $clientSecret,
        ])->get($serverUrl . '/api/fetch-staff');

        if ($response->successful()) {
            $staffData = $response->json()['data'];

            // Process and store the fetched data in System B's database
            foreach ($staffData as $staff) {
                Staff::updateOrCreate(
                    ['nric' => $staff['nric']], // Unique constraint (use appropriate identifier)
                    [
                        'full_name' => $staff['full_name'],
                        'email_personal' => $staff['email_personal'],
                        'email_company' => $staff['email_company'],
                        'phone_number' => $staff['phone_number'],
                        'work_type' => $staff['work_type'],
                        'starting_date' => $staff['starting_date'],
                    ]
                );
            }
            return response()->json(['message' => 'Staff data synchronized successfully']);
        } else {
            return response()->json(['message' => 'Failed to fetch data'], 500);
        }
    }

    public function show($id)
    {
        // get all staff name and id
        $staffList = Staff::select('id', 'full_name')->get();

        // filter current staff
        $staffList = $staffList->filter(function ($value, $key) use ($id) {
            return $value->id != $id;
        });
        $staff = Staff::with('internDetails')->findOrFail($id);
        $changeLogs = WorkTypeLog::where('staff_id', $id)->orderBy('created_at', 'desc')->get();

        $viewData = [
            'staff' => $staff,
            'staffList' => $staffList,
            'changeLogs' => $changeLogs,
        ];

        return view('admin.staff.show', $viewData);
    }
}
