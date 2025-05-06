<?php

namespace App\Models;

use App\Models\Traits\HasNotes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Profile extends Base {

	use HasNotes;

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

	protected $attributes = [
		"dob"
	];

	/**
	 * Constructor
	 *
	 * @param  array  $attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct($attributes);
	}

	/**
	 * @return Attribute
	 */
	public function dob() : Attribute {
		return Attribute::make(get: fn ( $value ) => Carbon::parse($value)
														   ->format('m/d/Y'));
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
