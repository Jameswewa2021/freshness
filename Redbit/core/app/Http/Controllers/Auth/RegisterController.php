<?php

namespace App\Http\Controllers\Auth;

use App\BasicSetting;
use App\Bonus;
use App\TraitsFolder\MailTrait;
use App\User;
use App\Http\Controllers\Controller;
use App\UserLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
class RegisterController extends Controller
{
    use MailTrait;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $basic = BasicSetting::first();
        if ($basic->user_reg == 0){
            session()->flash('message','Registration Is Currently Deactivate. Please Try Letter.');
            session()->flash('type','danger');
            return redirect()->route('login');
        }
        $data['page_title'] = "Register";
        $data['reference'] = '0';
        $data['name'] = session('soname', '');
        $data['email'] = session('soemail', '');
        return view('auth.register',$data);
    }
    public function showReferenceLoginForm($id)
    {
       $basic = BasicSetting::first();
        if ($basic->user_reg == 0){
            session()->flash('message','Registration Is Currently Deactivate. Please Try Letter.');
            session()->flash('type','danger');
            return redirect()->route('login');
        }
        $data['page_title'] = "Register";
        $data['reference'] = $id;
        return view('auth.register',$data);
    }
    // function check(Request $request)
    // {
    //  if($request->get('refid'))
    //  {
    //   $refid = $request->get('refid');
    //   $data = DB::table("users")
    //    ->where('refid', $refid)
    //    ->count();
    //   if($data > 0)
    //   {
    //    echo 'not_unique';
    //   }
    //   else
    //   {
    //    echo 'unique';
    //   }
    //  }
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|numeric|min:10|unique:users',
            'username' => 'required|min:5|unique:users|regex:/^\S*$/u',
            'password' => 'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $data['refids'] = $user->select('id')->where('username','=',$data['refid'])->get();
        $pid = $data['refids'][0]->id;
        $ref = $user->select('id')->where('username','=',$data['refid'])->get();
        if($data['position'])
        {
            $res = $user->where('posid','=',$data['refids'][0]->id)->where('position','=',$data['position'])->get();
            while (count($res) != 0)
            {
                $pid = $res[0]->id;
                $res = $user->where('posid','=',$res[0]->id)->where('position','=',$data['position'])->get();

            }

        }
        
        $basic = BasicSetting::first();
        $reference = 0;
        if ($basic->email_verify == 1){
            $email_verify = 0;
        }else{
            $email_verify = 1;
        }

        if ($basic->phone_verify == 1){
            $phone_verify = 0;
        }else{
            $phone_verify = 1;
        }
        $data1 = User::where('id', $pid)->first();
        $mem = User::findOrFail($data1->id);
        $nam = "Congratulations!";
        $text = "Your Network is growing";
        $this->sendMail($mem->email,$nam,'Congratulations',$text);
        
        $email_code = strtoupper(Str::random(6));
        $email_time = Carbon::parse()->addMinutes(5);
        $phone_code = strtoupper(Str::random(6));
        $phone_time = Carbon::parse()->addMinutes(5);
        return User::create([
            'refid' => $data['refids'][0]->id,
            'posid' => $pid,
            'package_id' => 0,
            'position' => $data['position'],
            'name' => $data['name'],
            'email' => $data['email'],
            'country' => $data['country'],
            'gender'=> $data['gender'],
            'docid'=> $data['docid'],
            'DOB'=> $data['DOB'],
            'phone' => $data['phone'],
            'username' => $data['username'],
            'reference' => $data['refid'],
            'is_invest' => 0,
            'shares' => 0,
            'id_image' => 1,
            'network' => 0,
            'total'=> 0,
            'direct' => 0,
            'deposits' => 0,
            'total_points' => 0,
            'under_reference' => $reference,
            'email_verify' => $email_verify,
            'email_code' => $email_code,
            'email_time' => $email_time,
            'phone_verify' => $phone_verify,
            'phone_code' => $phone_code,
            'phone_time' => $phone_time,
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $basic = BasicSetting::first();

        if ($user->reference != 0){
            $refUser = User::findOrFail($user->reference);

            $bal4 = $refUser;
            // $trx = strtoupper(Str::random(20));
            // $ul['user_id'] = $bal4->id;
            // $ul['amount'] = $basic->reference_bonus;
            // $ul['charge'] = null;
            // $ul['amount_type'] = 3;
            // $ul['post_bal'] = $bal4->balance + $basic->reference_bonus;
            // $ul['description'] = $basic->reference_bonus." ".$basic->currency." Bonus For Reference Join. ";
            // $ul['transaction_id'] = $trx;
            // UserLog::create($ul);

            if ($basic->email_notify == 1){
                $text = $user->name." has joined Aurya Global";
                $this->sendMail($bal4->email,$bal4->name,'New Referal',$text);
            }
            if ($basic->phone_notify == 1){
                $text = $user->name." has joined Aurya Global";
                $this->sendSms($bal4->phone,$text);
            }
            // $refUser->balance = $refUser->balance + $basic->reference_bonus;
            // $refUser->save();
        }


        if ($basic->email_verify == 1)
        {
            $email_code = strtoupper(Str::random(6));
            $text = "Your Verification Code Is: <b>$email_code</b>";
            $this->sendMail($user->email,$user->name,'Email verification',$text);
            $user->email_code = $email_code;
            $user->email_time = Carbon::parse()->addMinutes(5);
            $user->save();
        }
        if ($basic->phone_verify == 1)
        {
            $email_code = strtoupper(Str::random(6));
            $txt = "Your Verification Code is: $email_code";
            $to = $user->phone;
            $this->sendSms($to,$txt);
            $user->phone_code = $email_code;
            $user->phone_time = Carbon::parse()->addMinutes(5);
            $user->save();
        }

    }
}
