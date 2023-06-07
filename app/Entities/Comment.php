<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

  protected $fillable = ['id', 'comment', 'subscriber_id', 'user_id'];

  public function subscriber()
  {
    return $this->belongsTo('App\Entities\Subscriber');
  }

  public function user()
  {
    return $this->belongsTo('App\Entities\User');
  }

}
