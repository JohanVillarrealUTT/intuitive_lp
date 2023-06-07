<?php 
namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class SubscriberAppointment extends Model {

    protected $fillable = [
        'comment',
        'status',
        'appointment_hour_id',
        'subscriber_id'
    ];

	public function hour()
	{
		return $this->belongsTo('App\Entities\AppointmentHour', 'appointment_hour_id');
	}
    
    public function subscriber() 
    {
        return $this->belongsTo('App\Entities\User');
    }
}
