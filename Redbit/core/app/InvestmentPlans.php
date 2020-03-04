<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentPlans extends Model
{
    protected $table = 'investment_plan';

    protected $guarded = ['package_id'];
}
