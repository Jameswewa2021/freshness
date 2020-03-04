<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralDetails extends Model
{
    protected $table = 'referral_details';

    protected $guarded = ['rdid'];
}
