<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanLog extends Model
{
    protected $guarded = ['id'];

    public function user()

    {

        return $this->belongsTo(User::class)->withDefault();

    }

    public function plan()

    {

        return $this->belongsTo(Plan::class)->withDefault();

    }
}
