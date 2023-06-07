<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {

    protected $table = 'area';
    protected $fillable = ['name', 'marketing_code', 'slug', 'value'];


	public function subscribers()
	{
		return $this->hasMany('App\Entities\Subscriber');
	}

}
