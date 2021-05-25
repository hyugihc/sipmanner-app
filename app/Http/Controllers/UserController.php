<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Provinsi;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Redirect, Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        Auth::user()->cannot('viewAny', User::class)?  abort(403):true;

        $users = User::with(['role', 'provinsi'])->paginate(5);
        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        //
        Auth::user()->cannot('view', $user)?  abort(403):true;

        return view('users.show', compact('user'));
    }

    public function create()
    {
        //
        Auth::user()->cannot('create',  User::class)?  abort(403):true;

        $roles = Role::all();
        $provinsis = Provinsi::all();
        return view('users.create', compact('roles', 'provinsis'));
    }



    public function store(Request $request)
    {
        //
        Auth::user()->cannot('create',  User::class)?  abort(403):true;

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
        //

        Auth::user()->cannot('update',  $user)?  abort(403):true;

        $roles = Role::all();
        $provinsis = Provinsi::all();
        return view('users.edit', compact('user', 'roles', 'provinsis'));
    }

    public function update(Request $request, User $user)
    {

        Auth::user()->cannot('update',  $user)?  abort(403):true;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->nip_lama = $request->nip_lama;
        $user->provinsi_id = $request->provinsi_id;
        $user->role_id = $request->role_id;



        $user->save();



        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        //
        Auth::user()->cannot('delete',  $user)?  abort(403):true;

        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }



    public function getUser($nipLama)
    {


        $user = User::select('*')->where('nip_lama', $nipLama)->get();

        // Fetch all records
        $userData['data'] = $user;

        echo json_encode($userData);
        exit;
    }
}
