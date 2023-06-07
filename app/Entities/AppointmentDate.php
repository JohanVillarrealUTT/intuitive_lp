<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class AppointmentDate extends Model {

    protected $fillable = [
        'date',
        'status',
        'user_id'
    ];

	public function hours()
	{
		return $this->hasMany('App\Entities\AppointmentHour');
	}
    
    public function user() 
    {
        return $this->belongsTo('App\Entities\User');
    }

    public function setStatusFull()
    {
        $has_available_hours = $this->hours->where('status', 'available')->count();
        
        if (! $has_available_hours) {
            $this->status = 'full';
            $this->save();
        }
    }

    public function setStatusAvailable()
    {
        $has_available_hours = $this->hours->where('status', 'available')->count();
        
        if ($has_available_hours) {
            $this->status = 'available';
            $this->save();
        }
    }
}
