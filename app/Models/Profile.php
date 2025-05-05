<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Base {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'patient_id',
		'dob',
		'gender',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts() : array {
		return [
			'id'  => 'integer',
			'dob' => 'date',
		];
	}

	/**
	 * Constructor
	 *
	 * @param  array  $attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct($attributes);
	}

	/**
	 * Patient
	 *
	 * @return BelongsTo
	 */
	public function patient() : BelongsTo {
		return $this->belongsTo(User::class, "id", "patient_id");
	}
}
