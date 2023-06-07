<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

  protected $fillable = array('id', 'subscriber_id', 'fileurl');

  public function subscriber()
  {
    return $this->belongsTo('App\Entities\Subscriber');
  }

}
