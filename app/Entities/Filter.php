<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model {

    protected $fillable = ['name', 'description', 'comments', 'color', 'style', 'action1','action2','action3','active'];

    public function subscriber()
    {
        return $this->belongsToMany('App\Entities\Subscriber','filter_subscriber')->withPivot('filter_id', 'subscriber_id');
    }

}
