<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Provinsi;
use App\Role;
use Redirect,Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{


   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  $users = User::latest()->paginate(5);

        
        $users = User::with(['role', 'provinsi'])->latest()->paginate(5);
  
        return view('users.index',compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show(User $user)
    {
        //
        return view('users.show',compact('user'));
    }

    public function create()
    {
        //
        $roles= Role::all();
        $provinsis= Provinsi::all();
        return view('users.create', compact('roles','provinsis'));

    }



    public function store(Request $request)
    {
        //

        $user= new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =Hash::make($request->password);
        $user->nip_lama = $request->nip_lama;

        $user->provinsi_id = $request->provinsi_id;
        $user->role_id =$request->role_id;

        $user->save();

   
        return redirect()->route('users.index')->with('success','user created successfully.');
    }

  
    public function edit(User $user)
    {
        //
        $roles= Role::all();
        $provinsis= Provinsi::all();
        return view('users.edit',compact('user', 'roles', 'provinsis'));
    }

    public function update(Request $request, User $user)
    {
       
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =Hash::make($request->password);
        $user->nip_lama = $request->nip_lama;
        $user->provinsi_id = $request->provinsi_id;
        $user->role_id =$request->role_id;



        $user->save();

   
  
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    public function destroy(User $user)
    {
        //
        $user->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }



   public function getUser($nipLama){

    
      $user = User::select('*')->where('nip_lama', $nipLama)->get(); 
     
     // Fetch all records
     $userData['data'] = $user;

     echo json_encode($userData);
     exit;

  }
}