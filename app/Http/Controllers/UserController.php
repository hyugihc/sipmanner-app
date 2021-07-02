<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;
use App\User;
use App\Provinsi;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;
use Exception;

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

    public function getuser_by_niplama_sso($nip_lama)
    {

        $user = User::where('nip_lama', '3400' . $nip_lama)->first();

        if ($user != null) return new UserResource($user);

        $url_base       = 'https://sso.bps.go.id/auth/';
        $url_token      = $url_base . 'realms/pegawai-bps/protocol/openid-connect/token';
        $url_api        = $url_base . 'realms/pegawai-bps/api-pegawai';
        $client_id      = env('KEYCLOAK_CLIENT_ID');
        $client_secret  = env('KEYCLOAK_CLIENT_SECRET');


        //Mencari pengguna berdasarkan Username
        $query_search   = '/nip' . '/' . '3400' . $nip_lama;

        // //Mencari pengguna berdasarkan Email
        // $query_search   = '/email/{email}';

        // //Mencari pengguna berdasarkan NIP
        // $query_search   = '/nip/{nip}';

        // //Mencari pengguna berdasarkan NIP Baru
        // $query_search   = '/nipbaru/{nipbaru}';

        // //Mencari pengguna berdasarkan Kode Unit Organisasi
        // $query_search   = '/unit/{kodeunitorganisasi}';


        $ch = curl_init($url_token);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ":" . $client_secret);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_token = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);
        $json_token = json_decode($response_token, true);
        $access_token = $json_token['access_token'];

        //==========================================================================
        $ch = curl_init($url_api . $query_search);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch));
        }
        curl_close($ch);

        //echo $response;

        $json = json_decode($response, true);

        if ($json == null) return "pegawai tidak ditemukan";

        // echo "Hasil Pencarian <b>$query_search </b><hr>";

        $result = $json[0];

        //dd($result);
        $newUser = new User;
        $newUser->name = $result['attributes']['attribute-nama'][0];
        $newUser->email = $result['email'];
        $newUser->nip_lama = $result['attributes']['attribute-nip-lama'][0];
        $newUser->nip = $result['attributes']['attribute-nip'][0];
        $newUser->avatar = $result['attributes']['attribute-foto'][0];
        $newUser->kode_org = $result['attributes']['attribute-organisasi'][0];
        $newUser->password = Hash::make('password');
        $newUser->role_id = 6;
        $newUser->save();

        return new UserResource($newUser);
    }
}
