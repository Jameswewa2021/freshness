<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    protected $table = 'bonus';
    protected $guarded = ['bonus_id'];
}
