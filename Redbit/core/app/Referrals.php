<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referrals extends Model
{
    protected $table = 'referrals';

    protected $guarded = ['referral_id'];
}
