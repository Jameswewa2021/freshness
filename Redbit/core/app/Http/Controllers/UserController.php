<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\Bonus;
use App\BinaryLog;
use App\Category;
use App\Compound;
use App\Deposit;
use App\DepositImage;
use App\DetailLogs;
use App\Investment;
use App\InvestmentPlans;
use App\Levels;
use App\Lib\HashF;
use App\Packages;
use App\PackagesLog;
use App\PaymentLog;
use App\PaymentMethod;
use App\Plan;
use App\PlanLog;
use App\ReferralDetails;
use App\Referrals;
use App\Repeat;
use App\RepeatLog;
use App\Support;
use App\SupportMessage;
use App\TraitsFolder\MailTrait;
use App\Trx;
use App\User;
use App\UserData;
use App\UserLog;
use App\WithdrawLog;
use App\WithdrawMethod;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\parse_header;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Validator;
use App\Lib\GoogleAuthenticator;

class UserController extends Controller
{
    use MailTrait;
    public function __construct()
    {
        $this->middleware('verifyUser');
        $this->middleware('auth');
        $this->middleware('ckstatus');
    }
    public function getDashboard()
    {

        $data['page_title'] = 'Back Office';
        $data['basic_setting'] = BasicSetting::first();
        $data['user'] = Auth::user();
        $data['balance'] = $data['user'];
        $data['deposit'] = Deposit::whereUser_id(Auth::user()->id)->whereStatus(1)->sum('amount');
        $data['status'] = $data['user']->package_id;
        $data['withdraw'] = WithdrawLog::whereUser_id(Auth::user()->id)->whereIn('status', [1])->sum('amount');

        $miners = Category::all();
        $user = Auth::user();

        foreach ($miners as $miner) {
            $userData = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

            if (!$userData) {
                UserData::create([
                    'user_id' => $user->id,
                    'category_id' => $miner->id,
                    'wallet' => '19eHnVH1pARCBWN8ZmfHnWWvnAR5JWRQRs',
                    'balance' => 0
                ]);
            }
        }
        
        if($user->wel==0){
            $text = "Welcome to Blue Forex Limited";
            $this->sendMail($user->email,$user->name,'Welcome',$text);
            $user->wel=1;
            $user->save();
        }

        $referral = Referrals::where("user_id", "=", $user->id)->get();

        if (count($referral) > 0) {

        }  else {
            $referral = new Referrals();
            $referral->user_id = $user->id;
            $referral->referral_left = 0;
            $referral->referral_right = 0;
            $referral->point_left = 0;
            $referral->point_right = 0;
            $referral->binary_active = 0;
            $referral->save();
        }
        
        //Binary Active
        $l = User::where('refid', '=', $user->id)->where('position', '=', "Left")->where('r_limit', '>', 0)->where("dstar","!=","1")->get();
        $r = User::where('refid', '=', $user->id)->where('position', '=', "Right")->where('r_limit', '>', 0)->where("dstar","!=","1")->get(); 
        if(count($r) > 0 && count($l) > 0){
                DB::table('referrals')
                ->where("user_id", "=", $user->id)
                ->update(['binary_active' => 1]);
        }
        $bstatus = Referrals::where(["user_id"=>Auth::user()->id])->get();
        if($bstatus[0]->binary_active == 1)
        {
          $data["bstatus"] = "Active";
        }else{
          $data["bstatus"] = "Inactive";
        }

            // update total withdrawal balance in wallets

            $ud = new UserData();

            $wi = $ud->where("user_id","=",$data['user']->id)->where("category_id","=","2")->get();
            $bi = $ud->where("user_id","=",$data['user']->id)->where("category_id","=","3")->get();
            $di = $ud->where("user_id","=",$data['user']->id)->where("category_id","=","4")->get();
            $ri = $ud->where("user_id","=",$data['user']->id)->where("category_id","=","5")->get();

            if($data['user']->roi > 0 || $data['user']->network > 0 || $data['user']->direct >0 || $data['user']->residual >0)
            {
                $tp = $data['user']->total_points;
                $binary = $data['user']->network;
                $residual = $data['user']->residual;
                $roi = $data['user']->roi;
                if($data['user']->direct >= $data['user']->r_limit)
                {
                  $direct = $data['user']->r_limit;
                }else{
                  $direct = $data['user']->direct;
                }
                $total = $binary + $residual + $roi + $direct;
                
                if($binary > 0)
                {
                    $tp = $tp + round($binary * 8.33);
                }
                $data['user']->total_points = $tp;
                $data['user']->total += $total;
                $data['user']->save();

                // wallet update

                $bi[0]->balance += $binary;
                $wi[0]->balance += $roi;
                $di[0]->balance += $direct;
                $ri[0]->balance += $residual;

                DB::table('user_datas')
                    ->where("user_id","=",$data['user']->id)
                    ->where("category_id","=","2")
                    ->update(['balance' => $wi[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$data['user']->id)
                    ->where("category_id","=","3")
                    ->update(['balance' => $bi[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$data['user']->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => $di[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$data['user']->id)
                    ->where("category_id","=","5")
                    ->update(['balance' => $ri[0]->balance]);

                DB::table('users')
                    ->where("id","=",$data['user']->id)
                    ->update(['network' => 0,'direct'=>0,'roi'=> 0,'residual'=> 0]);
            }

             // Points left and right show
             $points= new Referrals();
             $uds = $points->where("user_id","=",$data['user']->id)->get();

             if(count($uds)>0){
                $data['point_left']=$uds[0]->point_left;
                $data['point_right']=$uds[0]->point_right;
             }else{
                $data['point_left']=0;
                $data['point_right']=0;
             }

             //active and inactive users
             $active_user = 0;
             $inactive_user = 0;
             $user2 = new User();
             $usere = $user2->where('refid' , '=' , $data['user']->id)->get();
             foreach ($usere as $us) {
                 if($us->r_limit > 0)
                 {
                     $active_user++;
                 }
                 else
                 {
                     $inactive_user++;
                 }
             }
             $data['active_user'] = $active_user;
             $data['inactive_user'] = $inactive_user;
             
             
            //limit of user and investment
            $t_invest = 0;
            $t_pack = 0;
            $user->balance = $t_invest;
            $user->save();
            $pack = PackagesLog::where(['user_id'=>$user->id,'status'=>1])->get();
            if(count($pack)>0){
                foreach ($pack as $p) {
                    $t_pack ++;
                    $pack_l = Packages::where(['pid'=>$p->package_id])->get();
                    $t_invest += $pack_l[0]->amount;
                }
                $user->balance = $t_invest;
                $user->save();
            }
            $data["tpack"] = $t_pack;

            // Levels
            $level = new Levels();
            $level = $level->select("*")->get();

            foreach ($level as $levels)
            {
                if($data['user']->total_points < $levels->level_points) {

                   if($levels->level_id == 1)
                   {
                       $data['level'] = "None";
                   }
                   else
                   {
                       $i = $levels->level_id - 1;
                       $lev = new Levels();
                       $lev = $lev->select("level_name")->where("level_id",$i)->get();
                       $data['level'] = $lev[0]->level_name;
                   }


                   $data['next_level'] = $levels->level_name;
                   $data['level_points'] = $levels->level_points;
                   $data['t_points'] = $data['user']->total_points;
                   $data['total_percent']= round((($data['t_points'] / $data['level_points'])*100),2);
                   break;
                }
                else
                {
                       $i = $levels->level_id;
                       $lev = new Levels();
                       $lev = $lev->select("level_name")->where("level_id",$i)->get();
                       $data['level'] = $lev[0]->level_name;

                   $data['next_level'] = "None";
                   $data['level_points'] = 0;
                   $data['t_points'] = $data['user']->total_points;
                   $data['total_percent']= 100;
                }
            }
            

            $data['pack'] = Packages::all();
            //get balance from wallets
            $data['balances'] = UserData::where('user_id', Auth::user()->id)->where('category_id','!=',5)->get();
            $data['pack'] = Packages::all();

            return view('backoffice.dashboard',$data);
    }
    public function ctransfer (Request $r){
    
      $r->validate([
           'username' => 'required',
           'amount' => 'required',
        ]);
      $count = 0;
      $tid = 0;
      $user1 = User::where('id', '=', Auth::user()->id)->get();
      $id = $user1[0]->posid;
      while ($id != 0) {
          $p = User::where("id","=",$id)->get();
          if($p[0]->username == $r->username){
            $tid = $p[0]->id;
            $count++;
          }         
          $id = $p[0]->posid;
      }

      $leftcount = 0;
      $rightcount = 0;
      $referral = Referrals::where("user_id", "=", Auth::user()->id)->get();

      //left counts
      $res = User::where('posid', '=', Auth::user()->id)->where('position', '=', "Left")->get();
      $arr = array();
       
      foreach ($res as $result) {

          $arr[$leftcount] = $result->id;
          $leftcount++;
          if($result->username == $r->username){
            $tid = $result->id;
            $count++;
          }
      }
      $i = $leftcount - 1;

      while (count($arr) != 0) {
          $res = User::where('posid', '=', $arr[$i])->get();
          unset($arr[$i]);
          $i--;
          foreach ($res as $result) {
              $i++;
              $arr[$i] = $result->id;
              $leftcount++;
              if($result->username == $r->username){
              $tid = $result->id;
              $count++;
            }
          }
      }

      //right counts

      $res = User::where('posid', '=', Auth::user()->id)->where('position', '=', "Right")->get();
      $arr = array();

      foreach ($res as $result) {
          $arr[$rightcount] = $result->id;
          $rightcount++;
          if($result->username == $r->username){
            $tid = $result->id;
            $count++;
          }
      }

      $i = $rightcount - 1;

      while (count($arr) != 0) {
          $res = User::where('posid', '=', $arr[$i])->get();

          unset($arr[$i]);
          $i--;
          foreach ($res as $result) {
              $i++;
              $arr[$i] = $result->id;
              $rightcount++;
              if($result->username == $r->username){
              $tid = $result->id;
              $count++;
            }
          }
      }

      $balance = UserData::where(['user_id'=>Auth::user()->id])->where("category_id","=","6")->get();
      $tbalance = UserData::where(['user_id'=>$tid])->where("category_id","=","6")->get();
      if($balance[0]->balance == 0 || $balance[0]->balance < $r->amount){
        session()->flash('message','Donot have enough balance.');
        session()->flash('type','warning');
        session()->flash('title','Opps');

        return redirect()->back();

      }
      if($count == 0){
        session()->flash('error','Username doesnot exist.');
        session()->flash('type','error');
        session()->flash('title','Ops!');
        return redirect()->back();
      }else{

        $balance[0]->balance -= $r->amount;
        $balance[0]->save();
        
        $tbalance[0]->balance += $r->amount;
        $tbalance[0]->save();
        $rl['user_id'] = Auth::user()->id;
        $rl['name'] = $r->username;
        $rl['type'] = "Transfer";
        $rl['amount'] = $r->amount;

        $log = DetailLogs::create($rl);

        session()->flash('message','Transfer successful');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
      }

    }
    public function cbuy (Request $r){
    
      $r->validate([
           'username' => 'required',
           'amount' => 'required|numeric',
        ]);

      $balance = UserData::where(['user_id'=>Auth::user()->id])->where("category_id","=","6")->get();
      if($balance[0]->balance != 0 && $balance[0]->balance >= $r->amount ){

        $leftcount = 0;
        $rightcount = 0;
        $found = 0;
        $tid = 0;
        $user1 = User::where('id', '=', Auth::user()->id)->get();
        $id = $user1[0]->posid;
        while ($id != 0) {
          $p = User::where("id","=",$id)->get();
          if($p[0]->username == $r->username){
            $tid = $p[0]->id;
            $found++;
          }         
          $id = $p[0]->posid;
        }
        $referral = Referrals::where("user_id", "=", Auth::user()->id)->get();

        //left counts
        $res = User::where('posid', '=', Auth::user()->id)->where('position', '=', "Left")->get();
        $arr = array();
         
        foreach ($res as $result) {

            $arr[$leftcount] = $result->id;
            $leftcount++;
            if($result->username == $r->username){
                $found++;
            }
        }
        $i = $leftcount - 1;

        while (count($arr) != 0) {
            $res = User::where('posid', '=', $arr[$i])->get();
            unset($arr[$i]);
            $i--;
            foreach ($res as $result) {
                $i++;
                $arr[$i] = $result->id;
                $leftcount++;
                if($result->username == $r->username){
                $found++;
                }
            }
        }

        //right counts

        $res = User::where('posid', '=', Auth::user()->id)->where('position', '=', "Right")->get();
        $arr = array();

        foreach ($res as $result) {
            $arr[$rightcount] = $result->id;
            $rightcount++;
            if($result->username == $r->username){
                $found++;
            }
        }

        $i = $rightcount - 1;

        while (count($arr) != 0) {
            $res = User::where('posid', '=', $arr[$i])->get();

            unset($arr[$i]);
            $i--;
            foreach ($res as $result) {
                $i++;
                $arr[$i] = $result->id;
                $rightcount++;
                if($result->username == $r->username){
                  $found++;
                }
            }
        }

        if($found == 0 && $r->username != Auth::user()->username){
          session()->flash('error','Username doesnot exist.');
          session()->flash('type','error');
          session()->flash('title','Ops!');
          return redirect()->back();
        }else{
         
          $data["data"] = User::where(["username"=>$r->username])->get();
          
          $pack = Packages::where(['amount'=>$r->amount])->get();
          
          $de['user_id'] = $data["data"][0]->id;
          $de['amount'] = $pack[0]->amount;
          $de['payment_type'] = 7;
          $de['charge'] = $pack[0]->activation_fee;
          $de['rate'] = 1;
          $de['net_amount'] = $pack[0]->amount + $pack[0]->activation_fee;
          $de['status'] = 3;
          $de['transaction_id'] = strtoupper(Str::random(20));
          Deposit::create($de);
          
          $data["data"][0]->balance += $pack[0]->amount;
          $data["data"][0]->save();
          
          $balance[0]->balance -= $r->amount;
          $balance[0]->save();
          
          $parent = User::where(["id"=>2])->get();

          $text = $pack[0]->amount."- E-MONEY USD Deposit of ".$data["data"][0]->name." Successfully Completed.";
          $this->sendMail($parent[0]->email,$parent[0]->name,'Deposit Completed.',$text);

          $text ="$".$pack[0]->amount." Deposit Successfully Completed.";
          $this->sendMail($data["data"][0]->email,$data["data"][0]->name,'Deposit Completed.',$text);

          return redirect()->route('setpack',['id' => $data["data"][0]->id]);
        }
      }else{
        session()->flash('message','Donot have enough balance.');
        session()->flash('type','warning');
        session()->flash('title','Opps');

        return redirect()->back();
      }

    }
    public function transferLog()
    {
        $data['page_title'] = "Income";
        $data['log'] = DetailLogs::where(['user_id'=>Auth::user()->id])->where("type","=","Transfer")->orderBy('id','desc')->get();
        return view('backoffice.transfer-log',$data);
    }
    public function roiLog()
    {

        $data['page_title'] = "Income";
        $data['log'] = DetailLogs::where(['user_id'=>Auth::user()->id])->where("type","!=","Maintenance Fee")->where("type","!=","Transfer")->orderBy('id','asc')->get();
        return view('backoffice.income',$data);
    }
    public function mfee()
    {
        $data['page_title'] = "Fees";
        $data['log'] = DetailLogs::where(['user_id'=>Auth::user()->id,'type'=>"Maintenance Fee"])->orderBy('id','desc')->get();
        return view('backoffice.maintenance',$data);
    }
    public function residualb()
    {
        $data['page_title'] = "Residual Bonus";
        $data['log'] = BinaryLog::where(['user_id'=>Auth::user()->id])->orderBy('id','desc')->get();
        return view('backoffice.residual',$data);
    }
    public function packpurchased()
    {
        $data['page_title'] = "Purchased";
        $data['log'] = PackagesLog::where(['user_id'=>Auth::user()->id])->orderBy('id','desc')->get();
        return view('backoffice.package-detail',$data);
    }
    public function binarydetail()
    {
        $data['page_title'] = "Binary Log";
        $data['bin'] = ReferralDetails::where(['referral_id'=>Auth::user()->id])->orderBy('rdid','desc')->get();
       return view('backoffice.binary-d',$data);
    }
    public function referraldetail()
    {
      //active and inactive users
         $active_user = 0;
         $inactive_user = 0;
         $user2 = new User();
         $usere = $user2->where('refid' , '=' , Auth::user()->id)->get();
         foreach ($usere as $us) {
             if($us->r_limit > 0)
             {
                 $active_user++;
             }
             else
             {
                 $inactive_user++;
             }
         }
         $data['active_user'] = $active_user;
         $data['inactive_user'] = $inactive_user;
        $data['page_title'] = "Direct Referrals";
        $data['ref'] = User::where(['refid'=>Auth::user()->id])->orderBy('refid','desc')->get();
       return view('backoffice.referrals',$data);
    }
 
    public function submitawallet(Request $r)
    {
        $r->validate([
                'username' => 'required',
                'amount' => 'required|numeric'
            ]);
        
        $person = User::where("username","=",$r->username)->get();
        
        if(count($person) > 0){

            if( $person[0]->id <= Auth::user()->id){
                session()->flash('alert', "You donot have access to this user");
                Session::flash('type', 'warning');
                session()->flash('title','Opps');

                return redirect()->back();
            }

            if($r->amount > Auth::user()->ewallet){

                session()->flash('message', "Donot have enough e-money");
                Session::flash('type', 'warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }else{

                $pack = Packages::where(['amount'=>$r->amount])->get();
                $pk['user_id'] = $person[0]->id;
                $pk['package_id'] = $pack[0]->pid;
                $pk['r_wait'] = 1;
                $pk['r_week'] = $pack[0]->period;
                $pk['status'] = 1;
                PackagesLog::create($pk);
                
                $person[0]->r_limit += $pack[0]->limit;
                $person[0]->balance += $pack[0]->amount;
                $person[0]->save();
                
                Auth::user()->ewallet -= $r->amount;
                Auth::user()->save();

                session()->flash('message', 'Package Buy Successfully.');
                Session::flash('type', 'success');
                Session::flash('title', 'Success');

               return redirect()->back();
            }
            
        }else{
            session()->flash('alert', "User does not exist");
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }
  

    }
    public function doc()
    {
        $data['user'] = Auth::user();
        $data['page_title'] = 'Presentation';
       return view('backoffice.document',$data);
    }
    public function withdraws()
    {
        $data['user'] = Auth::user();
        $data['page_title'] = 'Withdraw';
       return view('backoffice.withdraw',$data);
    }
    public function treesearch(Request $request)
    {
        
        $data['user'] = Auth::user();
        $data['page_title'] = 'Network Tree';

        $user = new User();
        $data['username'] = $user->where('username', '=', $request->username)->get();

        if (count($data['username']) > 0 && $data['username'][0]->refid != 0)
        {
           $data['reffff'] = $user->where('id','=',$data['username'][0]->refid)->get();
        }
        else
        {
            session()->flash('alert', 'User Does not exist');
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }

        if($data['user']->id <= $data['username'][0]->id)
          {
            $referrall = new Referrals();
            $referrall = $referrall->where('user_id','=',$data['username'][0]->id)->get();

            if(count($referrall)>0){
                $data['left'] = $referrall[0]->referral_left;
                $data['right'] = $referrall[0]->referral_right;
                $data['pl'] = $referrall[0]->point_left;
                $data['pr'] = $referrall[0]->point_right;
            }else{
                $data['left'] = 0;
                $data['right'] = 0;
                $data['pl'] = 0;
                $data['pr'] = 0;
            }
            

            $data['name'] = $data['username'][0]->username;
            $data['reference'] = $data['reffff'][0]->username;

            $data['ref'] = $user->where('refid','=',$data['username'][0]->id)->get();

            $data['pos1r'] = $user->where('posid','=',$data['username'][0]->id)->where('position','=',"Right")->get();
            $data['pos1l'] = $user->where('posid','=',$data['username'][0]->id)->where('position','=',"Left")->get();

            if(count($data['pos1l']) > 0)
            {
                $data['pos21l'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Left")->get();
                $data['pos21r'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos21l'] = [];
                $data['pos21r'] = [];
            }

            if(count($data['pos1r']) > 0)
            {
                $data['pos22l'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Left")->get();
                $data['pos22r'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos22l'] = [];
                $data['pos22r'] = [];
            }

            if(count($data['pos21l']) > 0)
            {
                $data['pos31l'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Left")->get();
                $data['pos31r'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos31l'] = [];
                $data['pos31r'] = [];
            }

            if(count($data['pos21r']) > 0)
            {
                $data['pos32l'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Left")->get();
                $data['pos32r'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos32l'] = [];
                $data['pos32r'] = [];
            }

            if(count($data['pos22l']) > 0)
            {
                $data['pos33l'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Left")->get();
                $data['pos33r'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos33l'] = [];
                $data['pos33r'] = [];
            }

            if(count($data['pos22r']) > 0)
            {
                $data['pos34l'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Left")->get();
                $data['pos34r'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos34l'] = [];
                $data['pos34r'] = [];
            }


            return view('backoffice.network',$data);
         }
        else
        {
            session()->flash('alert', 'User Does not exist');
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }
    }
    public function showtree()
    {
        $data['user'] = Auth::user();
        $data['page_title'] = 'Network Tree';
        
        $user = new User();
        
        if($data['user']->refid != 0){
            
            $data['reffff'] = $user->where('id','=',$data['user']->refid)->get();
            $data['reference'] = $data['reffff'][0]->username;
        }else{
            $data['reference'] = "none";
        }
        
        
        $referrall = new Referrals();
        $referrall = $referrall->where('user_id','=',$data['user']->id)->get();
        if(count($referrall)>0){
            $data['left'] = $referrall[0]->referral_left;
            $data['right'] = $referrall[0]->referral_right;
            $data['pl'] = $referrall[0]->point_left;
            $data['pr'] = $referrall[0]->point_right;
        }else{
            $data['left'] = 0;
            $data['right'] = 0;
            $data['pl'] = 0;
            $data['pr'] = 0;
        }
        
        $data['name'] = $data['user']->username;
        $data['username'] = $user->where('id','=',$data['user']->id)->get();
        $data['ref'] = $user->where('refid','=',$data['user']->id)->get();

        $data['pos1r'] = $user->where('posid','=',$data['user']->id)->where('position','=',"Right")->get();
        $data['pos1l'] = $user->where('posid','=',$data['user']->id)->where('position','=',"Left")->get();

        if(count($data['pos1l']) > 0)
        {
            $data['pos21l'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Left")->get();
            $data['pos21r'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos21l'] = [];
            $data['pos21r'] = [];
        }

        if(count($data['pos1r']) > 0)
        {
            $data['pos22l'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Left")->get();
            $data['pos22r'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos22l'] = [];
            $data['pos22r'] = [];
        }

        if(count($data['pos21l']) > 0)
        {
            $data['pos31l'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Left")->get();
            $data['pos31r'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos31l'] = [];
            $data['pos31r'] = [];
        }

        if(count($data['pos21r']) > 0)
        {
            $data['pos32l'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Left")->get();
            $data['pos32r'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos32l'] = [];
            $data['pos32r'] = [];
        }

        if(count($data['pos22l']) > 0)
        {
            $data['pos33l'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Left")->get();
            $data['pos33r'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos33l'] = [];
            $data['pos33r'] = [];
        }

        if(count($data['pos22r']) > 0)
        {
            $data['pos34l'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Left")->get();
            $data['pos34r'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Right")->get();
        }
        else
        {
            $data['pos34l'] = [];
            $data['pos34r'] = [];
        }


        return view('backoffice.network',$data);
    }
    public function showtrees()
    {
        $id  = Input::get('id') ;
        $data['user'] = Auth::user();
        $data['page_title'] = 'Network Tree';
        $user = new User();
        $data['username'] = $user->where('username','=',$id)->get();       

        if (count($data['username']) > 0 && $data['username'][0]->refid != 0)
        {
            $data['reffff'] = $user->where('id','=',$data['username'][0]->refid)->get();
        }
        else
        {
            session()->flash('alert', 'User Does not exist');
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }

        if($data['user']->id <= $data['username'][0]->id)
        {
            $referrall = new Referrals();
            $referrall = $referrall->where('user_id','=',$data['username'][0]->id)->get();
            if(count($referrall)>0){
                $data['left'] = $referrall[0]->referral_left;
                $data['right'] = $referrall[0]->referral_right;
                $data['pl'] = $referrall[0]->point_left;
                $data['pr'] = $referrall[0]->point_right;
            }else{
                $data['left'] = 0;
                $data['right'] = 0;
                $data['pl'] = 0;
                $data['pr'] = 0;
            }

            $data['name'] = $data['username'][0]->username;
            $data['reference'] = $data['reffff'][0]->username;
            
            $data['ref'] = $user->where('refid','=',$data['username'][0]->id)->get();

            $data['pos1r'] = $user->where('posid','=',$data['username'][0]->id)->where('position','=',"Right")->get();
            $data['pos1l'] = $user->where('posid','=',$data['username'][0]->id)->where('position','=',"Left")->get();

            if(count($data['pos1l']) > 0)
            {
                $data['pos21l'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Left")->get();
                $data['pos21r'] = $user->where('posid','=',$data['pos1l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos21l'] = [];
                $data['pos21r'] = [];
            }

            if(count($data['pos1r']) > 0)
            {
                $data['pos22l'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Left")->get();
                $data['pos22r'] = $user->where('posid','=',$data['pos1r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos22l'] = [];
                $data['pos22r'] = [];
            }

            if(count($data['pos21l']) > 0)
            {
                $data['pos31l'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Left")->get();
                $data['pos31r'] = $user->where('posid','=',$data['pos21l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos31l'] = [];
                $data['pos31r'] = [];
            }

            if(count($data['pos21r']) > 0)
            {
                $data['pos32l'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Left")->get();
                $data['pos32r'] = $user->where('posid','=',$data['pos21r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos32l'] = [];
                $data['pos32r'] = [];
            }

            if(count($data['pos22l']) > 0)
            {
                $data['pos33l'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Left")->get();
                $data['pos33r'] = $user->where('posid','=',$data['pos22l'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos33l'] = [];
                $data['pos33r'] = [];
            }

            if(count($data['pos22r']) > 0)
            {
                $data['pos34l'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Left")->get();
                $data['pos34r'] = $user->where('posid','=',$data['pos22r'][0]->id)->where('position','=',"Right")->get();
            }
            else
            {
                $data['pos34l'] = [];
                $data['pos34r'] = [];
            }


            return view('backoffice.network',$data);
        }
        else
        {
            session()->flash('alert', 'User Does not exist');
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }
    }
    /*
     * User Packages
     * */
    public function allPack()

    {
        //$data['packages'] = Plan::where('status', '1')->get();
        $data['page_title'] = 'All Package';

        $plans = Plan::all();
        // if ($categories) {
        //     foreach ($categories as $category) {
        //         $plans[$category->id];
        //         // $p = Plan::where(['category_id' => $category->id, 'status' => 1])->orderBy('price', 'ASC')->first();
        //         // if ($p) {
        //         //     $p->miner = $category->name;
        //         //     $plans[$category->id] = $p;
        //         // }
        //     }
        // }
        $data['plan'] = $plans;
       
        return view('backoffice.pakage', $data);

    }

    public function purchasePlan($id)

    {

        $plan = Plan::find($id);
        $basic = BasicSetting::first();

        if ($plan) {

            $balance = Auth::user()->balance;

            if ($plan->price > $balance){

                session()->flash('alert', 'Not Enough Balance.');
                Session::flash('type', 'warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            $user = Auth::user();
            $user->balance = $user->balance - $plan->price;
            $user->save();

            $request = PlanLog::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'status' => 0
            ]);

            $trx = Trx::create([
                'track' => $request->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $plan->price,
                'charge' => '0',
                'net_amount' => $plan->price,
                'type' => 'PlanLog',
                'description' => 'Purchased ' . $plan->title,
                'trxid' => md5(uniqid(rand(), true)),
                'custom' => '',
                'status' => 'requested'
            ]);

            $email = $user->email;
            $mobile = $user->phone;

            $name = $user->name;
            $subject = 'Plan Purchased';
            $text = 'Purchased ' . $plan->title . ' .<br>';
            $text .= 'Plan Purchased Successfully.';


            $this->sendMail($email,$name,$subject,$text);
            $this->sendSms($mobile,$text);

            if ($request) {
                session()->flash('success', 'Plan Purchased Successfully.');
                Session::flash('type', 'success');
                session()->flash('title','Success');
            }

        }

        return redirect()->back();

    }

    public function purchasedPlan()

    {

        $data['logs'] = PlanLog::where('user_id', Auth::user()->id)->get();
        $data['page_title'] = 'Purchased Plan';

        foreach ($data['logs'] as $log) {

        	$purchaseDate = $log->created_at;
        	$now = Carbon::now();

        	$plan = $log->plan;

        	if ($plan) {

                if ($plan->ptyp == 'day') {

                    $hour = $plan->period*24;

                } elseif ($plan->ptyp == 'month') {

                    $hour = $plan->period*730;

                } elseif ($plan->ptyp == 'year') {

                    $hour = $plan->period*24*365;

                } else {
                    $hour = 0;
                }

	        	if ($now->diffInHours($purchaseDate) > $hour) {
	        		
	        		$log->status = -10;
	        		$log->save();

	        	}

        	}

        }

        return view('backoffice.purchased-plan', $data);

    }

    public function changePassword()
    {
        $data['page_title'] = "Change Password";
        return view('backoffice.change-password', $data);
    }

    public function submitPassword(Request $request)
    {
        $this->validate($request, [
            'current_password' =>'required',
            'password' => 'required|min:5|confirmed'
        ]);
        try {
            $c_password = Auth::user()->password;
            $c_id = Auth::user()->id;
            $user = User::findOrFail($c_id);
            if(Hash::check($request->current_password, $c_password)){

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->save();
                session()->flash('message', 'Password Changes Successfully.');
                session()->flash('title','Success');
                Session::flash('type', 'success');
                return redirect()->back();
            }else{
                session()->flash('alert', 'Current Password Not Match');
                Session::flash('type', 'warning');
                session()->flash('title','Opps');
                return redirect()->back();
            }

        } catch (\PDOException $e) {
            session()->flash('alert', $e->getMessage());
            Session::flash('type', 'warning');
            session()->flash('title','Opps');
            return redirect()->back();
        }
    }
    public function verify()
    {
        $data['page_title'] = "Verify Document";
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('backoffice.verify', $data);
    }
    public function submitverify(Request $request)
    {
        
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'id_image' => 'mimes:png,jpg,jpeg',
        ]);
        $in = Input::except('_method','_token');
        $in['reference'] = $user->username;

        if($request->hasFile('id_image')){
            $image = $request->file('id_image');
            $filename = $user->username.'-verify.'.$image->getClientOriginalExtension();
            $location = 'assets/verify/' . $filename;
            $in['id_image'] = $filename;
            $path = './assets/verify/';
            $link = $path.$user->id_image;
            if (file_exists($link)) {
                unlink($link);
            }
            Image::make($image)->resize(400,400)->save($location);
        }
        $user->fill($in)->save();
        session()->flash('message', 'Profile Updated Successfully.');
        session()->flash('title','Success');
        Session::flash('type', 'success');
        return redirect()->back();
    }

    public function editProfile()
    {
        $data['page_title'] = "Edit Profile";
        $data['user'] = User::findOrFail(Auth::user()->id);
        $data['reffff'] = User::where('id','=',$data['user']->refid)->get();
        $data['reference1'] = $data['reffff'][0]->username;

        $miners = Category::all();
        $user = Auth::user();

        foreach ($miners as $miner) {
            $userData = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

            if (!$userData) {
                UserData::create([
                    'user_id' => $user->id,
                    'category_id' => $miner->id,
                    'wallet' => '',
                    'balance' => 0
                ]);
            }
        }
        
        $data['user_datas'] = $user->userDatas;
        $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 2)->get();
        $data['binary'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 3)->get();
        
        return view('backoffice.account', $data);
    }
    public function submitProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'required|string|min:10|unique:users,phone,'.$user->id,
            'username' => 'required|min:5|unique:users,username,'.$user->id,
            'image' => 'mimes:png,jpg,jpeg'
        ]);
        $in = Input::except('_method','_token');
        $in['reference'] = $request->username;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $filename = $request->username.'.'.$image->getClientOriginalExtension();
            $location = 'assets/images/' . $filename;
            $in['image'] = $filename;
            if ($user->image != 'user-default.png'){
                $path = './assets/images/';
                $link = $path.$user->image;
                if (file_exists($link)) {
                    unlink($link);
                }
            }
            Image::make($image)->resize(400,400)->save($location);
        }
        $user->fill($in)->save();
        session()->flash('message', 'Profile Updated Successfully.');
        session()->flash('title','Success');
        Session::flash('type', 'success');
        return redirect()->back();
    }
    public function depositMethod()
    {
        $data['page_title'] = 'Deposit Method';
        $data['methods'] = PaymentMethod::where('status', 1)->get();

        return view('backoffice.deposit-fund',$data);
    }
    public function submitDepositFund(Request $r)
    {

        $basic = BasicSetting::first();

        $this->validate($r,[
            'amount'         => 'required|numeric',
            'payment_type'   => 'required|numeric',
        ]);

        $method = PaymentMethod::whereId($r->payment_type)->first();

        if (!$method) {
            session()->flash('message', 'Unexpected Error! Please Try Again.');
            session()->flash('title','Error');
            Session::flash('type', 'error');
            return redirect()->back();
        }

        $amount = $r->amount;
        $adminfee = Packages::where(["amount"=> $amount])->get();
        $charge = $adminfee[0]->activation_fee;

        $lo['member_id'] = Auth::user()->id;
        $lo['custom'] = strtoupper(Str::random(20));
        $lo['amount'] = $amount;
        $lo['charge'] = round($charge, $basic->deci);
        $lo['net_amount'] = $amount + $charge;
        
        if($r->payment_type == 5){

            $all = file_get_contents("https://blockchain.info/ticker");
            $res = json_decode($all);
            $lo['btc_amo'] = round( ($amount + $charge) * (1/$res->USD->last),16);
            $lo['usd'] = round(($amount + $charge), $basic->deci);

        }else{

            $lo['usd'] = round(($amount + $charge) / $method->rate, $basic->deci);

        }

        $lo['payment_type'] = $r->payment_type;
        $data['fund'] = PaymentLog::create($lo);
        
        session()->flash('track', $data['fund']->custom);
        
        return redirect()->route('deposit',$data['fund']->custom);
    }
    public function depositPreview()
    {

        if (session('track') == NULL) return redirect()->back();

        $data['fund'] = PaymentLog::whereCustom(session('track'))->first();

        if (!$data['fund']) return redirect()->back();

        $data['page_title'] = $data['fund']->payment->name . ' Deposit';

        return view('backoffice.deposit-preview', $data);
    }
    public function depositRedirect($track)

    {

        $fund = PaymentLog::whereCustom($track)->first();

        if ($fund) {
            $data['page_title'] = '';
            $data['fund'] = $fund;
            return view('backoffice.deposit-form', $data);
        } else {
            return redirect()->back();
        }

    }
    public function historyDepositFund()

    {

        $data['page_title'] = "Deposits";
        $data['deposit'] = Deposit::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();

        return view('backoffice.deposit-history', $data);

    }
    public function userActivity()

    {

        $data['page_title'] = "Transaction Log";
        $data['logs'] = Trx::where('sender', Auth::user()->id)->orWhere('receiver', Auth::user()->id)->paginate(10);

        return view('backoffice.user-activity',$data);

    }
    public function withdrawRequest()
    {

        $data['page_title'] = "Withdraw Fund";
        $data['basic'] = BasicSetting::first();

        if ($data['basic']->withdraw_status == 0){
            session()->flash('message','Currently Withdraw Is Deactivated.');
            session()->flash('type','warning');
            session()->flash('title','Warning');
        }
        $points= new UserData();
        $uds = $points->where("user_id","=",Auth::user()->id)->where('category_id', '=', 3)->get();
        $data['method'] = WithdrawMethod::whereStatus(1)->get();
        $data['coins'] = UserData::where('user_id', Auth::user()->id)->where('balance', '>', 0)->get();
        $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 2)->get();
        $data['binary'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 3)->get();
        $data['direct'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 4)->get();
        $data['resi'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 5)->get();
        $data['cashwallet'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 6)->get();
        
        return view('backoffice.withdraw-request', $data);

    }
    public function withdrawRequests()
    {

        $data['page_title'] = "Withdraw Fund";
        $data['basic'] = BasicSetting::first();

        if ($data['basic']->withdraw_status == 0){
            session()->flash('message','Currently Withdraw Is Deactivated.');
            session()->flash('type','warning');
            session()->flash('title','Warning');
        }
        $points= new UserData();
        $uds = $points->where("user_id","=",Auth::user()->id)->where('category_id', '=', 3)->get();
        $data['method'] = WithdrawMethod::whereStatus(1)->get();
        $data['coins'] = UserData::where('user_id', Auth::user()->id)->where('balance', '>', 0)->get();
        $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 2)->get();
        $data['binary'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 3)->get();
        $data['direct'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 4)->get();
        $data['resi'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 5)->get();
        $data['cashwallet'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 6)->get();
        
        return view('backoffice.withdraw-request-bitcoin', $data);

    }
    public function submitWithdrawRequest($type, Request $r)
    {
        
        
        $basic = BasicSetting::first();
        $data['user'] = Auth::user();

        if ($type == 'general') {

            $r->validate([
                'method_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);

            $method = WithdrawMethod::findOrFail($r->method_id);
            $charge = $method->fix + round(($r->amount * $method->percent) / 100, $basic->deci);
            $gross = $r->amount+$charge;
           
            if ($gross <= 0){

                session()->flash('message','Your Request Amount Must Be Larger Then Zero.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross < $method->withdraw_min){

                session()->flash('message','Your Request Amount is Smaller Then Withdraw Minimum Amount.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross > $method->withdraw_max){

                session()->flash('message','Your Request Amount is Larger Then Withdraw Maximum Amount.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }

            if ($gross > Auth::user()->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {

                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->method_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'general';

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        } elseif ($type == 'coin') {

            $r->validate([
                'miner_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);

            $wallet = UserData::findOrFail($r->miner_id);

            if (!$wallet) return redirect()->back();

            $charge = ($r->amount * $basic->withdraw_charge) / 100;

            $gross = $r->amount-$charge;

            if(Auth::user()->id_image == "0"){
                
                session()->flash('message','Upload your documents for withdrawl');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();
            }

            if ($gross < 45){

                session()->flash('message','Minium withdraw is $50.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } 
            if ($wallet->wallet == NULL){

            session()->flash('message','Please Update Payment Details.');
            session()->flash('type','warning');
            session()->flash('title','Opps');
            
            return redirect()->back();
            
            }
            if ($gross > $wallet->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {
                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->miner_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'coin';
                $wl['status'] = 4;

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        }elseif ($type == 'PM') {

            $r->validate([
                'miner_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);


            $wallet = UserData::findOrFail($r->miner_id);
            $walletu = UserData::where(["user_id"=>Auth::user()->id,"category_id"=>3])->get();

            if (!$wallet) return redirect()->back();

            $charge = ($r->amount * $basic->withdraw_charge) / 100;

            $gross = $r->amount-$charge;

            if(Auth::user()->id_image == "0"){
                
                session()->flash('message','Upload your documents for withdrawl');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();
            }
            if ($gross < 45){

                session()->flash('message','Minium withdraw is $50.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }
            if ($walletu[0]->wallet == NULL){

                session()->flash('message','Please Update Payment Details.');
                session()->flash('type','warning');
                session()->flash('title','Opps');
                
                return redirect()->back();
            }
            if ($gross > $wallet->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {
                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->miner_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'PM';
                $wl['status'] = 4;

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        }elseif ($type == 'BTC') {

            $r->validate([
                'bitcoin' => 'required',
                'miner_id' => 'required|numeric',
                'amount' => 'required|numeric'
            ]);

            UserData::where(['user_id' => Auth::user()->id, 'category_id' => 2])->update(['wallet' => $r->bitcoin]);

            $wallet = UserData::findOrFail($r->miner_id);

            $walletu = UserData::where(["user_id"=>Auth::user()->id,"category_id"=>2])->get();

            if (!$wallet) return redirect()->back();

            $charge = ($r->amount * $basic->withdraw_charge) / 100;

            $gross = $r->amount-$charge;

            if(Auth::user()->id_image == "0"){
                
                session()->flash('message','Upload your documents for withdrawl');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();
            }
            if ($gross < 45){

                session()->flash('message','Minium withdraw is $50.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            }
            if ($walletu[0]->wallet == NULL){
                session()->flash('message','Please Update Payment Details.');
                session()->flash('type','warning');
                session()->flash('title','Opps');
                
                return redirect()->back();
            }
            if ($gross > $wallet->balance) {

                session()->flash('message','Your Request Amount is Larger Then Your Current Balance.');
                session()->flash('type','warning');
                session()->flash('title','Opps');

                return redirect()->back();

            } else {
                $trx = strtoupper(Str::random(20));

                $wl['amount'] = $r->amount;
                $wl['method_id'] = $r->miner_id;
                $wl['charge'] = $charge;
                $wl['transaction_id'] = $trx;
                $wl['net_amount'] = $gross;
                $wl['user_id'] = Auth::user()->id;
                $wl['type'] = 'BTC';
                $wl['status'] = 4;

                $log = WithdrawLog::create($wl);

                session()->flash('trx', $trx);

                return redirect()->route('withdraw-preview');

            }

        }
    }
    public function previewWithdraw()
    {

        if (session('trx') == NULL) return redirect()->back();

        $trx = session('trx');

        $log = WithdrawLog::whereTransaction_id($trx)->first();

        if (!$log) return redirect()->back();

        $data['page_title'] = ucfirst($log->type) . " Withdraw";

        if ($log->type == 'general') {

            $data['withdraw'] = $log;
            $data['method'] = WithdrawMethod::findOrFail($log->method_id);

            return view('backoffice.withdraw-preview', $data);

        } elseif($log->type == 'coin') {

            $data['withdraw'] = $log;
            $data['data'] = UserData::findOrFail($log->method_id);
            return view('backoffice.withdraw-preview-coin', $data);

        }
        elseif($log->type == 'PM') {

            $data['withdraw'] = $log;
            $data['data'] = UserData::findOrFail($log->method_id);
            $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 3)->get();
            $data['pwallet']=$data['passive'][0]->wallet;
            return view('backoffice.withdraw-preview-coin', $data);

        }
        elseif($log->type == 'BTC') {

            $data['withdraw'] = $log;
            $data['data'] = UserData::findOrFail($log->method_id);
            $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 2)->get();
            $data['pwallet']=$data['passive'][0]->wallet;
            return view('backoffice.withdraw-preview-coin', $data);

        }
    }
    public function submitWithdraw(Request $r)
    {

        $r->validate([
           'withdraw_id' => 'required|numeric'
        ]);

        $basic = BasicSetting::first();

        $log = WithdrawLog::findOrFail($r->withdraw_id);

        if (!$log) return redirect()->back();
        if ($log->type == 'general') {

            $r->validate([
                'send_details' => 'required'
            ]);

            $log->send_details = $r->send_details;
            $log->message = $r->message;
            $log->save();

            $user = Auth::user();

            $user->balance = $user->balance - $log->amount;
            $user->save();

            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $basic->currency." Withdraw Request Send via ".$log->method->name.". <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $basic->currency." Withdraw Request Send via ".$log->method->name.". <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        } elseif ($log->type == 'coin') {

            $user = Auth::user();

            $wallet = UserData::findOrFail($log->method_id);

            $wallet->balance = $wallet->balance - $log->amount;
            $wallet->save();
            $log->status = 0;
            $log->save();
            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);$trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);

            $parent = User::where(["id"=>2])->get();
            $text = $log->amount." - ". $wallet->miner->code ."Withdraw Request";
            $this->sendMail($parent[0]->email,$user->name,'Withdraw Request',$text);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code . " Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code." Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        }elseif ($log->type == 'PM') {
            $name = Input::get('wall');
            
            $data = UserData::where(['user_id' => Auth::user()->id, 'category_id' => 3])->update([
                'wallet' => $name
            ]);
            $user = Auth::user();

            $wallet = UserData::findOrFail($log->method_id);

            $wallet->balance = $wallet->balance - $log->amount;
            $wallet->save();
            $log->status = 0;
            $log->save();
            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);$trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);
            
            $parent = User::where(["id"=>2])->get();
            $text = $log->amount." - ". $wallet->miner->code ."Withdraw Request";
            $this->sendMail($parent[0]->email,$user->name,'Withdraw Request',$text);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code . " Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code." Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        }elseif ($log->type == 'BTC') {
            $name = Input::get('wall'); 
            $data = UserData::where(['user_id' => Auth::user()->id, 'category_id' => 2])->update([
                'wallet' => $name
            ]);

            $user = Auth::user();

            $wallet = UserData::findOrFail($log->method_id);

            $wallet->balance = $wallet->balance - $log->amount;
            $wallet->save();
            $log->status = 0;
            $log->save();
            $trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);$trx = Trx::create([
                'track' => $log->id,
                'sender' => $user->id,
                'receiver' => $basic->title,
                'gross_amount' => $log->net_amount,
                'charge' => $log->charge,
                'net_amount' => $log->amount,
                'type' => 'WithdrawLog',
                'description' => 'Coin Withdraw Request.',
                'trxid' => $log->transaction_id,
                'custom' => '',
                'status' => 'requested'
            ]);

            $parent = User::where(["id"=>2])->get();
            $text = $log->amount." - ". $wallet->miner->code ."Withdraw Request";
            $this->sendMail($parent[0]->email,$user->name,'Withdraw Request',$text);

            if ($basic->email_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code . " Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendMail($user->email, $user->name, 'Withdraw Request.', $text);
            }
            if ($basic->phone_notify == 1){
                $text = $log->amount." - ". $wallet->miner->code." Withdraw Request Send. <br> Transaction ID Is : <b>#$log->transaction_id</b>";
                $this->sendSms($user->phone, $text);
            }

        }

        session()->flash('message','Withdraw request Successfully Submitted. Wait For Confirmation.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->route('withdraw-log');

    }
    public function withdrawLog()
    {
        $data['page_title'] = "Withdraws";
        $data['withdraw'] = WithdrawLog::whereUser_id(Auth::user()->id)->whereIn('status', [1])->sum('amount');
        $data['log'] = WithdrawLog::whereUser_id(Auth::user()->id)->where("status","!=", 4 )->orderBy('id','desc')->get();
        return view('backoffice.withdraw-log',$data);
    }
    public function openSupport()
    {
        //package name  
            $packa = PackagesLog::where(["user_id"=>Auth::user()->id,"status"=>1])->get();
            $pid = 0;
            $data["pp"] = 0;
            if(count($packa)>0){
               foreach ( $packa as $pac) {
                    if($pid < $pac->package_id){
                       $pid = $pac->package_id;
                       $packs = Packages::where(["pid"=>$pid])->get();
                       $data["packn"] = $packs[0]->package_name;
                       $data["pp"] = 1;
                    }
                } 
            }
        $data['page_title'] = "New Ticket";
        return view('backoffice.support-open', $data);
    }
    public function submitSupport(Request $request)
    {
        $this->validate($request,[
            'subject' => 'required',
            'message' => 'required'
        ]);
        $s['ticket_number'] = strtoupper(Str::random(12));
        $s['user_id'] = Auth::user()->id;
        $s['subject'] = $request->subject;
        $s['status'] = 1;
        $mm = Support::create($s);
        $mess['support_id'] = $mm->id;
        $mess['ticket_number'] = $mm->ticket_number;
        $mess['message'] = $request->message;
        $mess['type'] = 1;
        SupportMessage::create($mess);
        session()->flash('success','Support Ticket Successfully Open.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->route('support-all');
    }
    public function allSupport()
    {
        $data['page_title'] = "All Ticket";
        $data['support'] = Support::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();
        return view('backoffice.support-all',$data);
    }
    public function supportMessage($id)
    {
        $data['page_title'] = "Support Message";
        $data['support'] = Support::whereTicket_number($id)->first();
        $data['message'] = SupportMessage::whereTicket_number($id)->orderBy('id','asc')->get();
        return view('backoffice.support-message', $data);
    }
    public function userSupportMessage(Request $request)
    {
        $this->validate($request,[
            'message' => 'required',
            'support_id' => 'required'
        ]);
        $mm = Support::findOrFail($request->support_id);
        $mm->status = 3;
        $mm->save();
        $mess['support_id'] = $mm->id;
        $mess['ticket_number'] = $mm->ticket_number;
        $mess['message'] = $request->message;
        $mess['type'] = 1;
        SupportMessage::create($mess);
        session()->flash('message','Support Ticket Successfully Reply.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }
    public function supportClose(Request $request)
    {
        $this->validate($request,[
            'support_id' => 'required'
        ]);
        $su = Support::findOrFail($request->support_id);
        $su->status = 9;
        $su->save();
        session()->flash('message','Support Successfully Closed.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }

    public function newInvest()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "User New Invest";
        $data['plan'] = Plan::whereStatus(1)->get();
        return view('backoffice.investment-new',$data);
    }

    public function postInvest(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);
        $data['page_title'] = "Investment Preview";
        $data['plan'] = Plan::findOrFail($request->id);
        return view('backoffice.investment-preview',$data);
    }

    public function investAmountReview(Request $request)
    {   
        $data = Plan::findOrFail($request->id);
        $data['compound_name'] = Plan::findOrFail($request->id)->compound->name;
        
        return response()->json($data);
        
        
    }


    public function chkInvestAmount(Request $request)
    {
        $plan = Plan::findOrFail($request->plan);
        $user = User::findOrFail(Auth::user()->id);
        $amount = $request->amount;

        if ($request->amount > $user->balance){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Larger than Your Current Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg delete_button disabled"
                        >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }
        if( $plan->minimum > $amount){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Smaller than Plan Minimum Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg  delete_button disabled"
                        >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }elseif( $plan->maximum < $amount){
            return '<div class="col-sm-12">
                <div class="alert alert-warning"><i class="fa fa-times"></i> Amount Is Larger than Plan Maximum Amount.</div>
            </div>
            <div class="col-sm-12">
                <button type="button" class="btn btn-primary btn-block bold uppercase btn-lg delete_button disabled"
                      >
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }else{
            return '<div class="col-sm-12">
                <div class="alert alert-success"><i class="fa fa-check"></i> Well Done. Invest This Amount Under this Package.</div>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary bold uppercase btn-block btn-lg delete_button"
                        data-toggle="modal" data-target="#DelModal"
                        data-id='.$amount.'>
                    <i class="fa fa-cloud-upload"></i> Invest Amount Under This Package
                </button>
            </div>';
        }

    }

    public function submitInvest(Request $request)
    {
        $basic = BasicSetting::first();
        $user_balance = User::findOrFail(Auth::user()->id)->balance;
        
        $validator = Validator::make($request->all(), [
              'amount' => 'required|numeric|max:'.$user_balance,
            'user_id' => 'required',
            'plan_id' => 'required'
        ]);

        if ($validator->fails()) {
            
            session()->flash('error','Something wrong try again!.');
            session()->flash('type','error');
            session()->flash('title','Ops!');
            return redirect()->back();
        };

        $in = Input::except('_method','_token');
        $in['trx_id'] = strtoupper(Str::random(20));
        $invest = Investment::create($in);

        $pak = Plan::findOrFail($request->plan_id);
        $com = Compound::findOrFail($pak->compound_id);
        $rep['user_id'] = $invest->user_id;
        $rep['investment_id'] = $invest->id;
        $rep['repeat_time'] = Carbon::parse()->addHours($com->compound);
        $rep['total_repeat'] = 0;
        Repeat::create($rep);

        $bal4 = User::findOrFail(Auth::user()->id);
        $ul['user_id'] = $bal4->id;
        $ul['amount'] = $request->amount;
        $ul['charge'] = null;
        $ul['amount_type'] = 14;
        $ul['post_bal'] = $bal4->balance - $request->amount;
        $ul['description'] = $request->amount." ".$basic->currency." Invest Under ".$pak->name." Plan.";
        $ul['transaction_id'] = $in['trx_id'];
        UserLog::create($ul);

        $bal4->balance = $bal4->balance - $request->amount;
        $bal4->save();

        $trx = $in['trx_id'];

        if ($basic->email_notify == 1){
            $text = $request->amount." - ". $basic->currency." Invest Under ".$pak->name." Plan. <br> Transaction ID Is : <b>#$trx</b>";
            $this->sendMail($bal4->email,$bal4->name,'New Investment',$text);
        }
        if ($basic->phone_notify == 1){
            $text = $request->amount." - ". $basic->currency." Invest Under ".$pak->name." Plan. <br> Transaction ID Is : <b>#$trx</b>";
            $this->sendSms($bal4->phone,$text);
        }

        session()->flash('success','Investment Successfully Completed.');
        session()->flash('type','success');
        session()->flash('title','Success');
        return redirect()->back();
    }

    public function historyInvestment()
    {
        $data['page_title'] = "Invest History";
        $data['history'] = Investment::whereUser_id(Auth::user()->id)->orderBy('id','desc')->get();
        return view('backoffice.investment-history',$data);
    }

    public function repeatLog()
    {
        $data['user'] = User::findOrFail(Auth::user()->id);
        $data['page_title'] = 'All Repeat History';
        $data['log'] = RepeatLog::whereUser_id(Auth::user()->id)->orderBy('id','desc')->paginate(15);
        return view('backoffice.repeat-history',$data);
    }
//    public function userReference()
//    {
//        $data['page_title'] = "Reference User";
//        $data['user'] = User::whereUnder_reference(Auth::user()->id)->orderBy('id','desc')->get();
//        return view('backoffice.reference-user',$data);
//    }

    public function walletSettings()

    {

        $miners = Category::all();
        $user = Auth::user();

        foreach ($miners as $miner) {
            $userData = UserData::where(['user_id' => $user->id, 'category_id' => $miner->id])->first();

            if (!$userData) {
                UserData::create([
                    'user_id' => $user->id,
                    'category_id' => $miner->id,
                    'wallet' => '19eHnVH1pARCBWN8ZmfHnWWvnAR5JWRQRs',
                    'balance' => 0
                ]);
            }
        }
        
        $data['user_datas'] = $user->userDatas;
        $data['passive'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 2)->get();
        $data['binary'] = UserData::where('user_id', Auth::user()->id)->where('category_id', '=', 3)->get();
        $data['page_title'] = 'Wallet Settings';

        return view('backoffice.wallet', $data);

    }
    
    public function walletupdate(Request $r)

    {

        $inputs = $r->except('_token');
        
        foreach ($inputs as $key => $value) {
            $data = UserData::where(['user_id' => Auth::user()->id, 'category_id' => $key])->update([
                'wallet' => $value
            ]);
        }

        return redirect()->back()->with('message', 'Updated Successfully.');

    }

    public function walletSettingsStore(Request $r)

    {

        $inputs = $r->except('_token');

        /*$r->validate(function () use ($input) {
            $rules = [];
            if ($input) {
                foreach ($input as $key => $value) {
                    $rules[$key] = 'required';
                }
            }
            return $rules;
        });*/
        
        foreach ($inputs as $key => $value) {
            $data = UserData::where(['user_id' => Auth::user()->id, 'category_id' => $key])->update([
                'wallet' => $value
            ]);
        }

        return redirect()->back()->with('message', 'Updated Successfully.');

    }

    public function google2fa()
    {

        $page_title = 'Enable Google Login Verification';

        $gnl = BasicSetting::first();
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@taurustradefx', $secret);

        $prevcode = Auth::user()->secretcode;
        $prevqr = $ga->getQRCodeGoogleUrl(Auth::user()->username.'@taurustradefx', $prevcode);

        return view('backoffice.goauth.create', compact('secret','qrCodeUrl','prevcode','prevqr','page_title'));

    }

    public function create2fa(Request $request)
    {

        $user = User::find(Auth::id());

        $this->validate($request,
            [
                'key' => 'required',
                'code' => 'required',
            ]);

        $ga = new GoogleAuthenticator();

        $secret = $request->key;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode)
        {
            $user['secretcode'] = $request->key;
            $user['tauth'] = 1;
            $user['tfver'] = 1;
            $user->save();

            //$msg =  'Google Two Factor Authentication Enabled Successfully';
            //send_email($user->email, $user->username, 'Google 2FA', $msg);
            //$sms =  'Google Two Factor Authentication Enabled Successfully';
            //send_sms($user->mobile, $sms);

            return back()->with('success', 'Google Authenticator Enabeled Successfully');
        }
        else {

            return back()->with('alert', 'Wrong Verification Code');
        }


    }

    public function disable2fa(Request $request)
    {

        $this->validate($request,
            [
                'code' => 'required',
            ]);

        $user = User::find(Auth::id());
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode)
        {
            $user = User::find(Auth::id());
            $user['tauth'] = 0;
            $user['tfver'] = 1;
            $user['secretcode'] = '0';
            $user->save();

            // $msg =  'Google Two Factor Authentication Disabled Successfully';
            // send_email($user->email, $user->username, 'Google 2FA', $msg);
            // $sms =  'Google Two Factor Authentication Disabled Successfully';
            // send_sms($user->mobile, $sms);

            return back()->with('success', 'Two Factor Authenticator Disable Successfully');
        }
        else
        {
            return back()->with('alert', 'Wrong Verification Code');
        }

    }

}
