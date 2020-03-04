<?php

namespace App\Console;

use App\User;
use DB;
use App\ReferralDetails;
use App\Referrals;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\CronJob',
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
         $schedule->call(function (){
             $data['user'] = new User();
             $data['user'] = $data['user']->select('*')->get();

             foreach ($data['user'] as $user) {

                 $leftcount = 0;
                 $pointleft = 0;
                 $pointright = 0;
                 $rightcount = 0;
                 $referral = new Referrals();
                 $referral = $referral->where("user_id", "=", $user->id)->get();

                 if (count($referral) > 0) {

                 } else {
                     $referral = new Referrals();
                     $referral->user_id = $user->id;
                     $referral->referral_left = 0;
                     $referral->referral_right = 0;
                     $referral->point_left = 0;
                     $referral->point_right = 0;
                     $referral->binary_active = 0;
                     $referral->save();
                 }

                 $referral = new Referrals();
                 $referral = $referral->where("user_id", "=", $user->id)->get();
                 if (count($referral) > 0) {
                     $rdetails = new ReferralDetails();
                     $rdetails = $rdetails->where("referral_id", "=", $referral[0]->referral_id)->where("is_counted", "=", 0)->where("position", "=", "Left")->get();

                     $users = new User();
                     $res = $users->where('posid', '=', $user->id)->where('position', '=', "Left")->get();
                     while (count($res) != 0) {
                         $leftcount++;
                         if (count($rdetails) > 0) {

                         } else {

                             $chk = new ReferralDetails();
                             $chk = $chk->where("referral_id", "=", $referral[0]->referral_id)->where("refree_id", "=", $res[0]->id)->where("is_counted", "=", 1)->where("position", "=", "Left")->get();
                             if (count($chk) > 0) {
                                 if ($res[0]->deposits > $chk[0]->reinvest) {

                                     $deposit = DB::table('deposits')->where('user_id', $res[0]->id)->orderBy('created_at', 'desc')->get();
                                     $rds = new ReferralDetails();
                                     $rds = $rds->where("referral_id", "=", $referral[0]->referral_id)->where("refree_id", "=", $res[0]->id)->where("is_counted", "=", 1)->where("position", "=", "Left")->get();
                                     $rdsamount = $rds[0]->refree_points + $deposit[0]->amount;
                                     DB::table('referral_details')
                                         ->where("referral_id", "=", $referral[0]->referral_id)
                                         ->where("refree_id", "=", $res[0]->id)
                                         ->where("is_counted", "=", 1)
                                         ->where("position", "=", "Left")
                                         ->update(['refree_points' => $rdsamount, 'reinvest' => $res[0]->deposits]);
                                     $ref = new Referrals();
                                     $pointleft = $ref->where("referral_id", "=", $referral[0]->referral_id)->get();
                                     $pointleft = $pointleft[0]->point_left + $deposit[0]->amount;
                                     DB::table('referrals')
                                         ->where("user_id", "=", $user->id)
                                         ->update(['point_left' => $pointleft]);

                                 }
                             } else {
                                 if ($res[0]->is_invest == 1) {
                                     $rd = new ReferralDetails();
                                     $rd->referral_id = $referral[0]->referral_id;
                                     $rd->refree_id = $res[0]->id;
                                     $rd->refree_points = $res[0]->balance;
                                     $rd->position = $res[0]->position;
                                     $rd->is_counted = "0";
                                     $rd->reinvest = "1";
                                     $rd->save();

                                     $rds = new ReferralDetails();
                                     $pointleft = $rds->where("referral_id", "=", $referral[0]->referral_id)->where("is_counted", "=", 0)->where("position", "=", "Left")->sum('refree_points');
                                     $pointleft += $referral[0]->point_left;

                                     DB::table('referrals')
                                         ->where("user_id", "=", $user->id)
                                         ->update(['referral_left' => $leftcount, 'point_left' => $pointleft]);
                                     DB::table('referral_details')
                                         ->where("is_counted", "=", 0)
                                         ->where("position", "=", "Left")
                                         ->update(['is_counted' => 1]);
                                 }

                             }

                         }


                         $user = new User();
                         $res = $user->where('posid', '=', $res[0]->id)->where('position', '=', "Left")->get();

                     }

                     $rdetail = new ReferralDetails();
                     $rdetail = $rdetail->where("referral_id", "=", $referral[0]->referral_id)->where("is_counted", "=", 0)->where("position", "=", "Right")->get();

                     $users = new User();
                     $res = $users->where('posid', '=', $user->id)->where('position', '=', "Right")->get();

                     while (count($res) != 0) {
                         $rightcount++;
                         if (count($rdetail) > 0) {

                         } else {
                             $chk = new ReferralDetails();
                             $chk = $chk->where("referral_id", "=", $referral[0]->referral_id)->where("refree_id", "=", $res[0]->id)->where("is_counted", "=", 1)->where("position", "=", "Right")->get();


                             if (count($chk) > 0) {
                                 if ($res[0]->deposits > $chk[0]->reinvest) {
                                     $deposit = DB::table('deposits')->where('user_id', $res[0]->id)->orderBy('created_at', 'desc')->get();
                                     $rds = new ReferralDetails();
                                     $rds = $rds->where("referral_id", "=", $referral[0]->referral_id)->where("refree_id", "=", $res[0]->id)->where("is_counted", "=", 1)->where("position", "=", "Right")->get();
                                     $rdsamount = $rds[0]->refree_points + $deposit[0]->amount;
                                     DB::table('referral_details')
                                         ->where("referral_id", "=", $referral[0]->referral_id)
                                         ->where("refree_id", "=", $res[0]->id)
                                         ->where("is_counted", "=", 1)
                                         ->where("position", "=", "Right")
                                         ->update(['refree_points' => $rdsamount, 'reinvest' => $res[0]->deposits]);
                                     $ref = new Referrals();
                                     $pointright = $ref->where("referral_id", "=", $referral[0]->referral_id)->get();
                                     $pointright = $pointright[0]->point_right + $deposit[0]->amount;
                                     DB::table('referrals')
                                         ->where("user_id", "=", $user->id)
                                         ->update(['point_right' => $pointright]);

                                 }
                             } else {
                                 if ($res[0]->is_invest == 1) {
                                     $rd = new ReferralDetails();
                                     $rd->referral_id = $referral[0]->referral_id;
                                     $rd->refree_id = $res[0]->id;
                                     $rd->refree_points = $res[0]->balance;
                                     $rd->position = $res[0]->position;
                                     $rd->is_counted = "0";
                                     $rd->reinvest = "1";
                                     $rd->save();

                                     $rds = new ReferralDetails();
                                     $pointright = $rds->where("referral_id", "=", $referral[0]->referral_id)->where("is_counted", "=", 0)->where("position", "=", "Right")->sum('refree_points');
                                     $pointright += $referral[0]->point_right;
                                     DB::table('referrals')
                                         ->where("user_id", "=", $user->id)
                                         ->update(['referral_right' => $rightcount, 'point_right' => $pointright]);
                                     DB::table('referral_details')
                                         ->where("is_counted", "=", 0)
                                         ->where("position", "=", "Right")
                                         ->update(['is_counted' => 1]);
                                 }
                             }

                         }


                         $users = new User();
                         $res = $users->where('posid', '=', $res[0]->id)->where('position', '=', "Right")->get();

                     }
                 }


                 $referral = new Referrals();
                 $referral = $referral->where("user_id", "=", $user->id)->get();
                 if (count($referral) > 0) {
                     if ($referral[0]->binary_active == 1) {
                         $left = 0;
                         $right = 0;
                         if ($referral[0]->point_left > $referral[0]->point_right) {
                             $left = $referral[0]->point_left -= $referral[0]->point_right;
                             $right = 0;
                             $point = ($referral[0]->point_right * 10) / 100;
                             $user->network += $point;
                             DB::table('users')
                                 ->where("id", "=", $user->id)
                                 ->update(['network' => $user->network]);
                         } else if ($referral[0]->point_left < $referral[0]->point_right) {
                             $right = $referral[0]->point_right -= $referral[0]->point_left;
                             $left = 0;
                             $point = ($referral[0]->point_left * 10) / 100;
                             $user->network += $point;
                             //$user->save();
                             DB::table('users')
                                 ->where("id", "=", $user->id)
                                 ->update(['network' => $user->network]);
                         } else if ($referral[0]->point_left == $referral[0]->point_right) {
                             $right = 0;
                             $left = 0;
                             $point = ($referral[0]->point_right * 10) / 100;
                             $user->network += $point;
                             //$user['user']->save();
                             DB::table('users')
                                 ->where("id", "=", $user->id)
                                 ->update(['network' => $user->network]);
                         }

                         DB::table('referrals')
                             ->where("user_id", "=", $user->id)
                             ->update(['referral_left' => $leftcount, 'referral_right' => $rightcount, 'point_left' => $left, 'point_right' => $right]);
                     }
                 }
             }
         })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
