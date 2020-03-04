<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $guarded = ['id'];

    public function miner()

    {

        return $this->belongsTo(Category::class, 'category_id')->withDefault();

    }
}
