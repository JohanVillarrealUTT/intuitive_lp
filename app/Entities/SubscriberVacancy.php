<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class SubscriberVacancy extends Model
{
    protected $fillable = [
		'job_interest',
		'name',
		'last_name',
        'phone',
		'email',
		'work_experience',
        'equipment_handling',
        'material_control',
        'schedule_availability',
        'certificate'.
        'english_level',
        'cv_path',

	];

}
