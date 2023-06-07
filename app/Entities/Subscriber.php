<?php namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Subscriber extends Model {

	protected $perPage = 25;

    protected $appends = ['full_name'];

	protected $fillable = [
		'area_id',
		'name',
		'last_name',
		'nickname',
		'email',
		'birth_date',
		'gender',
		'marital_status',
		'phone',
		'home_phone',
		'zip_code',
		'address',
		'transportation',
		'visa',
		'school_degree',
		'school_name',
		'school_career',
		'school_training',
		'still_studying',
		'still_studying_name',
		'still_studying_schedule',
		'still_studying_school',
		'english',
		'emergency_contact_name',
		'emergency_contact_phone',
		'jobs',
		'vacancy_found_by',
		'referenced_by',
		'ex_worker',
		'system_status',
		'color_tag',
		'candidate',
		'rejected',
	];

	public function setEmailAttribute($value) {
		if (empty($value)) {
			$this->attributes['email'] = NULL;
		} else {
			$this->attributes['email'] = $value;
		}
	}

	public function file()
	{
	  return $this->hasOne('App\Entities\File');
	}

	public function comment()
	{
	  return $this->hasOne('App\Entities\Comment');
	}

	public function comments()
	{
	  return $this->hasMany('App\Entities\Comment');
	}

	public function filter()
    {
        return $this->belongsToMany('App\Entities\Filter', 'filter_subscriber')->withPivot('filter_id', 'subscriber_id');
    }

	public function type()
	{
		return $this->BelongsTo('App\Entities\Comment');
	}

	public function label()
	{
		return $this->belongsTo('App\Entities\Label');
	}

	public function appointments()
	{
		return $this->belongsToMany('App\Entities\AppointmentHour', 'appointment_subscriber', 'subscriber_id' ,'appointment_hour_id')
			->withTimestamps()
			->withPivot('comment', 'status', 'created_by', 'id')
			->orderBy('created_at', 'desc');
	}

	public function getPaginated(array $params)
	{
		if ($this->isSortable($params)) {
			if (isset($params['type']) && $params['type'] != 'all')
				if ($params['sortBy'] == 'cv') {
					$params['sortBy'] = 'subscriber_id';
					return $this->leftJoin('files', 'files.subscriber_id', '=', 'subscribers.id')->select('subscribers.*')->where('system_status', $params['type'])->orderBy($params['sortBy'], $params['direction'])->paginate($params['rowsByPage']);
				} else {
					return $this->where('system_status', $params['type'])->orderBy($params['sortBy'], $params['direction'])->paginate($params['rowsByPage']);
				}
			else if (!isset($params['type']) || $params['type'] == 'all')
				if ($params['sortBy'] == 'cv') {
					$params['sortBy'] = 'subscriber_id';
					return $this->leftJoin('files', 'files.subscriber_id', '=', 'subscribers.id')->select('subscribers.*')->orderBy($params['sortBy'], $params['direction'])->paginate($params['rowsByPage']);
				} else {
					return $this->orderBy($params['sortBy'], $params['direction'])->paginate($params['rowsByPage']);
				}
		} else {
			if (isset($params['type']) && $params['type'] != 'all')
				return $this->where('system_status', $params['type'])->paginate($params['rowsByPage']);
			else if (!isset($params['type']) || $params['type'] == 'all')
				return $this->paginate($params['rowsByPage']);
		}

		return $this->paginate($params['rowsByPage']);
	}

	protected function isSortable(array $params)
	{
		return $params['sortBy'] and $params['direction'] and $params['rowsByPage'] and $params['type'];
	}

	public function getFullNameAttribute()
	{
		return  "{$this->name} {$this->last_name}";
	}
}
