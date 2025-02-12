<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $query = User::query();
        $search = null;

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        // Paginate results
        // $staff = $query->with('internDetails')->paginate(10);

        // Return view with pagination
        $user = $query->paginate(10);



        $viewData = [
            'staff' => $user,
            'search' => $search,
        ];

        return view('admin.user.index', $viewData);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        // no access if id = auth user id
        if ($user->id == auth()->user()->id) {
            return redirect()->route('admin.user.index')->with('error', 'You cannot edit your own account');
        }

        $viewData = [
            'user' => $user,
        ];

        return view('admin.user.edit', $viewData);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.user.index');
    }
}
