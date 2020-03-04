<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{

    protected $guarded = ['id'];

    public function category()

    {

        return $this->belongsTo(Category::class)->withDefault();

    }
}
