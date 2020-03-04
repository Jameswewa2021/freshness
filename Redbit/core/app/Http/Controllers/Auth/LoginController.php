<?php

namespace App\Http\Controllers\Auth;

use App\Api;
use App\BasicSetting;
use App\Http\Controllers\Controller;
use App\UserLogin;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

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
    protected $redirectTo = '/backoffice/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $basic = BasicSetting::first();
        if ($basic->google_recap == 1){
            Config::set('captcha.secret', $basic->google_secret_key);
            Config::set('captcha.sitekey', $basic->google_site_key);
        }
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        $data['page_title'] = 'Log In';
        return view('auth.login',$data);
    }

    public function logout(Request $request)
    {
        $logg = User::findOrFail(Auth::user()->id);
        if(Auth::user()->tauth==1){
            User::whereId($logg->id)->update([
                'tfver'=>0
            ]);

        }else{
            User::whereId($logg->id)->update([
                'tfver'=>1
            ]);

        };
        $this->guard()->logout();
        session()->flash('message','Successfully Log Out.');
        session()->flash('type','success');
        return redirect('/login');
    }
    public function authenticated(Request $request, $user)
    {

        if($user->status == 1){
            $this->guard()->logout();
            session()->flash('message','Sorry Your Account is Block Now.!');
            session()->flash('type','danger');
            return redirect('/login');
        }

        $ip = NULL; $deep_detect = TRUE;

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);


        if (isset($xml->geoplugin_countryName)) {

            $country =  $xml->geoplugin_countryName ;
            $city = $xml->geoplugin_city;
            $area = $xml->geoplugin_areaCode;
            $code = $xml->geoplugin_countryCode;
        }

        $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
        $os_platform    =   "Unknown OS Platform";
        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }
        }
        $browser        =   "Unknown Browser";
        $browser_array  =   array(
            '/msie/i'       =>  'Internet Explorer',
            '/firefox/i'    =>  'Firefox',
            '/safari/i'     =>  'Safari',
            '/chrome/i'     =>  'Chrome',
            '/edge/i'       =>  'Edge',
            '/opera/i'      =>  'Opera',
            '/netscape/i'   =>  'Netscape',
            '/maxthon/i'    =>  'Maxthon',
            '/konqueror/i'  =>  'Konqueror',
            '/mobile/i'     =>  'Handheld Browser'
        );
        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser    =   $value;
            }
        }
        $user->login_time = Carbon::now();
        $user->save();
        $ul['user_id'] = $user->id;
        $ul['user_ip'] = $ip;
        $ul['location'] = @$city.(" - ".@$area." - ").@$country .(" - ".@$code." ");
        $ul['details'] = $browser.' on '.$os_platform;
        UserLogin::create($ul);
    }
    public function username()
    {
        return 'username';
    }


    /** Handle Social login request

    *

    * @return response

    */
    public function socialLogin($social)

    {

        $provider = Api::where('provider', $social)->first();

        Config::set('services.' . $provider->provider, [

            'client_id' => $provider->client_id,

            'client_secret' => $provider->client_secret,

            'redirect' => url('/').'/login/' . $provider->provider . '/callback',

        ]);

        return Socialite::driver($social)->redirect();

    }

    /**

     * Obtain the user information from Social Logged in.

     * @param $social

     * @return Response

     */

    public function handleProviderCallback($social)

    {

        try {

            $provider = Api::where('provider', $social)->first();

            Config::set('services.' . $provider->provider, [

                'client_id' => $provider->client_id,

                'client_secret' => $provider->client_secret,

                'redirect' => url('/').'/login/' . $provider->provider . '/callback',

            ]);

            if ($social == 'google') {
                $userSocial = Socialite::driver($social)->stateless()->user();
            } else {
                $userSocial = Socialite::driver($social)->user();
            }

            $user = User::where(['email' => $userSocial->getEmail()])->first();

            if($user){

                Auth::login($user);

                return redirect('/backoffice/dashboard');

            }else{

                \session()->flash('soname', $userSocial->getName());
                \session()->flash('soemail', $userSocial->getEmail());

                return redirect('register');

            }
        } catch (\Exception $e) {
            return redirect('login')->withErrors('Error! Failed To Connect.');
        }

    }
}
