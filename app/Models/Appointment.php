<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use App\Models\Traits\HasNotes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Base {

	use HasNotes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'type',
		'status',
		'date_and_time',
		'length',
		'title',
		'description',
		'patient_id',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts() : array {
		return [
			'id'            => 'integer',
			'date_and_time' => 'datetime',
			'patient_id'    => 'integer',
			'status'        => AppointmentStatus::class,
		];
	}

	public function __construct( array $attributes = [] ) {
		parent::__construct($attributes);
	}

	/**
	 * @return BelongsToMany
	 */
	public function users() : BelongsToMany {
		return $this->belongsToMany(User::class, "appointments_users", "appointment_id", "user_id");
	}

	/**
	 * @return BelongsTo
	 */
	public function patient() : BelongsTo {
		return $this->belongsTo(Patient::class, "id");
	}

	public function getDateAttribute() : string {
		return Carbon::parse($this->attributes[ 'date_and_time' ])
					 ->format('m/d/Y');
	}

	public function getTimeAttribute() : string {
		return Carbon::parse($this->attributes[ 'date_and_time' ])
					 ->format('h:i');
	}

	public function getDateAndTimeRangeAttribute() : string {
		$start = Carbon::parse($this->attributes[ 'date_and_time' ])->format('m/d/Y @ h:i A');
		$end = Carbon::parse($this->attributes[ 'date_and_time' ])->addMinutes($this->length)->format('h:i A');
		return "$start - $end";
	}
}
