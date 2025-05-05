<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Base {

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

	public function users() : BelongsToMany {
		return $this->belongsToMany(User::class);
	}

	public function patient() : BelongsTo {
		return $this->belongsTo(User::class, "id", "patient_id");
	}
}
