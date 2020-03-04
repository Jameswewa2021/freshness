<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\Bonus;
use App\BinaryLog;
use App\Category;
use App\Feature;
use App\Deposit;
use App\DetailLogs;
use App\Faqs;
use App\Investment;
use App\InvestmentPlans;
use App\Menu;
use App\Partner;
use App\PaymentLog;
use App\PaymentMethod;
use App\PackagesLog;
use App\Packages;
use App\Plan;
use App\PlanLog;
use App\Procedure;
use App\Referrals;
use App\ReferralDetails;
use App\ReturnLog;
use App\RepeatLog;
use App\Service;
use App\Slider;
use App\Testimonial;
use App\TraitsFolder\MailTrait;
use App\Trx;
use App\User;
use App\UserData;
use App\UserLog;
use App\WithdrawLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use App\Lib\coinPayments;
use App\Lib\GoogleAuthenticator;
use Auth;

class HomeController extends Controller
{
    use MailTrait;
    public function gggetHome()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "Home Page";
        $data['plan'] = Plan::whereStatus(1)->get();
        $data['slider'] = Slider::all();
        $data['service'] = Service::take(8)->get();
        $data['total_repeat'] = RepeatLog::sum('amount');
        $data['total_user'] = User::all()->count();
        $data['total_deposit'] = Deposit::whereNotIn('status',[0])->sum('amount');
        $data['total_withdraw'] = WithdrawLog::whereStatus(2)->sum('amount');
        $data['top_investor'] = DB::table('investments')
            ->select('amount','user_id', DB::raw('SUM(amount) as total_invest'))
            ->groupBy('amount','user_id')
            ->orderBy('total_invest','desc')
            ->take(8)
            ->get();
        $data['testimonial'] = Testimonial::orderBy('id','desc')->get();
        $data['latest_deposit'] = Deposit::whereStatus(1)->orderBy('id','desc')->take(6)->get();
        $data['latest_withdraw'] = WithdrawLog::whereStatus(2)->orderBy('id','desc')->take(6)->get();
        $data['payment'] = PaymentMethod::take(4)->get();
        return view('home.home',$data);
    }

    public function getHome()
    {
        $data['basic_setting'] = BasicSetting::first();
        $data['page_title'] = "Home Page";
        $data['features'] = Feature::all();
        $data['slider_text'] = Slider::all()->first();
        $data['partners'] = Partner::all();
        $data['service'] = Service::take(8)->get();
        $data['total_plan'] = Plan::count();
        $data['total_user'] = User::all()->count();
        $data['total_deposit'] = Deposit::whereNotIn('status',[0])->sum('amount');
        $data['total_withdraw'] = WithdrawLog::whereStatus(2)->sum('amount');
        $data['top_investor'] = DB::table('investments')
            ->select('amount','user_id', DB::raw('SUM(amount) as total_invest'))
            ->groupBy('amount','user_id')
            ->orderBy('total_invest','desc')
            ->take(8)
            ->get();
        $data['testimonial'] = Testimonial::orderBy('id','desc')->get();
        $data['latest_deposit'] = Deposit::whereStatus(1)->orderBy('id','desc')->take(6)->get();
        $data['latest_withdraw'] = WithdrawLog::whereStatus(2)->orderBy('id','desc')->take(6)->get();
        $data['payment'] = PaymentMethod::all();
        $plans = [];
        $categories = Category::all();
        if ($categories) {
            foreach ($categories as $category) {
                $p = Plan::where(['category_id' => $category->id, 'status' => 1])->orderBy('price', 'ASC')->first();
                if ($p) {
                    $p->miner = $category->name;
                    $plans[$category->id] = $p;
                }
            }
        }
        $data['plan'] = $plans;
        return view('newhome.home',$data);
    }

    public function menu($id,$name)
    {
        $data['menu1'] = Menu::findOrFail($id);
        $data['page_title'] = $data['menu1']->name;
        return view('newhome.menu',$data);
    }
    public function getAbout()
    {
        $data['page_title'] = 'About Page';
        return view('newhome.about',$data);
    }

    public function term_of_use()

    {

        $data['page_title'] = 'Term Of Use';
        return view('newhome.term_of_use',$data);

    }

    public function privacy_policy()

    {

        $data['page_title'] = 'Privacy Policy';
        return view('newhome.privacy_policy',$data);

    }

    public function howWorks()

    {

        $data['page_title'] = 'How It Works?';
        $data['steps'] = Procedure::all();

        return view('newhome.howworks', $data);

    }
    public function getFaqs()
    {
        $data['page_title'] = 'FAQS Page';
        $data['faqs'] = Faqs::orderBy('id','desc')->paginate(10);
        return view('newhome.faqs',$data);
    }
    public function getContact()
    {
        $data['page_title'] = 'Contact Page';
        return view('newhome.contact',$data);
    }
    public function submitContact(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'email' => 'required',
           'message' => 'required',
        ]);
        $request->subject = isset($request->subject)?$request->subject:'New Contact Request';
        $request->phone = isset($request->phone)?$request->phone:'';
        $this->sendContact($request->email,$request->name,$request->subject,$request->message,$request->phone);
        session()->flash('message','Contact Message Successfully Send.');
        return redirect()->back();
    }
    public function paypalIpn()
    {
        $payment_type		=	$_POST['payment_type'];
        $payment_date		=	$_POST['payment_date'];
        $payment_status		=	$_POST['payment_status'];
        $address_status		=	$_POST['address_status'];
        $payer_status		=	$_POST['payer_status'];
        $first_name			=	$_POST['first_name'];
        $last_name			=	$_POST['last_name'];
        $payer_email		=	$_POST['payer_email'];
        $payer_id			=	$_POST['payer_id'];
        $address_country	=	$_POST['address_country'];
        $address_country_code	= $_POST['address_country_code'];
        $address_zip		=	$_POST['address_zip'];
        $address_state		=	$_POST['address_state'];
        $address_city		=	$_POST['address_city'];
        $address_street		=	$_POST['address_street'];
        $business			=	$_POST['business'];
        $receiver_email		=	$_POST['receiver_email'];
        $receiver_id		=	$_POST['receiver_id'];
        $residence_country	=	$_POST['residence_country'];
        $item_name			=	$_POST['item_name'];
        $item_number		=	$_POST['item_number'];
        $quantity			=	$_POST['quantity'];
        $shipping			=	$_POST['shipping'];
        $tax				=	$_POST['tax'];
        $mc_currency		=	$_POST['mc_currency'];
        $mc_fee				=	$_POST['mc_fee'];
        $mc_gross			=	$_POST['mc_gross'];
        $mc_gross_1			=	$_POST['mc_gross_1'];
        $txn_id				=	$_POST['txn_id'];
        $notify_version		=	$_POST['notify_version'];
        $custom				=	$_POST['custom'];

        $ip = gethostbyaddr($_SERVER['REMOTE_ADDR']);

        $paypal = PaymentMethod::whereId(1)->first();

        $paypal_email = $paypal->val1;

        if($payer_status=="verified" && $payment_status=="Completed" && $receiver_email==$paypal_email && $ip=="notify.paypal.com"){

            $data = PaymentLog::where('custom' , $custom)->first();

            $totalamo = $data->usd;

            if($totalamo == $mc_gross)
            {
                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 1;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['transaction_id'] = $data->custom;
                $de['status'] = 1;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);

                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Paypal Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                session()->flash('message','Deposit Successfully Complete.');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
            }
        }
    }
    public function perfectIPN()
    {
        $pay = PaymentMethod::whereId(2)->first();
        $passphrase=strtoupper(md5($pay->val2));

        define('ALTERNATE_PHRASE_HASH',  $passphrase);
        define('PATH_TO_LOG',  '/somewhere/out/of/document_root/');
        $string=
            $_POST['PAYMENT_ID'].':'.$_POST['PAYEE_ACCOUNT'].':'.
            $_POST['PAYMENT_AMOUNT'].':'.$_POST['PAYMENT_UNITS'].':'.
            $_POST['PAYMENT_BATCH_NUM'].':'.
            $_POST['PAYER_ACCOUNT'].':'.ALTERNATE_PHRASE_HASH.':'.
            $_POST['TIMESTAMPGMT'];

        $hash=strtoupper(md5($string));
        $hash2 = $_POST['V2_HASH'];

        if($hash==$hash2){

            $amo = $_POST['PAYMENT_AMOUNT'];
            $unit = $_POST['PAYMENT_UNITS'];
            $custom = $_POST['PAYMENT_ID'];


            $data = PaymentLog::where('custom' , $custom)->first();

            if($_POST['PAYEE_ACCOUNT']=="$pay->val1" && $unit=="USD" && $amo == $data->usd && $data->status == "0"){

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 2;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);


                $mem->balance = $mem->balance + ($data->amount);
                $mem->dstar = 0;
                $mem->save();

                $parent = User::where(["id"=>2])->get();

                $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (Blockchain) Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                $this->sendMail($parent[0]->email,$parent[0]->name,'Deposit Completed.',$text);

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Perfect Money Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                
                $data['user'] = $mem;  

                //package assignment in deposit

                $deposit = DB::table('deposits')->where('user_id', "=" , $data['user']->id)->orderBy('created_at', 'desc')->get();
                if (count($deposit) >= 1)
                {
                    $package = Packages::where(["amount"=>$deposit[0]->amount])->get();
   
                        $pk['user_id'] = $data['user']->id;
                        $pk['package_id'] = $package[0]->pid;
                        $pk['r_wait'] = 7;
                        $pk['r_week'] = $package[0]->period;
                        $pk['status'] = 1;

                        $log = PackagesLog::create($pk);

                        $rlimit = $data['user']->r_limit += $package[0]->limit;
                        $depos = $data['user']->deposits = count($deposit);
                        DB::table('users')
                                ->where("id","=",$data['user']->id)
                                ->update(['r_limit' => $rlimit,'deposits' => $depos,'is_invest' => 1]);

                        //release direct to reference
                        $user = new User();
                        $user = $user->where("id","=",$data['user']->refid)->get();
                        if(count($user) > 0)
                        {
                            $direct = $user[0]->direct = $user[0]->direct + $package[0]->direct_bonus;

                            DB::table('users')
                                ->where("id","=",$user[0]->id)
                                ->update(['direct' => $direct]);
                                
                            $dl['user_id'] = $user[0]->id;
                            $dl['name'] = $user[0]->name;
                            $dl['type'] = "Direct";
                            $dl['amount'] = $package[0]->direct_bonus;

                            $log = DetailLogs::create($dl);
                        }
                        $pointleft=0;
                        $pointright=0;
                        $user1 = User::where('id', '=', $data['user']->id)->get();
                        $pos = $user1[0]->position;
                        $id = $user1[0]->posid;
                        while ($id != 0) {
                            $p = User::where("id","=",$id)->get();            
                            //Point Release
                            $rd = new ReferralDetails();
                            $rd->referral_id = $p[0]->id;
                            $rd->refree_id = $user1[0]->id;
                            $rd->refree_points = $package[0]->points;
                            $rd->position = $pos;
                            $rd->is_counted = "0";
                            $rd->reinvest = "0";
                            $rd->save();
                            $pos=$p[0]->position;
                
                            //Point Update 
                            $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                            if (count($referral) > 0) {

                               } else {
                                   $referral = new Referrals();
                                   $referral->user_id = $p[0]->id;
                                   $referral->referral_left = 0;
                                   $referral->referral_right = 0;
                                   $referral->point_left = 0;
                                   $referral->point_right = 0;
                                   $referral->binary_active = 0;
                                   $referral->save();
                               }
                            $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                            $pointleft = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Left")->sum('refree_points');
                            $pointright = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Right")->sum('refree_points');
                            
                            if($pointleft > 0)
                                {
                                   $referral[0]->point_left += $pointleft;
                                    DB::table('referrals')
                                        ->where("user_id","=",$p[0]->id)
                                        ->update(['point_left' => $referral[0]->point_left]);

                                    DB::table('referral_details')
                                        ->where("referral_id","=",$p[0]->id)
                                        ->where("refree_id","=",$user1[0]->id)
                                        ->where("is_counted","=",0)
                                        ->where("position","=","Left")
                                        ->update(['is_counted' => 1]);
                                }   
                            if($pointright > 0)
                                {
                                    $referral[0]->point_right += $pointright;
                                    DB::table('referrals')
                                        ->where("user_id","=",$p[0]->id)
                                        ->update(['point_right' => $referral[0]->point_right]);

                                    DB::table('referral_details')
                                        ->where("referral_id","=",$p[0]->id)
                                        ->where("refree_id","=",$user1[0]->id)
                                        ->where("is_counted","=",0)
                                        ->where("position","=","Right")
                                        ->update(['is_counted' => 1]);
                                }   
                         $id = $p[0]->posid;
                        }
                 $user1[0]->is_invest = 0;
                 $user1[0]->save();
                }
                return redirect()->route('refercount');

            }else{
                session()->flash('message', 'Something error....');
                Session::flash('type', 'warning');
                return redirect()->route('deposit-fund');
            }
        }
    }

    public function skrillIPN()

    {

        $skrill = PaymentMethod::whereId(6)->first();

        $concatFields = $_POST['merchant_id']
            .$_POST['transaction_id']
            .strtoupper(md5($skrill->val2))
            .$_POST['mb_amount']
            .$_POST['mb_currency']
            .$_POST['status'];

        if (strtoupper(md5($concatFields)) == $_POST['md5sig'] && $_POST['status'] == 2 && $_POST['pay_to_email'] == $skrill->val1) {

            $amo = $_POST['mb_amount'];
            $unit = $_POST['mb_currency'];
            $depoistTrack = $_POST['transaction_id'];

            //$DepositData = $db->query("SELECT usid, method, amount, charge, amountus, status FROM deposit_data WHERE track='".$depoistTrack."'")->fetch();
            $DepositData = PaymentLog::where('custom' , $depoistTrack)->first();

            if ($unit=="USD" && $amo ==$DepositData->usd) {

                $basic = BasicSetting::first();
                $mem = User::findOrFail($DepositData->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $DepositData->amount;
                $de['payment_type'] = 6;
                $de['charge'] = $DepositData->charge;
                $de['rate'] = $DepositData->payment->rate;
                $de['net_amount'] = $DepositData->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $DepositData->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $DepositData->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $DepositData->net_amount,
                    'charge' => $DepositData->charge,
                    'net_amount' => $DepositData->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $DepositData->payment->name,
                    'trxid' => $DepositData->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);


                $mem->balance = $mem->balance + ($DepositData->amount);
                $mem->save();

                if ($basic->email_notify == 1){
                    $text = $DepositData->amount." - ". $basic->currency ." Deposit via Skrill Successfully Completed. <br> Transaction ID Is : <b>#".$DepositData->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $DepositData->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$DepositData->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }

                $DepositData->status = 1;
                $DepositData->save();

            }

        }

    }

    public function btcPreview(Request $request)
    {
        $data['amount'] = $request->amount;
        $data['custom'] = $request->custom;
        //$pay = PaymentMethod::whereId(3)->first();
        $tran = PaymentLog::whereCustom($data['custom'])->first();

        $blockchain_root = "https://blockchain.info/";
        $blockchain_receive_root = "https://api.blockchain.info/";
        $mysite_root = url('/');
        $secret = "REDBITBTC";
        $my_xpub = "xpub6CsvKAdL24YYXadKiohfAKuEP7Ke782tfmi4nxQTxkm7E2agHMWzsuqNwUzhYoatFcowRDfiXPhzY3dfh9S8banXJaNT6qfmXWpfZyAMH98";
        $my_api_key = "6f76ba6a-df57-408e-8a08-aff068f52ce0";
        $invoice_id = $tran->custom;
        $callback_url = route('btc_ipn',['invoice_id'=>$invoice_id,'secret'=>$secret]);

        if ($tran->btc_acc == null){

            $url = $blockchain_receive_root . "v2/receive?key=" . $my_api_key . '&callback=' . urlencode($callback_url) . '&xpub=' . $my_xpub;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp = curl_exec($ch);
                
            $response = json_decode($resp);

            if (isset($response->address)) {
                $sendto = $response->address;
                $api = "https://blockchain.info/tobtc?currency=USD&value=".$tran->usd;
                $usd = file_get_contents($api);
                $tran->btc_amo = $usd;
                $tran->btc_acc = $sendto;
                $tran->save();
            } else {
                session()->flash('message', "Please try again later");
                Session::flash('type', 'warning');
                Session::flash('title', 'Opps!');
                return redirect()->route('plan.all');
            }
        }else{
            $usd = $tran->btc_amo;
            $sendto = $tran->btc_acc;
        }


        $var = "bitcoin:$sendto?amount=$usd";
        $data['code'] =  "<img src=\"https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=$var&choe=UTF-8\" title=''/>";

        $data['site_currency'] = "USD";
        $data['page_title'] = "BlockChain Deposit Preview";
        $data['paypal'] = PaymentMethod::whereId(1)->first();
        $data['perfect'] = PaymentMethod::whereId(2)->first();
        $data['btc'] = PaymentMethod::whereId(3)->first();
        $data['stripe'] = PaymentMethod::whereId(4)->first();
        $data['amount'] = $request->amount;
        $data['payment_type'] = $tran->payemnt_type;
        $data['fund'] = $tran;
        $data['usd'] = $usd;
        $data['add'] = $sendto;
        return view('backoffice.btc-preview',$data);
    }
    public function btcIPN(){

        $depoistTrack = $_GET['invoice_id'];
        $address = $_GET['address'];
        $value = $_GET['value'];
        $confirmations = $_GET['confirmations'];
        $value_in_btc = $_GET['value'] / 100000000;

        $trx_hash = $_GET['transaction_hash'];

        $data = PaymentLog::whereCustom($depoistTrack)->first();
        $value1 = $data->btc_amo - 0.001;
        if($data->status == 0){

            if ($value1 < $value_in_btc && $data->btc_acc == $address && $confirmations>0){

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 3;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);
                $mem->dstar = 0; 
                $mem->save();

                $parent = User::where(["id"=>2])->get();

                $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (Blockchain) Successfully Completed.";
                $this->sendMail($parent[0]->email,$parent[0]->name,'Deposit Completed.',$text);

                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (Blockchain) Successfully Completed.";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed.";
                    $this->sendSms($mem->phone,$text);
                }

                $data->status = 1;
                $data->save();
                
                $data['user'] = $mem;  

                //package assignment and point release in deposit

                $deposit = DB::table('deposits')->where('user_id', "=" , $data['user']->id)->orderBy('created_at', 'desc')->get();
                if (count($deposit) >= 1)
                {
                    $package = Packages::where(["amount"=>$deposit[0]->amount])->get();

                        $pk['user_id'] = $data['user']->id;
                        $pk['package_id'] = $package[0]->pid;
                        $pk['r_wait'] = 0;
                        $pk['r_week'] = $package[0]->period;
                        $pk['status'] = 1;

                        $log = PackagesLog::create($pk);

                        $rlimit = $data['user']->r_limit += $package[0]->limit;
                        $depos = $data['user']->deposits = count($deposit);
                        DB::table('users')
                                ->where("id","=",$data['user']->id)
                                ->update(['r_limit' => $rlimit,'deposits' => $depos,'is_invest' => 1]);

                        //release direct to reference
                        $user = new User();
                        $user = $user->where("id","=",$data['user']->refid)->get();
                        if(count($user) > 0)
                        {
                            $direct = $user[0]->direct = $user[0]->direct + $package[0]->direct_bonus;

                            DB::table('users')
                                ->where("id","=",$user[0]->id)
                                ->update(['direct' => $direct]);

                            $dl['user_id'] = $user[0]->id;
                            $dl['name'] = $user[0]->name;
                            $dl['type'] = "Direct";
                            $dl['amount'] = $package[0]->direct_bonus;

                            $log = DetailLogs::create($dl);
                        }
                        $pointleft=0;
                        $pointright=0;
                        $user1 = User::where('id', '=', $data['user']->id)->get();
                        $pos = $user1[0]->position;
                        $id = $user1[0]->posid;
                        while ($id != 0) {
                            $p = User::where("id","=",$id)->get();            
                            //Point Release
                            $rd = new ReferralDetails();
                            $rd->referral_id = $p[0]->id;
                            $rd->refree_id = $user1[0]->id;
                            $rd->refree_points = $package[0]->points;
                            $rd->position = $pos;
                            $rd->is_counted = "0";
                            $rd->reinvest = "0";
                            $rd->save();
                            $pos=$p[0]->position;
                
                            //Point Update 
                            $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                            if (count($referral) > 0) {

                               } else {
                                   $referral = new Referrals();
                                   $referral->user_id = $p[0]->id;
                                   $referral->referral_left = 0;
                                   $referral->referral_right = 0;
                                   $referral->point_left = 0;
                                   $referral->point_right = 0;
                                   $referral->binary_active = 0;
                                   $referral->save();
                               }
                            $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                            $pointleft = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Left")->sum('refree_points');
                            $pointright = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Right")->sum('refree_points');
                            
                            if($pointleft > 0)
                                {
                                   $referral[0]->point_left += $pointleft;
                                    DB::table('referrals')
                                        ->where("user_id","=",$p[0]->id)
                                        ->update(['point_left' => $referral[0]->point_left]);

                                    DB::table('referral_details')
                                        ->where("referral_id","=",$p[0]->id)
                                        ->where("refree_id","=",$user1[0]->id)
                                        ->where("is_counted","=",0)
                                        ->where("position","=","Left")
                                        ->update(['is_counted' => 1]);
                                }   
                            if($pointright > 0)
                                {
                                    $referral[0]->point_right += $pointright;
                                    DB::table('referrals')
                                        ->where("user_id","=",$p[0]->id)
                                        ->update(['point_right' => $referral[0]->point_right]);

                                    DB::table('referral_details')
                                        ->where("referral_id","=",$p[0]->id)
                                        ->where("refree_id","=",$user1[0]->id)
                                        ->where("is_counted","=",0)
                                        ->where("position","=","Right")
                                        ->update(['is_counted' => 1]);
                                }   
                         $id = $p[0]->posid;
                        }
                 $user1[0]->is_invest = 0;
                 $user1[0]->save();
                }
                return redirect()->route('refercount');
            }
        }
    }
    public function stripePreview(Request $request)
    {
        $data['site_currency'] = "USD";
        $data['page_title'] = "Credit Card Deposit Preview";
        $data['paypal'] = PaymentMethod::whereId(1)->first();
        $data['perfect'] = PaymentMethod::whereId(2)->first();
        $data['btc'] = PaymentMethod::whereId(3)->first();
        $data['stripe'] = PaymentMethod::whereId(4)->first();



        $data['btc_coin'] = PaymentMethod::whereId(6)->first();
        $data['payment_type'] = 4;
        $data['amount'] = $request->amount;
        $data['custom'] = $request->custom;
        $data['fund'] = PaymentLog::whereCustom($request->custom)->first();
        return view('backoffice.stripe-preview',$data);
    }
    public function submitStripe(Request $request)
    {      
        $this->validate($request,[
            'amount' => 'required',
            'custom' => 'required',
            'cardNumber' => 'required|numeric',
            'cardExpiryMonth' => 'required|numeric',
            'cardExpiryYear' => 'required|numeric',
            'cardCVC' => 'required|numeric',
        ]);
        $data = PaymentLog::whereCustom($request->custom)->first();
        $amm = $data->usd;
        $cc = $request->cardNumber;
        $emo = $request->cardExpiryMonth;
        $eyr = $request->cardExpiryYear;
        $cvc = $request->cardCVC;
        $basic = PaymentMethod::whereId(4)->first();
        Stripe::setApiKey($basic->val1);
        try{
            $token = Token::create(array(
                "card" => array(
                    "number" => "$cc",
                    "exp_month" => $emo,
                    "exp_year" => $eyr,
                    "cvc" => "$cvc"
                )
            ));
            if (!isset($token['id'])) {
                session()->flash('message','The Stripe Token was not generated correctly');
                return Redirect::to($request->url);
            }

            $charge = Charge::create(array(
                'card' => $token['id'],
                'currency' => 'USD',
                'amount' => $data->usd * 100,
                'description' => 'item',
            ));
//dd($charge);
            if ($charge['status'] == 'succeeded' ) {

                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 4;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);

                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);

                $mem->balance = $mem->balance + ($data->amount);
                $mem->save();

                if ($basic->email_notify == 1){

                    $text = $data->amount." - ". $basic->currency ." Deposit via Credit Card Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);

                }

                if ($basic->phone_notify == 1){

                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);

                }

                $data->status = 1;
                $data->save();

                session()->flash('message','Card Successfully Charged.');
                session()->flash('title','Success');
                session()->flash('type','success');

                return redirect()->route('deposit-fund');

            }else{

                session()->flash('message','Something Is Wrong.');
                session()->flash('title','Opps..');
                session()->flash('type','warning');

                return redirect()->route('deposit-fund');

            }

        }catch (\Exception $e){
            echo $e->getLine();
            session()->flash('message',$e->getMessage());
            session()->flash('title','Opps..');
            session()->flash('type','warning');

            return redirect()->route('deposit-fund');
        }
    }

    public function btcCoinPreview(Request $request){

        $this->validate($request,
            [
                'amount' => 'required',
            ]);

        if ($request->amount <= 0) 
        {
            return redirect()->route('deposit-fund')->with('alert', 'Invalid Amount');
        }
        else
        {
            $payment = PaymentLog::findOrFail($request->fund_id);
            $method = PaymentMethod::whereId(5)->first();
        // You need to set a callback URL if you want the IPN to work
            $callbackUrl = route('ipn.coinPay');
            // $successUrl = route('suc.coinPay');
            // $cancelUrl = route('can.coinPay');
   
        // Create an instance of the class
            $CP = new coinPayments();

        // Set the merchant ID and secret key (can be found in account settings on CoinPayments.net)
            $CP->setMerchantId($method->val1);
            $CP->setSecretKey($method->val2);

           $data['page_title']  =  'CoinPyment Confirm';
           $data['bcoin']  =  $payment->btc_amo;
           $data['amon']   =  $payment->usd;
           $data['form']   = $CP->createPayment('Aurya Global Invest', 'BTC',  $payment->btc_amo, $payment->custom, $callbackUrl);


           return view('backoffice.btccoinconfirm', $data);
        }
    }
    // public function btcCoinIPNc(Request $request){

    //     // DB::table('users')
    //     //             ->where("id","=","1")
    //     //             ->update(['cancle' => 1]);
    //     // session()->flash('message','Successfully Deposit Completed Wait For Confirmation');
    //     // session()->flash('type','success');
    //     // session()->flash('title','Completed');
    //     // return redirect()->route('deposit-fund');
    // }
    // public function btcCoinIPNs(Request $request){
    //     $data['txid'] = $txn_id = $_POST['txn_id'];
        
    //     file_put_contents('resultssd.txt', serialize($data));
    //     // DB::table('users')
    //     //             ->where("id","=","1")
    //     //             ->update(['success' => 1]);
    //     // session()->flash('message','Successfully Deposit Completed Wait For Confirmation');
    //     // session()->flash('type','success');
    //     // session()->flash('title','Completed');
    //     // return redirect()->route('deposit-fund');
    
    // }
    public function btcCoinIPN(Request $request){

    // Fill these in with the information from your CoinPayments.net account. 
    
    $cp_merchant_id = '3e5af1b46b5c4b1e3e891172050ed0dd'; 
    $cp_ipn_secret = 'auryaglobalaliking'; 
    $cp_debug_email = 'auryaglobal@gmail.com'; 

    $status = intval($_POST['status']);
    $track = $_POST['custom'];
    
    //$data['txid'] = $txn_id = $_POST['txn_id']; 
    //$data['itemname'] = $item_name = $_POST['item_name']; 
    //$data['itemnumber'] = $item_number = $_POST['item_number']; 
    //$data['amount'] = $amount1 = floatval($_POST['amount1']); 
    //$data['amount2'] = $amount2 = floatval($_POST['amount2']); 
    //$data['currency1'] = $currency1 = $_POST['currency1']; 
    //$data['currency2'] = $currency2 = $_POST['currency2']; 
    //$data['status'] = $status = intval($_POST['status']); 
    //$data['status_text'] = $status_text = $_POST['status_text'];
    //$data['custom'] = $custom = $_POST['custom'];
   
    // file_put_contents('results.txt', serialize($data));
    
    $data = PaymentLog::where('custom', $track)->first();
        if ($data->status == '0') {
    
            if ($status>=100 || $status==2) {
    
                $basic = BasicSetting::first();
                $mem = User::findOrFail($data->member_id);
                $de['user_id'] = $mem->id;
                $de['amount'] = $data->amount;
                $de['payment_type'] = 3;
                $de['charge'] = $data->charge;
                $de['rate'] = $data->payment->rate;
                $de['net_amount'] = $data->net_amount;
                $de['status'] = 1;
                $de['transaction_id'] = $data->custom;
                Deposit::create($de);
    
                $trx = Trx::create([
                    'track' => $data->id,
                    'sender' => $mem->id,
                    'receiver' => $basic->title,
                    'gross_amount' => $data->net_amount,
                    'charge' => $data->charge,
                    'net_amount' => $data->amount,
                    'type' => 'PaymentLog',
                    'description' => 'Deposit Via ' . $data->payment->name,
                    'trxid' => $data->custom,
                    'custom' => '',
                    'status' => 'requested'
                ]);
    
                $mem->balance = $mem->balance + ($data->amount);
                $mem->is_invest = "1";
                $mem->save();
    
                if ($basic->email_notify == 1){
                    $text = $data->amount." - ". $basic->currency ." Deposit via Bitcoin - (CoinPyment) Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendMail($mem->email,$mem->name,'Deposit Completed.',$text);
                }
                if ($basic->phone_notify == 1){
                    $text = $data->amount." - ".$basic->currency ." Deposit Successfully Completed. <br> Transaction ID Is : <b>#".$data->custom."</b>";
                    $this->sendSms($mem->phone,$text);
                }
    
                $data->status = 1;
                $data->save();
                session()->flash('message','Successfully Deposit Completed Wait For Confirmation');
                session()->flash('type','success');
                session()->flash('title','Completed');
                return redirect()->route('deposit-fund');
                
    
            }

            return redirect()->route('deposit-fund');
        }


    }

    public function miner($id) {

        $category = Category::find($id);

        if ($category) {
            if ($category->plans) {
                $data['plans'] = $category->plans;
                $data['page_title'] = $category->name . ' Miner';
                return view('newhome.miner', $data);
            }
        }

        return redirect()->back();

    }
    public function unilevel(){

          // Uni Level cron
        $user = User::all();
        foreach ($user as $users)
        {
            if($users->dstar != 1){
                $mk = new PackagesLog();
                $active = $mk->where('user_id', $users->id)->where('status', 1)->where('star','!=', 1)->get();
                if (count($active)>0) {
                    $count = 0;
                    $points = 0;
                    $level1 = array();
                    $level2 = array();
                    $level3 = array();
                    $level4 = array();
                    $level5 = array();

                    $us = new User();
                    $res = $us->where('refid', '=', $users->id)->where('dstar','!=','1')->get();

                    foreach ($res as $val) {
                        $level1[$count] = $val->id;
                        $count++;
                    }

                    $count = 0;

                    foreach ($level1 as $val)
                    {
                        $us = new User();
                        $res = $us->where('refid', '=', $val)->where('dstar','!=','1')->get();

                        foreach ($res as $val1) {
                            $level2[$count] = $val1->id;
                            $count++;
                        }
                    }

                    $count = 0;

                    foreach ($level2 as $val)
                    {
                        $us = new User();
                        $res = $us->where('refid', '=', $val)->get();

                        foreach ($res as $val1) {
                            $level3[$count] = $val1->id;
                            $count++;
                        }
                    }

                    $count = 0;

                    foreach ($level3 as $val)
                    {
                        $us = new User();
                        $res = $us->where('refid', '=', $val)->where('dstar','!=','1')->get();

                        foreach ($res as $val1) {
                            $level4[$count] = $val1->id;
                            $count++;
                        }
                    }

                    $count = 0;

                    foreach ($level4 as $val)
                    {
                        $us = new User();
                        $res = $us->where('refid', '=', $val)->where('dstar','!=','1')->get();

                        foreach ($res as $val1) {
                            $level5[$count] = $val1->id;
                            $count++;
                        }
                    }

                    foreach ($level1 as $val)
                    {
                        $package_log = new PackagesLog();
                        $package_log = $package_log->where('user_id', $val)->where('status', 1)->get();

                        foreach ($package_log as $plog)
                        {
                            $package = new Packages();
                            $package = $package->where('pid', '=', $plog->package_id)->get();
                            if (count($package) > 0) {
                                $fee = $package[0]->maintenance_fee / 100 * 10;

                                $ud = new UserData();
                                $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
                                $ri[0]->balance += $fee;
                                DB::table('user_datas')
                                    ->where("user_id","=",$users->id)
                                    ->where("category_id","=","5")
                                    ->update(['balance' => $ri[0]->balance]);
                                $points += $fee;
                            }
                        }
                    }

                    foreach ($level2 as $val)
                    {
                        $package_log = new PackagesLog();
                        $package_log = $package_log->where('user_id', $val)->where('status', 1)->get();

                        foreach ($package_log as $plog)
                        {
                            $package = new Packages();
                            $package = $package->where('pid', '=', $plog->package_id)->get();
                            if (count($package) > 0) {
                                $fee = $package[0]->maintenance_fee / 100 * 7;

                                $ud = new UserData();
                                $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
                                $ri[0]->balance += $fee;
                                DB::table('user_datas')
                                    ->where("user_id","=",$users->id)
                                    ->where("category_id","=","5")
                                    ->update(['balance' => $ri[0]->balance]);
                                $points += $fee;
                            }
                        }
                    }

                    foreach ($level3 as $val)
                    {
                        $package_log = new PackagesLog();
                        $package_log = $package_log->where('user_id', $val)->where('status', 1)->get();

                        foreach ($package_log as $plog)
                        {
                            $package = new Packages();
                            $package = $package->where('pid', '=', $plog->package_id)->get();
                            if (count($package) > 0) {
                                $fee = $package[0]->maintenance_fee / 100 * 5;

                                $ud = new UserData();
                                $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
                                $ri[0]->balance += $fee;
                                DB::table('user_datas')
                                    ->where("user_id","=",$users->id)
                                    ->where("category_id","=","5")
                                    ->update(['balance' => $ri[0]->balance]);
                                $points += $fee;
                            }
                        }
                    }

                    foreach ($level4 as $val)
                    {
                        $package_log = new PackagesLog();
                        $package_log = $package_log->where('user_id', $val)->where('status', 1)->get();

                        foreach ($package_log as $plog)
                        {
                            $package = new Packages();
                            $package = $package->where('pid', '=', $plog->package_id)->get();
                            if (count($package) > 0) {
                                $fee = $package[0]->maintenance_fee / 100 * 3;

                                $ud = new UserData();
                                $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
                                $ri[0]->balance += $fee;
                                DB::table('user_datas')
                                    ->where("user_id","=",$users->id)
                                    ->where("category_id","=","5")
                                    ->update(['balance' => $ri[0]->balance]);
                                $points += $fee;
                            }
                        }
                    }

                    foreach ($level5 as $val)
                    {
                        $package_log = new PackagesLog();
                        $package_log = $package_log->where('user_id', $val)->where('status', 1)->get();

                        foreach ($package_log as $plog)
                        {
                            $package = new Packages();
                            $package = $package->where('pid', '=', $plog->package_id)->get();
                            if (count($package) > 0) {
                                $fee = $package[0]->maintenance_fee / 100 * 1;

                                $ud = new UserData();
                                $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
                                $ri[0]->balance += $fee;
                                DB::table('user_datas')
                                    ->where("user_id","=",$users->id)
                                    ->where("category_id","=","5")
                                    ->update(['balance' => $ri[0]->balance]);
                                $points += $fee;
                            }
                        }
                    }

                    if($points > 0)
                    {
                        $dl['user_id'] = $users->id;
                        $dl['name'] = $users->name;
                        $dl['type'] = "Residual Income";
                        $dl['amount'] = $points;

                        $log = BinaryLog::create($dl);
                    }
                }
            }
        }
    }
    public function pointUpdate()
    {
        //Create refrels recorde

       $user = User::all();


       foreach ($user as $users) {

           $referral = Referrals::where("user_id", "=", $users->id)->get();

           if (count($referral) > 0) {

           } else {
               $referral = new Referrals();
               $referral->user_id = $users->id;
               $referral->referral_left = 0;
               $referral->referral_right = 0;
               $referral->point_left = 0;
               $referral->point_right = 0;
               $referral->binary_active = 0;
               $referral->save();
           }
       }


        //Referral Left and right point counts and point release

        $user = User::all();

        // Left and right point create

        foreach ($user as $users) {

            $leftcount = 0;
            $pointleft = 0;
            $pointright = 0;
            $rightcount = 0;

            $referral = Referrals::where("user_id", "=", $users->id)->get();

            //left counts

            $res = $users->where('posid', '=', $users->id)->where('position', '=', "Left")->get();

            $arr = array();

            foreach ($res as $result) {

                $arr[$leftcount] = $result->id;
                $leftcount++;
            }

            $i = $leftcount - 1;

            while (count($arr) != 0) {
                $res = $users->where('posid', '=', $arr[$i])->get();
                $user = new User();
                $person = $user->where('id', '=', $arr[$i])->get();
                foreach ($person as $persons)
                {
                    $package_log = new PackagesLog();
                    $package_log = $package_log->where('user_id', $persons->id)->orderBy('created_at', 'desc')->get();
                    if(count($package_log) > 0)
                    {
                        $package = new Packages();
                        $package = $package->where('pid', '=', $package_log[0]->package_id)->get();
                        if(count($package) > 0 && $persons->is_invest == 1)
                        {
                            $rd = new ReferralDetails();
                            $rd->referral_id = $users->id;
                            $rd->refree_id = $persons->id;
                            $rd->refree_points = $package[0]->points;
                            $rd->position = "Left";
                            $rd->is_counted = "0";
                            $rd->reinvest = "0";
                            $rd->save();
                        }
                    }
                }

                $rds = new ReferralDetails();
                $pointleft = $rds->where("referral_id","=",$users->id)->where("is_counted","=",0)->where("position","=","Left")->sum('refree_points');

                if($pointleft > 0)
                {
                    $referral[0]->point_left += $pointleft;
                    DB::table('referrals')
                        ->where("user_id","=",$users->id)
                        ->update(['point_left' => $referral[0]->point_left]);
                    DB::table('referral_details')
                        ->where("referral_id","=",$users->id)
                        ->where("is_counted","=",0)
                        ->where("position","=","Left")
                        ->update(['is_counted' => 1]);
                }

                unset($arr[$i]);
                $i--;
                foreach ($res as $result) {
                    $i++;
                    $arr[$i] = $result->id;
                    $leftcount++;
                }
            }

            //right counts

            $res = $users->where('posid', '=', $users->id)->where('position', '=', "Right")->get();

            $arr = array();

            foreach ($res as $result) {
                $arr[$rightcount] = $result->id;
                $rightcount++;
            }

            $i = $rightcount - 1;

            while (count($arr) != 0) {
                $res = $users->where('posid', '=', $arr[$i])->get();
                $user = new User();
                $person = $user->where('id', '=', $arr[$i])->get();
                foreach ($person as $persons)
                {
                    $package_log = new PackagesLog();
                    $package_log = $package_log->where('user_id', $persons->id)->orderBy('created_at', 'desc')->get();
                    if(count($package_log) > 0)
                    {
                        $package = new Packages();
                        $package = $package->where('pid', '=', $package_log[0]->package_id)->get();
                        if(count($package) > 0 && $persons->is_invest == 1)
                        {
                            $rd = new ReferralDetails();
                            $rd->referral_id = $users->id;
                            $rd->refree_id = $persons->id;
                            $rd->refree_points = $package[0]->points;
                            $rd->position = "Right";
                            $rd->is_counted = "0";
                            $rd->reinvest = "0";
                            $rd->save();
                        }
                    }
                }


                $rds = new ReferralDetails();
                $pointright = $rds->where("referral_id","=",$users->id)->where("is_counted","=",0)->where("position","=","Right")->sum('refree_points');

                if($pointright > 0)
                {
                    $referral[0]->point_right += $pointright;
                    DB::table('referrals')
                        ->where("user_id","=",$users->id)
                        ->update(['point_right' => $referral[0]->point_right]);
                    DB::table('referral_details')
                        ->where("referral_id","=",$users->id)
                        ->where("is_counted","=",0)
                        ->where("position","=","Right")
                        ->update(['is_counted' => 1]);
                }


                unset($arr[$i]);
                $i--;
                foreach ($res as $result) {
                    $i++;
                    $arr[$i] = $result->id;
                    $rightcount++;
                }
            }

            DB::table('users')
                ->where("id","=",$users->id)
                ->update(['is_invest' => 0]);

            // update left and right count
            DB::table('referrals')
                ->where("user_id", "=", $users->id)
                ->update(['referral_right' => $rightcount, 'referral_left' => $leftcount]);

           
        }

    }
    public function refercount()
    {


        //Create refrels recorde

        $user = User::all();
       
        foreach ($user as $users) {

            $referral = Referrals::where("user_id", "=", $users->id)->get();

            if (count($referral) > 0) {

            }  else {
                $referral = new Referrals();
                $referral->user_id = $users->id;
                $referral->referral_left = 0;
                $referral->referral_right = 0;
                $referral->point_left = 0;
                $referral->point_right = 0;
                $referral->binary_active = 0;
                $referral->save();
            }
        }


        // User Count Update

        $user = User::all();

        // Left and right counts and binary active

        foreach ($user as $users) {
            
            $leftcount = 0;
            $rightcount = 0;

            $referral = Referrals::where("user_id", "=", $users->id)->get();

            //left counts

            $res = $users->where('posid', '=', $users->id)->where('position', '=', "Left")->get();
            $l = $users->where('refid', '=', $users->id)->where('position', '=', "Left")->where('r_limit', '>', 0)->where("dstar","!=","1")->get();
            $arr = array();

            foreach ($res as $result) {

                $arr[$leftcount] = $result->id;
                $leftcount++;
            }

            $i = $leftcount - 1;

            while (count($arr) != 0) {
                $res = $users->where('posid', '=', $arr[$i])->get();
                unset($arr[$i]);
                $i--;
                foreach ($res as $result) {
                    $i++;
                    $arr[$i] = $result->id;
                    $leftcount++;
                }
            }

            //right counts

            $res = $users->where('posid', '=', $users->id)->where('position', '=', "Right")->get();
            $r = $users->where('refid', '=', $users->id)->where('position', '=', "Right")->where('r_limit', '>', 0)->where("dstar","!=","1")->get();
            $arr = array();

            foreach ($res as $result) {
                $arr[$rightcount] = $result->id;
                $rightcount++;
            }

            $i = $rightcount - 1;

            while (count($arr) != 0) {
                $res = $users->where('posid', '=', $arr[$i])->get();

                unset($arr[$i]);
                $i--;
                foreach ($res as $result) {
                    $i++;
                    $arr[$i] = $result->id;
                    $rightcount++;
                }
            }
            
            if(count($r) > 0 && count($l) > 0){
                DB::table('referrals')
                ->where("user_id", "=", $users->id)
                ->update(['binary_active' => 1]);
            }

            //update left and right count
            DB::table('referrals')
                ->where("user_id", "=", $users->id)
                ->update(['referral_right' => $rightcount, 'referral_left' => $leftcount]);

        }

    }
    public function weeklyroi()
    {
        //Roi release weekly with logs cron job

        $users = User::all();
        foreach ($users as $user)
        {
                $package_log = new PackagesLog();
                $package_log = $package_log->where(['user_id'=> $user->id,'status'=> 1])->where('star','!=', 1)->orderBy('created_at', 'desc')->get();
                if(count($package_log) > 0)
                {
                    foreach ($package_log as $plog)
                    {
                        if($plog->r_wait == 0 && $plog->r_week != 0)
                        {
                            $package = new Packages();
                            $package = $package->where("pid","=",$plog->package_id)->get();

                            if (count($package) > 0)
                            {
                                if($user->r_limit >= $package[0]->roi)
                                {
                                    $plog->r_week = $plog->r_week - 1;
                                    $plog->save();
                                    $user->roi = $user->roi + $package[0]->roi;
                                    $user->r_limit = $user->r_limit - $package[0]->roi;
                                    $user->save();

                                    $rl['user_id'] = $user->id;
                                    $rl['name'] = $user->name;
                                    $rl['type'] = "Daily Return";
                                    $rl['amount'] = $package[0]->roi;

                                    $log = DetailLogs::create($rl);

                                }
                                else
                                {
                                    $user->roi = $user->roi + $package[0]->roi;
                                    $user->r_limit = 0;
                                    $user->save();

                                    $rl['user_id'] = $user->id;
                                    $rl['name'] = $user->name;
                                    $rl['type'] = "Daily Return";
                                    $rl['amount'] = $package[0]->roi;
                                    $log = DetailLogs::create($rl);
                                        
                                    DB::table('packages_log')
                                        ->where("id","=",$plog->id)
                                        ->update(['r_week' => 0,'status' => 0]);
                                }

                            }
                        }
                        elseif($plog->r_wait > 0)
                        {
                            $rr = $plog->r_wait - 1;
                            DB::table('packages_log')
                                        ->where("id","=",$plog->id)
                                        ->update(['r_wait' => $rr]);
                            
                        }elseif($plog->r_week == 0){
                            DB::table('packages_log')
                                        ->where("id","=",$plog->id)
                                        ->update(['status' => 0]);
                        }
                    }

                }else{
                     $package_log = new PackagesLog();
                     $package_log = $package_log->where(['user_id'=> $user->id,'status'=> 0])->orderBy('created_at', 'desc')->get();
                     if(count($package_log) > 0){
                         foreach ($package_log as $plog) {
                             DB::table('packages_log')
                                         ->where("id","=",$plog->id)
                                         ->update(['r_week' => 0]);
                        }

                    }
                }
        }
    }
    public function binarycut()

    {
        // points cut off if binary is activated according to the limit

        $users = User::all();
        foreach ($users as $user)
        {
            $referral = new Referrals();
            $referral = $referral->where("user_id","=",$user->id)->get();
            if($user->r_limit < 1){
               $user->r_limit = 0;
               $user->save();
            }

            if(count($referral) > 0) {
                if ($referral[0]->binary_active == 1 && $user->r_limit > 0) {
                    $cut = 0;
                    $left = 0;
                    $right = 0;
                    $point = 0;
                    if ($referral[0]->point_left > $referral[0]->point_right) {
                        if($referral[0]->point_right <= round($user->r_limit * 8.33))
                        {
                            $left = $referral[0]->point_left -= $referral[0]->point_right;
                            $right = 0;
                            $point = ($referral[0]->point_right * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }
                        else
                        {
                            $left = $referral[0]->point_left -= round($user->r_limit * 8.33);
                            $right = $referral[0]->point_right - round($user->r_limit * 8.33);
                            $point = (round($user->r_limit * 8.33) * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }

                    } else if ($referral[0]->point_left < $referral[0]->point_right) {
                        if($referral[0]->point_left <= round($user->r_limit * 8.33))
                        {
                            $right = $referral[0]->point_right -= $referral[0]->point_left;
                            $left = 0;
                            $point = ($referral[0]->point_left * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }
                        else
                        {
                            $right = $referral[0]->point_right -= round($user->r_limit * 8.33);
                            $left = $referral[0]->point_left -= round($user->r_limit * 8.33);
                            $point = (round($user->r_limit * 8.33) * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }

                    } else if ($referral[0]->point_left == $referral[0]->point_right) {
                        if($referral[0]->point_left <= round($user->r_limit * 8.33))
                        {
                            $right = 0;
                            $left = 0;
                            $point = ($referral[0]->point_left * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }
                        else
                        {
                            $right = $referral[0]->point_right -= round($user->r_limit * 8.33);
                            $left = $referral[0]->point_left -= round($user->r_limit * 8.33);
                            $point = (round($user->r_limit * 8.33) * 12) / 100;
                            if(($user->r_limit - $point) < 0)
                            {
                               $point = $user->r_limit;
                            }
                            $user->r_limit -= $point;
                            $user->network += $point;
                            $user->save();
                            $cut += $point;
                        }

                    }


                    DB::table('referrals')
                        ->where("user_id", "=", $user->id)
                        ->update(['point_left' => $left, 'point_right' => $right]);

                    if($cut > 0){
                        
                        $rl['user_id'] = $user->id;
                        $rl['name'] = $user->name;
                        $rl['type'] = "Binary";
                        $rl['amount'] = $cut;
    
                        $log = DetailLogs::create($rl);
                    }
                }
                else
                {
                    if($user->r_limit == 0)
                    {
                        $user->balance = 0;
                        $user->save();
                        DB::table('packages_log')
                            ->where("user_id","=",$user->id)
                            ->update(['r_week' => 0,'status' => 0]);
                    }
                }
            }
        }

    }
    public function maintenance()
    {
        // Maintenance fee Cut cron job for 1 and 15 of each month

        $users = User::all();
        foreach ($users as $user)
        {
            if($user->dstar != 1){
                $package_log = new PackagesLog();
                $package_log = $package_log->where('user_id', $user->id)->where('star','!=', 1)->orderBy('created_at', 'desc')->get();

                if(count($package_log) > 0)
                {
                    foreach ($package_log as $plog)
                    {
                        $ud = new UserData();
                        $wi = $ud->where("user_id","=",$user->id)->where("category_id","=","2")->get();
                        if(count($wi) > 0)
                        {
                            $package = new Packages();
                            $package = $package->where("pid","=",$plog->package_id)->get();

                            if(count($package) > 0 && $plog->status == 1)
                            {
                                $fee = $package[0]->maintenance_fee / 2;
                                $wi[0]->balance -= $fee;

                                if($wi[0]->balance < 0)
                                {

                                }
                                else
                                {
                                    DB::table('user_datas')
                                        ->where("user_id","=",$user->id)
                                        ->where("category_id","=","2")
                                        ->update(['balance' => $wi[0]->balance]);

                                    $dl['user_id'] = $user->id;
                                    $dl['name'] = $user->name;
                                    $dl['type'] = "Maintenance Fee";
                                    $dl['amount'] = $fee;

                                    $log = DetailLogs::create($dl);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    public function setpack($id){
            
            $mem = $id;
            $data['user'] = User::where("id","=",$mem)->get();  
        
        //package assignment and point release in deposit

            $deposit = DB::table('deposits')->where('user_id', "=" , $data['user'][0]->id)->orderBy('created_at', 'desc')->get();

            if (count($deposit) >= 1)
            {
                $package = Packages::where(["amount"=>$deposit[0]->amount])->get();

                    $pk['user_id'] = $data['user'][0]->id;
                    $pk['package_id'] = $package[0]->pid;
                    $pk['r_wait'] = 0;
                    $pk['r_week'] = $package[0]->period;
                    $pk['status'] = 1;

                    $log = PackagesLog::create($pk);

                    $rlimit = $data['user'][0]->r_limit += $package[0]->limit;
                    $depos = $data['user'][0]->deposits = count($deposit);
                    DB::table('users')
                            ->where("id","=",$data['user'][0]->id)
                            ->update(['r_limit' => $rlimit,'deposits' => $depos,'is_invest' => 1]);

                    //release direct to reference
                    $user = new User();
                    $user = $user->where("id","=",$data['user'][0]->refid)->get();
                    if(count($user) > 0)
                    {
                        $direct = $user[0]->direct = $user[0]->direct + $package[0]->direct_bonus;

                        DB::table('users')
                            ->where("id","=",$user[0]->id)
                            ->update(['direct' => $direct]);

                        $dl['user_id'] = $user[0]->id;
                        $dl['name'] = $user[0]->name;
                        $dl['type'] = "Direct";
                        $dl['amount'] = $package[0]->direct_bonus;

                        $log = DetailLogs::create($dl);
                    }
                    $pointleft=0;
                    $pointright=0;
                    $user1 = User::where('id', '=', $data['user'][0]->id)->get();
                    $pos = $user1[0]->position;
                    $id = $user1[0]->posid;
                    while ($id != 0) {
                        $p = User::where("id","=",$id)->get();            
                        //Point Release
                        $rd = new ReferralDetails();
                        $rd->referral_id = $p[0]->id;
                        $rd->refree_id = $user1[0]->id;
                        $rd->refree_points = $package[0]->points;
                        $rd->position = $pos;
                        $rd->is_counted = "0";
                        $rd->reinvest = "0";
                        $rd->save();
                        $pos=$p[0]->position;
            
                        //Point Update 
                        $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                        if (count($referral) > 0) {

                           } else {
                               $referral = new Referrals();
                               $referral->user_id = $p[0]->id;
                               $referral->referral_left = 0;
                               $referral->referral_right = 0;
                               $referral->point_left = 0;
                               $referral->point_right = 0;
                               $referral->binary_active = 0;
                               $referral->save();
                           }
                        $referral = Referrals::where("user_id", "=", $p[0]->id)->get();
                        $pointleft = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Left")->sum('refree_points');
                        $pointright = ReferralDetails::where("referral_id","=",$p[0]->id)->where("refree_id","=",$user1[0]->id)->where("is_counted","=",0)->where("position","=","Right")->sum('refree_points');
                        
                        if($pointleft > 0)
                            {
                               $referral[0]->point_left += $pointleft;
                                DB::table('referrals')
                                    ->where("user_id","=",$p[0]->id)
                                    ->update(['point_left' => $referral[0]->point_left]);

                                DB::table('referral_details')
                                    ->where("referral_id","=",$p[0]->id)
                                    ->where("refree_id","=",$user1[0]->id)
                                    ->where("is_counted","=",0)
                                    ->where("position","=","Left")
                                    ->update(['is_counted' => 1]);
                            }   
                        if($pointright > 0)
                            {
                                $referral[0]->point_right += $pointright;
                                DB::table('referrals')
                                    ->where("user_id","=",$p[0]->id)
                                    ->update(['point_right' => $referral[0]->point_right]);

                                DB::table('referral_details')
                                    ->where("referral_id","=",$p[0]->id)
                                    ->where("refree_id","=",$user1[0]->id)
                                    ->where("is_counted","=",0)
                                    ->where("position","=","Right")
                                    ->update(['is_counted' => 1]);
                            }   
                     $id = $p[0]->posid;
                    }
             $user1[0]->is_invest = 0;
             $user1[0]->save();
            }
            session()->flash('message', 'Package Set Successfully.');
            Session::flash('type', 'success');
            Session::flash('title', 'Success');
            return redirect()->back();
    }
    public function flush(){
        // weekly cron job for balances flush if limit reached
        $user = User::all();
        
        foreach ($user as $users) {

            $miners = Category::all();

            foreach ($miners as $miner) {
                $userData = UserData::where(['user_id' => $users->id, 'category_id' => $miner->id])->first();

                if (!$userData) {
                    UserData::create([
                        'user_id' => $users->id,
                        'category_id' => $miner->id,
                        'wallet' => '',
                        'balance' => 0
                    ]);
                }
            }

            if($users->r_limit < 1)
            {
                $referral = new Referrals();
                $referral = $referral->where("user_id","=",$users->id)->get();

                if($referral[0]->point_left > $referral[0]->point_right){

                    DB::table('referrals')
                        ->where("user_id", "=", $users->id)
                        ->update(['point_right' => 0]);

                }else{

                    DB::table('referrals')
                        ->where("user_id", "=", $users->id)
                        ->update(['point_left' => 0]);
                }
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","2")
                    ->update(['balance' => 0]);

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","3")
                    ->update(['balance' => 0]);

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => 0]);

                DB::table('packages_log')
                    ->where("user_id","=",$users->id)
                    ->update(['r_week' => 0,'status' => 0]);
                $users->balance = 0;
                $users->save();
                
            }
        }

    }
    public function cashwalletr(){
        // weekly cron job for balances
        $user = User::all();
        
        foreach ($user as $users) {

            $miners = Category::all();

            foreach ($miners as $miner) {
                $userData = UserData::where(['user_id' => $users->id, 'category_id' => $miner->id])->first();

                if (!$userData) {
                    UserData::create([
                        'user_id' => $users->id,
                        'category_id' => $miner->id,
                        'wallet' => '',
                        'balance' => 0
                    ]);
                }
            }
            $ud = new UserData();

            $wi = $ud->where("user_id","=",$users->id)->where("category_id","=","2")->get();
            $cw = $ud->where("user_id","=",$users->id)->where("category_id","=","6")->get();

            if($users->roi > 0)
            {
                $roi = $users->roi;
                
                $total =$roi;
                
                $users->total += $total;
                $users->save();

                // wallet update

                $wi[0]->balance += $roi;

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","2")
                    ->update(['balance' => $wi[0]->balance]);

                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['roi'=> 0]);
            }

            if($wi[0]->balance > 0)
            {

                $cw[0]->balance = $cw[0]->balance + $wi[0]->balance;
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","2")
                    ->update(['balance' => 0]);
                
                DB::table('user_datas')
                ->where("user_id","=",$users->id)
                ->where("category_id","=","6")
                ->update(['balance' => $cw[0]->balance]);
            }
        }

    }
    public function cashwalletb(){
        // weekly cron job for balances
        $user = User::all();
        
        foreach ($user as $users) {

            $miners = Category::all();

            foreach ($miners as $miner) {
                $userData = UserData::where(['user_id' => $users->id, 'category_id' => $miner->id])->first();

                if (!$userData) {
                    UserData::create([
                        'user_id' => $users->id,
                        'category_id' => $miner->id,
                        'wallet' => '',
                        'balance' => 0
                    ]);
                }
            }
            $ud = new UserData();

            $bi = $ud->where("user_id","=",$users->id)->where("category_id","=","3")->get();
            $cw = $ud->where("user_id","=",$users->id)->where("category_id","=","6")->get();

            if($users->network > 0)
            {
                $tp = $users->total_points;
                $binary = $users->network;
                
                $total = $binary;
                
                if($binary > 0)
                {
                    $tp = $tp + round($binary * 8.33);
                }
                $users->total_points = $tp;
                $users->total += $total;
                $users->save();

                // wallet update

                $bi[0]->balance += $binary;

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","3")
                    ->update(['balance' => $bi[0]->balance]);

                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['network' => 0]);
            }

            if($bi[0]->balance > 0)
            {

                $cw[0]->balance = $cw[0]->balance + $bi[0]->balance;
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","3")
                    ->update(['balance' => 0]);
                
                DB::table('user_datas')
                ->where("user_id","=",$users->id)
                ->where("category_id","=","6")
                ->update(['balance' => $cw[0]->balance]);
            }
        }

    }
    public function cashwalletd(){
        // weekly cron job for balances
        $user = User::all();
        
        foreach ($user as $users) {

            $miners = Category::all();

            foreach ($miners as $miner) {
                $userData = UserData::where(['user_id' => $users->id, 'category_id' => $miner->id])->first();

                if (!$userData) {
                    UserData::create([
                        'user_id' => $users->id,
                        'category_id' => $miner->id,
                        'wallet' => '',
                        'balance' => 0
                    ]);
                }
            }
            $ud = new UserData();

            $di = $ud->where("user_id","=",$users->id)->where("category_id","=","4")->get();
            $cw = $ud->where("user_id","=",$users->id)->where("category_id","=","6")->get();

            if($users->direct >0)
            {
                if($users->direct >= $users->r_limit)
                {
                   $direct = $users->r_limit;
                }else{
                   $direct = $users->direct; 
                }
                
                $total = $direct;
                
                $users->total += $total;
                $users->save();

                // wallet update
                
                $di[0]->balance += $direct;

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => $di[0]->balance]);

                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['direct'=>0]);
            }

            if($di[0]->balance > 0 && $users->r_limit > $di[0]->balance)
            {

                $cw[0]->balance = $cw[0]->balance + $di[0]->balance;
                
                $limit = $users->r_limit - $di[0]->balance;
                if($limit < 0)
                {
                    $limit = 0;

                }
                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['r_limit' => $limit]);

                if($limit == 0)
                {
                    DB::table('packages_log')
                        ->where("user_id","=",$users->id)
                        ->update(['r_week' => 0,'status' => 0]);
                }
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => 0]);
                
                DB::table('user_datas')
                ->where("user_id","=",$users->id)
                ->where("category_id","=","6")
                ->update(['balance' => $cw[0]->balance]);
            }elseif($di[0]->balance > 0 && $users->r_limit <= $di[0]->balance){
                
                $di[0]->balance = $di[0]->balance - $users->r_limit;                
                
                $cw[0]->balance = $cw[0]->balance + $users->r_limit;
                
                $limit = 0;

                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['r_limit' => $limit]);

                if($limit == 0)
                {
                    DB::table('packages_log')
                        ->where("user_id","=",$users->id)
                        ->update(['r_week' => 0,'status' => 0]);
                }
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => $di[0]->balance]);
                
                DB::table('user_datas')
                ->where("user_id","=",$users->id)
                ->where("category_id","=","6")
                ->update(['balance' => $cw[0]->balance]);
            }
        }

    }
    public function cashwalletu(){
        // weekly cron job for balances
        $user = User::all();
        
        foreach ($user as $users) {

            $miners = Category::all();

            foreach ($miners as $miner) {
                $userData = UserData::where(['user_id' => $users->id, 'category_id' => $miner->id])->first();

                if (!$userData) {
                    UserData::create([
                        'user_id' => $users->id,
                        'category_id' => $miner->id,
                        'wallet' => '',
                        'balance' => 0
                    ]);
                }
            }
            $ud = new UserData();

            $wi = $ud->where("user_id","=",$users->id)->where("category_id","=","2")->get();
            $bi = $ud->where("user_id","=",$users->id)->where("category_id","=","3")->get();
            $di = $ud->where("user_id","=",$users->id)->where("category_id","=","4")->get();
            $ri = $ud->where("user_id","=",$users->id)->where("category_id","=","5")->get();
            $cw = $ud->where("user_id","=",$users->id)->where("category_id","=","6")->get();

            if($users->roi > 0 || $users->network > 0 || $users->direct >0 || $users->residual >0)
            {
                $tp = $users->total_points;
                $binary = $users->network;
                $residual = $users->residual;
                $roi = $users->roi;
                $direct = $users->direct;
                $total = $binary + $residual + $roi + $direct;
                
                if($binary > 0)
                {
                    $tp = $tp + round($binary * 8.33);
                }
                $users->total_points = $tp;
                $users->total += $total;
                $users->save();

                // wallet update

                $bi[0]->balance += $binary;
                $wi[0]->balance += $roi;
                $di[0]->balance += $direct;
                $ri[0]->balance += $residual;

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","2")
                    ->update(['balance' => $wi[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","3")
                    ->update(['balance' => $bi[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","4")
                    ->update(['balance' => $di[0]->balance]);

                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","5")
                    ->update(['balance' => $ri[0]->balance]);

                DB::table('users')
                    ->where("id","=",$users->id)
                    ->update(['network' => 0,'direct'=>0,'roi'=> 0,'residual'=> 0]);
            }

            if($ri[0]->balance > 0)
            {

                $cw[0]->balance = $cw[0]->balance + $ri[0]->balance;
                
                DB::table('user_datas')
                    ->where("user_id","=",$users->id)
                    ->where("category_id","=","5")
                    ->update(['balance' => 0]);
                
                DB::table('user_datas')
                ->where("user_id","=",$users->id)
                ->where("category_id","=","6")
                ->update(['balance' => $cw[0]->balance]);
            }
        }

    }
    public function cronGenerate(){

    }
    public function emailall(){
        $user = User::all();
        
        foreach($user as $users){
           $text ="Welcome to Blue Forex Limited.";
           $this->sendMail($users->email,$users->name,'Welcome',$text); 
        }
        
    }
    public function authorization()
    {
            
        if(Auth::user()->tfver == '1')
        {
            return redirect()->route('user-dashboard');
        }
        else
        {

            $data['page_title'] = "Google App Verification";

            return view('auth.notauthor',$data);
        }
    }


    public function verify2fa( Request $request)
    {

        $user = User::find(Auth::id());

        $this->validate($request,
            [
                'code' => 'required',
            ]);
        $ga = new GoogleAuthenticator();

        $secret = $user->secretcode;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['tfver'] = 1;
            $user->save();
            $data['page_title'] = "User Dashboard";
            return redirect()->route('user-dashboard');
        } else {

            return back()->with('alert', 'Wrong Verification Code');
        }

    }

}
