<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use App\Category;
use App\Plan;
use App\PlanLog;
use App\PackagesLog;
use App\Packages;
use App\Trx;
use App\User;
use App\TraitsFolder\MailTrait;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    use MailTrait;
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()

    {

        $data['page_title'] = 'All Pricing Plan';
        $data['plans'] = Plan::all();

        return view('dashboard.planindex', $data);

    }

    public function addNew()

    {

        $data['page_title'] = 'Add New Plan';
        $data['categories'] = Category::all();

        return view('dashboard.planaddnew', $data);

    }

    public function store(Request $r)

    {

        $r->validate([
            'title' => 'required',
            'description' => 'required',
            'features' => 'required',
            'price' => 'required',
            'period' => 'required|numeric',
            'ptyp' => 'required',
            'speed' => 'required',
            'return' => 'required',
            'category_id' => 'required|numeric'
        ]);

        $input = [
            'title' => $r->post('title'),
            'description' => $r->post('description'),
            'features' => is_array($r->post('features'))?serialize($r->post('features')):$r->post('features'),
            'price' => $r->post('price'),
            'period' => $r->period,
            'ptyp' => $r->ptyp,
            'speed' => $r->post('speed'),
            'return' => $r->post('return'),
            'category_id' => $r->post('category_id')
        ];

        $input['status'] = $r->post('status') == 'on' ? '1' : '0';

        $plan = Plan::create($input);

        if ($plan) {
            return redirect()->back()->with('message', 'Plan Added Successfully.');
        }

        return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

    }

    public function edit($id)

    {

        $plan = Plan::find($id);

        if (!$plan) return redirect()->back();

        $data['page_title'] = 'Edit - ' . $plan->title;
        $data['plan'] = $plan;
        $data['categories'] = Category::all();
        $data['features'] = unserialize($plan->features);

        return view('dashboard.planedit', $data);

    }

    public function update($id, Request $r)

    {

        $plan = Plan::find($id);

        if (!$plan) return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

        $r->validate([
            'title' => 'required',
            'features' => 'required',
            'price' => 'required',
        ]);

        $plan->title = $r->post('title');
        $plan->features = is_array($r->post('features'))?serialize($r->post('features')):$r->post('features');
        $plan->price = $r->post('price');
        $plan->status = $r->post('status') == 'on' ? '1' : '0';

        $plan->save();

        return redirect()->back()->with('message', 'Plan Updated Successfully.');

    }

    public function delete($id)

    {

        $plan = Plan::find($id);

        if ($plan) {
            $plan->delete();
            return redirect()->back()->with('message', 'Plan Deleted Successfully.');
        }

        return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

    }

    public function newRequest()

    {

        $data['logs'] = PackagesLog::where('status', 1)->orderby("id","desc")->get();
        $data['page_title'] = 'Active Packages';

        return view('dashboard.plan-request', $data);

    }

    public function approve($id)

    {

        $log = PlanLog::find($id);
        $basic = BasicSetting::first();
        if ($log) {
            $user = $log->user;
            if ($log->status == 0) {
                $log->status = 1;
                $log->save();

                Trx::where('track', $log->id)->update([
                    'status' => 'approved'
                ]);

                $trx = Trx::where('track', $log->id)->first();

                if ($basic->email_notify == 1){
                    $text = "Plan Purchased Request Approved." . "<br> Transaction ID Is : <b>#$trx->trxid</b>";
                    $this->sendMail($user->email, $user->name, 'Purchased Requested Approved.', $text);
                }
                if ($basic->phone_notify == 1){
                    $text = "Plan Purchased Request Approved".". <br> Transaction ID Is : <b>#$trx->trxid</b>";
                    $this->sendSms($user->phone, $text);
                }

                session()->flash('success', 'Request Approved Successfully.');
                session()->flash('type', 'success');
                session()->flash('title','Success');

                return redirect()->back();
            }
        }

        session()->flash('alert', 'You Already Take Action.');
        session()->flash('type', 'warning');
        session()->flash('title','Opps');

        return redirect()->back();

    }

    public function refund($id, Request $r)

    {

        $log = PlanLog::find($id);
        $basic = BasicSetting::first();

        if ($log) {
            if ($log->status == 0) {
                $plan = $log->plan;
                $user = $log->user;

                // update
                $log->status = 2;
                $log->save();

                $user->balance = $user->balance + $plan->price;
                $user->save();

                $trx = Trx::where(['track' => $log->id, 'type' => 'PlanLog'])->first();
                //return $trx;
                Trx::create([
                    'track' => $log->id,
                    'sender' => $basic->title,
                    'receiver' => $user->id,
                    'gross_amount' => $trx->gross_amount,
                    'charge' => $trx->charge,
                    'net_amount' => $trx->net_amount,
                    'type' => 'PlanLog',
                    'description' => 'Refunded Plan Request.',
                    'trxid' => $trx->trxid,
                    'custom' => isset($r->msg)?$r->msg:'',
                    'status' => 'refunded'
                ]);

                if ($basic->email_notify == 1){
                    $text = "Plan Purchased Request Refunded." . "<br> Transaction ID Is : <b>#$trx->trxid</b>";
                    $this->sendMail($user->email, $user->name, 'Purchased Requested Refunded.', $text);
                }
                if ($basic->phone_notify == 1){
                    $text = "Plan Purchased Request Refunded".". <br> Transaction ID Is : <b>#$trx->trxid</b>";
                    $this->sendSms($user->phone, $text);
                }

                session()->flash('success', 'Refunded Successfully.');
                session()->flash('type', 'success');
                session()->flash('title','Success');

                return redirect()->back();
            }
        }

        session()->flash('alert', 'You Already Take Action.');
        session()->flash('type', 'warning');
        session()->flash('title','Opps');

        return redirect()->back();

    }

    public function showLogs()

    {

        $data['logs'] = PackagesLog::orderby("id","desc")->get();
        $data['page_title'] = 'All Packages';

        return view('dashboard.plan-logs', $data);

    }

    public function showLogsUser($id)

    {

        $data['logs'] = PackagesLog::where('user_id', $id)->get();
        $user = User::findOrFail($id);
        $data['page_title'] = 'Purchased By ' . $user->name;

        return view('dashboard.plan-logs', $data);

    }
}
