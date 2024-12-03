<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = User::where('status', 'Active')->paginate(10);

        return view('admin.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $userId = User::first()->id;
        // $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        $input = $request->except('_token');
        $input['password'] = bcrypt('123456');

        $user = new User();
        $user->firstName = $request->input('firstName');
        $user->lastName = $request->input('lastName');
        $user->userId = substr($request->input('firstName'), 0, 1) . rand(10000, 99999);
        $user->password = $input['password'];
        $user->status = 'Active';
        $user->save();
        // $user->assignRole('Student');

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        // $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {

        $user = User::find($id);
        $user->firstName = $request->input('firstName');
        $user->lastName = $request->input('lastName');
        $user->status = 'Active';
        $user->save();
        // DB::table('model_has_roles')->where('model_id', $id)->delete();

        // $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $user = User::find($id);
        $user->status = 'Deleted';
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }


    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
