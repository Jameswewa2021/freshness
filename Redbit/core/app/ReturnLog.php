<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnLog extends Model
{

    protected $table = 'returns';

    protected $guarded = ['id'];
}
