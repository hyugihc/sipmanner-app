<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Provinsi;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserController extends Controller
{

    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        $roles = Role::all();
        $provinsis = Provinsi::all();
        return view('users.create', compact('roles', 'provinsis'));
    }


    public function store(StoreUserRequest $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nip_lama = $request->nip_lama;
        $user->provinsi_id = $request->provinsi_id;
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->route('users.index')->with('success', 'user created successfully.');
    }


    public function edit(User $user)
    {
        $roles = Role::all();
        $provinsis = Provinsi::all();
        return view('users.edit', compact('user', 'roles', 'provinsis'));
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|min:4',
            'role_id' => 'required',
            'provinsi_id' => 'required',
        ]);

        $user->name = $request->name;
        $user->password = ($request->password == null) ? true : Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->provinsi_id = $request->provinsi_id;
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }



    // public function getUser($nipLama)
    // {


    //     $user = User::select('*')->where('nip_lama', $nipLama)->get();
    //     //  return new UserResource($user);

    //     //Fetch all records
    //     $userData['data'] = $user;

    //     echo json_encode($userData);
    //     exit;
    // }

    public function getuser_by_niplama($nip_lama)
    {
        $user = User::where('nip_lama', '3400' . $nip_lama)->first();
        return $user != null ? new UserResource($user) : "pegawai tidak ditemukan";
    }
}
