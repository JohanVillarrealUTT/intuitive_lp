<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $fillable = [
        'color',
        'name'
    ];

    public function subscribers()
    {
        return $this->hasMany('App\Entities\Subscriber');
    }
}
