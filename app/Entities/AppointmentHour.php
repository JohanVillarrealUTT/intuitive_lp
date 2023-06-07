<?php namespace App\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AppointmentHour extends Model {

    protected $fillable = [
        'hour',
        'max_capacity',
        'status',
        'appointment_date_id',
        'space_available',
        'type'
    ];

	public function date()
	{
		return $this->belongsTo('App\Entities\AppointmentDate', 'appointment_date_id');
	}

    public function subscribers()
    {
        return $this->belongsToMany('App\Entities\Subscriber', 'appointment_subscriber');
    }

    public function discountSpace()
    {   
        $this->decrement('space_available', 1);

        if ($this->space_available == 0) {
            $this->status = 'full';
            $this->save();

            $this->date->setStatusFull();
        }
    }

    public function sumSpace()
    {
        $date = Carbon::parse($this->date->date);

        if ($this->space_available == 0 && $date->isFuture()) {
          
            $this->status = 'available';
            $this->save();
            $this->date->setStatusAvailable();
        }

        if ($date->isFuture()) {
           
            $this->increment('space_available',1);
        }
    }

    public function isAvailable()
    {
        return $this->space_available > 0 && $this->status == 'available';
    }
}
