<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use JKD\SSO\Client\Provider\Keycloak;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    public function showLoginForm(Request $request)
    {
        $provider = new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => env('KEYCLOAK_CLIENT_ID'),
            'clientSecret'          => env('KEYCLOAK_CLIENT_SECRET'),
            'redirectUri'           => env('KEYCLOAK_REDIRECT_URI'),
        ]);


        if (!isset($_GET['code'])) {
            // Untuk mendapatkan authorization code
            $authUrl = $provider->getAuthorizationUrl();
            $request->session()->put('oauth2state', $provider->getState());
            header('Location: ' . $authUrl);
            exit;
            // Mengecek state yang disimpan saat ini untuk memitigasi serangan CSRF
        } elseif (empty($_GET['state'])) {
            $request->session()->forget('oauth2state');
            exit('Invalid state');
        } else {
            try {
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
            } catch (Exception $e) {
                exit('Gagal mendapatkan akses token : ' . $e->getMessage());
            }
            // Setelah mendapatkan token, ambil data email pengguna untuk login ke aplikasi
            try {

                $user = $provider->getResourceOwner($token);

                // echo "Nama : ".$user->getName();
                // echo "E-Mail : ". $user->getEmail();
                // echo "Username : ". $user->getUsername();
                // echo "NIP : ". $user->getNip();
                // echo "NIP Baru : ". $user->getNipBaru();
                // echo "Kode Organisasi : ". $user->getKodeOrganisasi();
                // echo "Kode Provinsi : ". $user->getKodeProvinsi();
                // echo "Kode Kabupaten : ". $user->getKodeKabupaten();
                // echo "Alamat Kantor : ". $user->getAlamatKantor();
                // echo "Provinsi : ". $user->getProvinsi();
                // echo "Kabupaten : ". $user->getKabupaten();
                // echo "Golongan : ". $user->getGolongan();
                // echo "Jabatan : ". $user->getJabatan();
                // echo "Foto : ". $user->getUrlFoto();
                // echo "Eselon : ". $user->getEselon();


                $email = $user->getEmail();
                $id = User::where('email', $email)->first();
                if (!empty($id)) {
                    $id = $id->id;
                } else {
                    // $newUser = User::create([
                    //     'name' => $user->getName(),
                    //     'email' => $user->getEmail(),
                    // ]);
                    // $id = $newUser->id;
                    $email = $user->getEmail();
                    $name = $user->getName();
                    $url_logout = $provider->getLogoutUrl();
                    return view('403', compact('name', 'email'));
                }

                // Login dengan menggunakan id pengguna dari record di database aplikasi
                if (Auth::loginUsingId($id)) {
                    $loggedinUser = User::find($id);
                    $loggedinUser->avatar = $user->getUrlFoto();
                    $loggedinUser->save();
                    $loggedinUser->setSetting('tahun', '2021');
                    return redirect()->route('dashboard');
                } else {
                    return redirect('/');
                }
            } catch (Exception $e) {
                exit('Gagal login: ' . $e->getMessage());
            }
        }
    }

    public function logout(Request $request)
    {
        $provider = new Keycloak([
            'authServerUrl'         => 'https://sso.bps.go.id',
            'realm'                 => 'pegawai-bps',
            'clientId'              => env('KEYCLOAK_CLIENT_ID'),
            'clientSecret'          => env('KEYCLOAK_CLIENT_SECRET'),
            'redirectUri'           => env('KEYCLOAK_REDIRECT_URI'),
        ]);

        $url_logout = $provider->getLogoutUrl();

        // Auth::logoutUsingId(Auth::user()->id);

        //  $this->guard()->logout();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($url_logout);
        //return redirect()->route('login');

        // if ($response = $this->loggedOut($request)) {
        //     return $response;
        // }

        // return $request->wantsJson()
        //     ? new JsonResponse([], 204)
        //     : redirect('/');
    }
}
